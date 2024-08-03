<?php

namespace developermarius\applebusinessconnect\api;

use developermarius\applebusinessconnect\api\exceptions\AppleClientAuthException;
use developermarius\applebusinessconnect\api\exceptions\AppleClientResponseException;
use developermarius\applebusinessconnect\api\models\AppleAggregateRatingDetails;
use developermarius\applebusinessconnect\api\models\AppleAggregateRatingResponse;
use developermarius\applebusinessconnect\api\models\AppleBusinessAssetResponse;
use developermarius\applebusinessconnect\api\models\AppleBusinessAssetDetails;
use developermarius\applebusinessconnect\api\models\AppleBusinessDetail;
use developermarius\applebusinessconnect\api\models\AppleBusinessEditResponse;
use developermarius\applebusinessconnect\api\models\AppleBusinessPaginationResponse;
use developermarius\applebusinessconnect\api\models\AppleFeedbackPaginationResponse;
use developermarius\applebusinessconnect\api\models\AppleNotificationPaginationResponse;
use developermarius\applebusinessconnect\api\models\AppleResourceType;
use developermarius\applebusinessconnect\api\models\AppleLocationAssetDetails;
use developermarius\applebusinessconnect\api\models\AppleLocationAssetPaginationResponse;
use developermarius\applebusinessconnect\api\models\AppleLocationAssetResponse;
use developermarius\applebusinessconnect\api\models\AppleLocationCallToActionResponse;
use developermarius\applebusinessconnect\api\models\AppleLocationDetails;
use developermarius\applebusinessconnect\api\models\AppleLocationPaginationResponse;
use developermarius\applebusinessconnect\api\models\AppleLocationReadResponse;
use developermarius\applebusinessconnect\api\models\AppleMediaReadResponse;
use developermarius\applebusinessconnect\api\models\AppleReviewDetails;
use developermarius\applebusinessconnect\api\models\AppleReviewResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

class AppleBusinessConnectClient {

    const BASE_GRAPH_URL_AQE = 'https://api-qualification.businessconnect.apple.com';
    const BASE_GRAPH_URL_DQE = 'https://data-qualification.businessconnect.apple.com';
    const BASE_GRAPH_URL_PRODUCTION = 'https://businessconnect.apple.com';

    //Requirements: https://businessconnect.apple.com/docs/onboarding-guide/api-onboarding#api-integration-exit-criteria
    //https://businessconnect.apple.com/docs/onboarding-guide/api-onboarding#request-data-qualification-verification

    //Environment 	Path {url}
    //AQE 	        https://api-qualification.businessconnect.apple.com         API integration (AQE) exit criteria
    //DQE 	        https://data-qualification.businessconnect.apple.com
    //Production 	https://businessconnect.apple.com

    protected string $graphApiVersion = 'v1';
    protected array $scope = array();
    private ?Client $http_client = null;
    protected ?AccessToken $token = null;

    public function __construct(protected string $client_id, protected string $client_secret, protected string $company_id, protected string $base_graph_url = self::BASE_GRAPH_URL_PRODUCTION){
        /*parent::__construct(array(
            'clientId' => Config::getAppleClientId(),
            'clientSecret' => Config::getAppleClientSecret(),
            'redirectUri' => Config::getPanelUrl() . '/public-api/extension/' . AppleLocationService::getName() . '/connected',
            'graphApiVersion' => $this->graphApiVersion
        ));*/
    }

    public function getCompanyId(): string{
        return $this->company_id;
    }

    public function getClientId(): string{
        return $this->client_id;
    }

    public function getClientSecret(): string{
        return $this->client_secret;
    }

    /**
     * @return AccessToken|null
     */
    public function getToken(): ?AccessToken{
        return $this->token;
    }

    private function getHttpClient(): Client{
        if($this->http_client === null){
            $stack = new HandlerStack();
            $stack->setHandler(new CurlHandler());
            /*$stack->push(Middleware::mapRequest(function(RequestInterface $response) {
                error_log($response->getMethod() . ' ' . $response->getUri());
                error_log($response->getBody());
                return $response;
            }));*/
            $stack->push(Middleware::mapResponse(function(ResponseInterface $response){
                error_log($response->getBody());
                error_log($response->getStatusCode());
                if($response->getStatusCode() < 200 || $response->getStatusCode() > 299){

                    //[{"code":"Unauthorized","message":"Expired Token","details":{"header":"Authorization"}}]
                    if($response->getStatusCode() === 401)
                        throw new AppleClientAuthException('Apple Business Connect API authentication failed');

                    $data = json_decode($response->getBody(), true);
                    if(isset($data['error']))
                        throw new AppleClientResponseException($data['message'], $response->getStatusCode());
                }
                return $response;
            }));
            $this->http_client = new Client(array(
                'base_uri' => $this->getBaseGraphUrl() . '/api/' . $this->graphApiVersion . '/',
                /*'headers' => array(
                    'Authorization' => 'Bearer ' . $this->getToken()->getToken()
                ),*/
                'handler' => $stack
            ));
        }
        return $this->http_client;
    }

    private ?ResponseInterface $last_response = null;

    /**
     * @return ResponseInterface|null
     */
    public function getLastResponse(): ?ResponseInterface{
        return $this->last_response;
    }

    public function getLastResponseRequestId(): ?string{
        if($this->getLastResponse() === null)
            return null;
        return $this->getLastResponse()->getHeader('apple-request-id')[0] ?? null;
    }

    /**
     * @throws GuzzleException
     * @throws AppleClientResponseException -> Thrown in middleware
     * @throws AppleClientAuthException -> Thrown in middleware
     */
    private function request(string $method, string $uri, array $options = array(), string $etag = null, bool $auth = true): ?array{
        if(!isset($options['headers']))
            $options['headers'] = array();
        if($etag !== null)
            $options['headers']['if-match'] = $etag;
        if($auth) {
            if ($this->getToken() === null || $this->getToken()->hasExpired())
                $this->token = $this->requestAccessToken();
            $options['headers']['Authorization'] = 'Bearer ' . $this->getToken()->getToken();
        }
        $response = $this->getHttpClient()->request($method, $uri, $options);
        $this->last_response = $response;

        if($response->getStatusCode() < 200 || $response->getStatusCode() > 299)
            return null;
        if($response->getStatusCode() === 204)
            return array();
        return json_decode($response->getBody(), true);
    }

    /**
     * Get the base Graph API URL.
     */
    protected function getBaseGraphUrl(): string{
        return $this->base_graph_url;//'https://businessconnect.apple.com';
    }

    public function requestAccessToken(): AccessToken{
        return new AccessToken($this->request('POST', 'oauth2/token', array(
            'json' => array(
                'client_id' => $this->getClientId(),
                'client_secret' => $this->getClientSecret(),
                'grant_type' => "client_credentials",
                'scope' => "business_connect"
            )
        ), auth: false));
    }

    public function createLocation(AppleLocationDetails $locationDetails): ?AppleLocationReadResponse{
        //https://businessconnect.apple.com/docs/api/v1/location/create
        $response = $this->request('POST', 'companies/' . $this->getCompanyId() . '/locations', array(
            'json' => array(
                'locationDetails' => $locationDetails
            )
        ));
        if($response === null)
            return null;
        return new AppleLocationReadResponse($response);

        //Request:
        /*
         * {
  "locationDetails": {
    "partnersLocationId": "4",
    "partnersLocationVersion": "PV01",
    "businessId": "1541464898790064128",
    "displayNames": [
      {
        "name": "xyz GmbH",
        "locale": "de-DE",
        "primary": true
      }
    ],
    "storeCode": "#123",
    "internalNicknames": [
      {
        "name": "Thinking space",
        "locale": "de-DE"
      }
    ],
    "mainAddress": {
      "structuredAddress": {
        //"floor": "",
        "thoroughfare": "street",//street name
        "subThoroughfare": "16",//street number
        "fullThoroughfare": "street 16",//full street
        //"subLocality": "",
        "locality": "Frankfurt am Main",
        "administrativeArea": "Hessen",
        "postCode": "60385",
        "countryCode": "DE"
      },
      "locale": "de-DE"
    },
    "urls": [
      {
        "url": "http://example.com",
        "type": "HOMEPAGE"
      }
    ],
    "locationDescriptions": [
      {
        "type": "ABOUT",
        "descriptions": [
          {
            "text": "Established in 1984, Malibu Ice Cream handcrafts artisan super premium ice creams, dairy-free fruit juices and frozen yogurt! We are the home of world famous Mexican Vanilla Ice Cream. Explore your favorite flavors at Malibu IceCream.",
            "locale": "de-DE"
          }
        ]
      }
    ],
    "openingHoursByDay": [
      {
        "day" : "MONDAY",
        "times" : [
          {
            "startTime" : "10:00",
            "endTime" : "22:00"
          }
        ]
      },
      {
        "day" : "TUESDAY",
        "times" : [
          {
            "startTime" : "10:00",
            "endTime" : "22:00"
          }
        ]
      },
      {
        "day" : "WEDNESDAY",
        "times" : [
          {
            "startTime" : "10:00",
            "endTime" : "22:00"
          }
        ]
      },
      {
        "day" : "THURSDAY",
        "times" : [
          {
            "startTime" : "10:00",
            "endTime" : "22:00"
          }
        ]
      },
      {
        "day" : "FRIDAY",
        "times" : [
          {
            "startTime" : "10:00",
            "endTime" : "22:00"
          }
        ]
      },
      {
        "day" : "SATURDAY",
        "times" : [
          {
            "startTime" : "09:00",
            "endTime" : "23:30"
          }
        ]
      }
    ],
    "specialHours": [
      {
        "hoursByDay": [
          {
            "day" : "SUNDAY",
            "times" : [
              {
                "startTime" : "09:00",
                "endTime" : "12:00"
              }
            ]
          }
        ],
        "startDate": "2022-12-25",
        "endDate": "2022-12-25",
        "closed": false,
        "descriptions": [
          {
            "text": "Weihnachten",
            "locale": "de-DE"
          }
        ]
      }
    ],
    "categories": [ "food.desserts", "food.gelato", "health.dietitians" ],
    "locationAttributes": [
      {
        "type": "crossbusiness.restrooms.gender_neutral_restroom",
        "provided": true
      }
    ],
    "paymentMethods": [ "VISA", "MASTERCARD"],
    "displayPoint": {
      "coordinates": {
        "latitude": "52.358834",
        "longitude": "4.893834"
      },
      "source": "MANUALLY_PLACED"
    },
    "phoneNumbers": [
      {
        "phoneNumber": "+4915731626185",
        "type": "LANDLINE",
        "primary": true
      }
    ],
    "locationStatus": {
      "status": "OPEN"
    },
    "actionLinkDetails": {
      "quicklinks": [
        {
          "category": "quicklinks.restaurant_order_food",
          "quicklinkUrl": "https://www.provider.com/menu/malibu-icecream",
          "appStoreUrl": "https://apps.apple.com/us/app/provider-name-food-delivery/id284910350",
          "relationship": "AUTHORIZED"
        }
      ]
    }
  }
}
         */
        //Response:
        /*
         * {
    "id": "1549569011482624136",
    "companyId": "1469747224475254784",
    "createdDate": "2024-02-08T12:21:32.384Z",
    "updatedDate": "2024-02-08T12:21:32.384Z",
    "etag": "97efbee0-c67c-11ee-9fa2-bd56c408e948",
    "state": "SUBMITTED",
    "locationDetails": {
        "businessId": "1541464898790064128",
        "partnersLocationId": "4",
        "partnersLocationVersion": "PV01",
        "displayNames": [
            {
                "name": "xyz GmbH",
                "locale": "de-DE",
                "primary": true
            }
        ],
        "displayPoint": {
            "coordinates": {
                "latitude": "52.358834",
                "longitude": "4.893834"
            },
            "source": "MANUALLY_PLACED"
        },
        "mainAddress": {
            "structuredAddress": {
                "thoroughfare": "street",
                "subThoroughfare": "16",
                "fullThoroughfare": "street 16",
                "locality": "Frankfurt am Main",
                "administrativeArea": "Hessen",
                "postCode": "60385",
                "countryCode": "DE"
            },
            "locale": "de-DE"
        },
        "locationStatus": {
            "status": "OPEN"
        },
        "categories": [
            "food.desserts",
            "food.gelato",
            "health.dietitians"
        ],
        "openingHoursByDay": [
            {
                "day": "MONDAY",
                "times": [
                    {
                        "startTime": "10:00",
                        "endTime": "22:00"
                    }
                ]
            },
            {
                "day": "TUESDAY",
                "times": [
                    {
                        "startTime": "10:00",
                        "endTime": "22:00"
                    }
                ]
            },
            {
                "day": "WEDNESDAY",
                "times": [
                    {
                        "startTime": "10:00",
                        "endTime": "22:00"
                    }
                ]
            },
            {
                "day": "THURSDAY",
                "times": [
                    {
                        "startTime": "10:00",
                        "endTime": "22:00"
                    }
                ]
            },
            {
                "day": "FRIDAY",
                "times": [
                    {
                        "startTime": "10:00",
                        "endTime": "22:00"
                    }
                ]
            },
            {
                "day": "SATURDAY",
                "times": [
                    {
                        "startTime": "09:00",
                        "endTime": "23:30"
                    }
                ]
            }
        ],
        "phoneNumbers": [
            {
                "phoneNumber": "+4915731626185",
                "type": "LANDLINE",
                "primary": true
            }
        ],
        "urls": [
            {
                "url": "http://example.com",
                "type": "HOMEPAGE"
            }
        ],
        "locationAttributes": [
            {
                "type": "crossbusiness.restrooms.gender_neutral_restroom",
                "provided": true
            }
        ],
        "paymentMethods": [
            "VISA",
            "MASTERCARD"
        ],
        "specialHours": [
            {
                "hoursByDay": [
                    {
                        "day": "SUNDAY",
                        "times": [
                            {
                                "startTime": "09:00",
                                "endTime": "12:00"
                            }
                        ]
                    }
                ],
                "startDate": "2022-12-25",
                "endDate": "2022-12-25",
                "closed": false,
                "descriptions": [
                    {
                        "text": "Weihnachten",
                        "locale": "de-DE"
                    }
                ]
            }
        ],
        "locationDescriptions": [
            {
                "type": "ABOUT",
                "descriptions": [
                    {
                        "text": "Established in 1984, Malibu Ice Cream handcrafts artisan super premium ice creams, dairy-free fruit juices and frozen yogurt! We are the home of world famous Mexican Vanilla Ice Cream. Explore your favorite flavors at Malibu IceCream.",
                        "locale": "de-DE"
                    }
                ]
            }
        ],
        "actionLinkDetails": {
            "quicklinks": [
                {
                    "category": "quicklinks.restaurant_order_food",
                    "quicklinkUrl": "https://www.provider.com/menu/malibu-icecream",
                    "appStoreUrl": "https://apps.apple.com/us/app/provider-name-food-delivery/id284910350",
                    "relationship": "AUTHORIZED"
                }
            ]
        },
        "storeCode": "#123",
        "internalNicknames": [
            {
                "name": "Thinking space",
                "locale": "de-DE"
            }
        ]
    },
    "validationReports": []
}
         */
    }

    /**
     * @see https://businessconnect.apple.com/docs/api/v1/location/get_by_id
     */
    public function getLocationById(string $location_id): ?AppleLocationReadResponse{
        $response = $this->request('GET', 'companies/' . $this->getCompanyId() . '/locations/' . $location_id);
        if($response === null)
            return null;
        return new AppleLocationReadResponse($response);
    }

    /**
     * @see https://businessconnect.apple.com/docs/api/v1/location/get_by_partner_id
     */
    public function getLocationByPartnerId(string $partner_id): ?AppleLocationReadResponse{
        $response = $this->request('GET', 'companies/' . $this->getCompanyId() . '/locations/by-partner-locationId/' . $partner_id);
        if($response === null)
            return null;
        return new AppleLocationReadResponse($response);
    }

    public function getLocations(string $filter = null, string $after = null, int $limit = null): ?AppleLocationPaginationResponse{
        //https://businessconnect.apple.com/docs/api/v1/location/get
        //For filtering see https://businessconnect.apple.com/docs/api/v1/references/filtering
        $response = $this->request('GET', 'companies/' . $this->getCompanyId() . '/locations', array(
            'query' => array(
                'after' => $after,
                'limit' => $limit,
                'ql' => $filter
            )
        ));
        if($response === null)
            return null;
        return new AppleLocationPaginationResponse($response);
    }

    /**
     * @see https://businessconnect.apple.com/docs/api/v1/location/update
     */
    public function updateLocation(string $location_id, AppleLocationDetails $location_details, string $etag): ?AppleLocationReadResponse{
        //https://businessconnect.apple.com/docs/api/v1/location/update
        $response = $this->request('PUT', 'companies/' . $this->getCompanyId() . '/locations/' . $location_id, array(
            'json' => array(
                'id' => $location_id,
                'locationDetails' => $location_details
            )
        ), $etag);
        if($response === null)
            return null;
        return new AppleLocationReadResponse($response);
    }

    /**
     * @see https://businessconnect.apple.com/docs/api/v1/location/delete
     */
    public function deleteLocation(string $location_id, string $etag): ?string{
        if($this->request('DELETE', 'companies/' . $this->getCompanyId() . '/locations/' . $location_id, etag: $etag) !== null)
            return $this->getLastResponse()->getHeader('etag')[0];
        return null;
    }

    /**
     * @see https://businessconnect.apple.com/docs/api/v1/location/undelete
     */
    public function undeleteLocation(string $location_id, string $etag): ?AppleLocationReadResponse{
        $response = $this->request('POST', 'companies/' . $this->getCompanyId() . '/locations/' . $location_id . '/undelete', etag: $etag);
        if($response === null)
            return null;
        return new AppleLocationReadResponse($response);
    }

    public function getLocationCallsToAction(string $location_id, int $limit = null): ?AppleLocationCallToActionResponse{
        $response = $this->request('GET', 'companies/' . $this->getCompanyId() . '/locations/' . $location_id . '/calls-to-action');
        if($response === null)
            return null;
        return new AppleLocationCallToActionResponse($response);
    }

    /**
     * @see https://businessconnect.apple.com/docs/api/v1/location_asset/create
     */
    public function createLocationAsset(string $location_id, AppleLocationAssetDetails $asset_details): ?AppleLocationAssetResponse{
        //https://businessconnect.apple.com/docs/api/v1/asset/create
        $response = $this->request('POST', 'companies/' . $this->getCompanyId() . '/locations/' . $location_id . '/assets', array(
            'json' => array(
                'assetDetails' => $asset_details
            )
        ));
        if($response === null)
            return null;
        return new AppleLocationAssetResponse($response);
        //Request:
        /*
         {
  "assetDetails": {
    "partnersAssetId": "9090909090",
    "dateAdded": "2022-09-10T12:45:34.000Z",
    "capturedBy": "Jane D.",
    "intent": "GALLERY",
    "captions": [
      {
        "title": "Exterior View",
        "altText": "Storefront and and outdoor patio with tables and chairs",
        "locale": "en-US"
      }
    ],
    "coordinates": {
      "longitude": "-97.7199035",
      "latitude": "30.2210519"
    },
    "classifications": [ "exterior", "outdoors" ],
    "source": "USER",
    "photos": {
      "xxlarge": {
        "url": "http://goodpartner.com/images/malibuicecream/3887887.jpg",
        "pixelHeight": 1200,
        "pixelWidth": 1200
      }
    }
  }
}
         */
        //Response:
        /*
         {
    "companyId": "1469747224475254784",
    "locationId": "1549569011482624136",
    "id": "1851310187914199046",
    "createdDate": "2024-02-09T19:03:17.663Z",
    "updatedDate": "2024-02-09T19:03:17.663Z",
    "state": "SUBMITTED",
    "etag": "e24d72f0-c77d-11ee-ada9-31f0b1fd693e",
    "assetDetails": {
        "partnersAssetId": "9090909090",
        "dateAdded": "2022-09-10T12:45:34.000Z",
        "intent": "GALLERY",
        "captions": [
            {
                "title": "Exterior View",
                "altText": "Storefront and and outdoor patio with tables and chairs",
                "locale": "en-US"
            }
        ],
        "source": "USER",
        "capturedBy": "Jane D.",
        "classifications": [
            "exterior",
            "outdoors"
        ],
        "coordinates": {
            "latitude": "30.2210519",
            "longitude": "-97.7199035"
        },
        "photos": {
            "xxlarge": {
                "pixelHeight": 1200,
                "pixelWidth": 1200,
                "url": "http://goodpartner.com/images/malibuicecream/3887887.jpg"
            }
        }
    },
    "validationReports": []
}
         */
    }

    public function getLocationAssetById(string $location_id, string $asset_id): ?AppleLocationAssetResponse{
        $response = $this->request('GET', 'companies/' . $this->getCompanyId() . '/locations/' . $location_id . '/assets/' . $asset_id);
        if($response === null)
            return null;
        return new AppleLocationAssetResponse($response);
    }

    public function getLocationAssets(string $location_id, string $filter = null, string $after = null, int $limit = null): ?AppleLocationAssetPaginationResponse{
        //https://businessconnect.apple.com/docs/api/v1/location_asset/get
        //For filtering see https://businessconnect.apple.com/docs/api/v1/references/filtering
        $response = $this->request('GET', 'companies/' . $this->getCompanyId() . '/locations/' . $location_id . '/assets', array(
            'query' => array(
                'after' => $after,
                'limit' => $limit,
                'ql' => $filter
            )
        ));
        if($response === null)
            return null;
        return new AppleLocationAssetPaginationResponse($response);
    }

    /**
     * @see https://businessconnect.apple.com/docs/api/v1/location_asset/update
     */
    public function updateLocationAsset(string $location_id, string $asset_id, AppleLocationAssetDetails $asset_details, string $etag): ?AppleLocationAssetResponse{
        $response = $this->request('PUT', 'companies/' . $this->getCompanyId() . '/locations/' . $location_id . '/assets/' . $asset_id, array(
            'json' => array(
                'id' => $asset_id,
                'assetDetails' => $asset_details
            )
        ), $etag);
        if($response === null)
            return null;
        return new AppleLocationAssetResponse($response);
    }

    /**
     * @see https://businessconnect.apple.com/docs/api/v1/location_asset/delete
     */
    public function deleteLocationAsset(string $location_id, string $asset_id, string $etag): bool{
        return $this->request('DELETE', 'companies/' . $this->getCompanyId() . '/locations/' . $location_id . '/assets/' . $asset_id, etag: $etag) !== null;
    }

    /**
     * @see https://businessconnect.apple.com/docs/api/v1/location_asset/undelete
     */
    public function undeleteLocationAsset(string $location_id, string $asset_id, string $etag): ?AppleLocationAssetResponse{
        $response = $this->request('POST', 'companies/' . $this->getCompanyId() . '/locations/' . $location_id . '/assets/' . $asset_id . '/undelete', etag: $etag);
        if($response === null)
            return null;
        return new AppleLocationAssetResponse($response);
    }

    public function createBusiness(AppleBusinessDetail $business_detail): ?AppleBusinessEditResponse
    {
        //https://businessconnect.apple.com/docs/api/v1/business/create
        $response = $this->request('POST', 'companies/' . $this->getCompanyId() . '/businesses', array(
            'json' => array(
                'businessDetails' => $business_detail
            )
        ));
        if($response === null)
            return null;
        return new AppleBusinessEditResponse($response);
        //Request:
        /*
         {
   "businessDetails": {
    "partnersBusinessId": "1",
    "partnersBusinessVersion": "PBV01",
    "countryCodes": [ "DE" ],
    "displayNames": [
      {
        "name": "Test Business 1",
        "locale": "de",
        "primary": true
      }
    ],
    "categories": [ "food.desserts", "food.gelato" ],
    "urls": [
      {
        "url": "https://example.com",
        "type": "HOMEPAGE"
      }
    ]
  }
}
         */

        //Response:
        /*
        {
    "id": "1541464898790064128",
    "state": "SUBMITTED",
    "createdDate": "2024-02-08T12:06:50.678Z",
    "updatedDate": "2024-02-08T12:06:50.678Z",
    "validationReports": [],
    "etag": "b960bbbe-dd3b-41db-9550-e480d0beb2b0",
    "companyId": "1469747224475254784",
    "businessDetails": {
        "partnersBusinessId": "4",
        "partnersBusinessVersion": "PBV01",
        "countryCodes": [
            "DE"
        ],
        "displayNames": [
            {
                "name": "Test Business 4",
                "locale": "de",
                "primary": true
            }
        ],
        "categories": [
            "food.desserts",
            "food.gelato"
        ],
        "urls": [
            {
                "url": "https://example4.com",
                "type": "HOMEPAGE"
            }
        ]
    }
}
         */
    }

    public function updateBusiness(string $business_id, AppleBusinessDetail $business_detail, string $etag): ?AppleBusinessEditResponse
    {
        //https://businessconnect.apple.com/docs/api/v1/business/update
        $response = $this->request('PUT', 'companies/' . $this->getCompanyId() . '/businesses/' . $business_id, array(
            'json' => array(
                'id' => $business_id,
                'businessDetails' => $business_detail
            )
        ), $etag);
        if($response === null)
            return null;
        return new AppleBusinessEditResponse($response);
        //Request:
        //Header: if-match: 46c77276-5f27-4f43-a955-9640ed3c5b78
        /*
        {
  "id": "1574554842258538496",
  "businessDetails": {
    "partnersBusinessId": "1",
    "partnersBusinessVersion": "PBV01",
    "countryCodes": [ "DE" ],
    "displayNames": [
      {
        "name": "Test Business 1",
        "locale": "de",
        "primary": true
      }
    ],
    "categories": [ "food.desserts"],
    "urls": [
      {
        "url": "https://example.com",
        "type": "HOMEPAGE"
      }
    ]
  }
}
         */

        //Response:
        /*
         {
    "id": "1574554842258538496",
    "state": "SUBMITTED",
    "createdDate": "2024-02-08T08:43:02.636Z",
    "updatedDate": "2024-02-08T09:12:26.782Z",
    "validationReports": [],
    "etag": "48f621eb-73af-45fa-8572-2a55efefdbdc",
    "companyId": "1469747224475254784",
    "businessDetails": {
        "partnersBusinessId": "1",
        "partnersBusinessVersion": "PBV01",
        "countryCodes": [
            "DE"
        ],
        "displayNames": [
            {
                "name": "Test Business 1",
                "locale": "de",
                "primary": true
            }
        ],
        "categories": [
            "food.desserts"
        ],
        "urls": [
            {
                "url": "https://example.com",
                "type": "HOMEPAGE"
            }
        ]
    }
}
         */
    }

    public function deleteBusiness(string $business_id, string $etag): bool{
        //https://businessconnect.apple.com/docs/api/v1/business/delete
        return $this->request('DELETE', 'companies/' . $this->getCompanyId() . '/businesses/' . $business_id, etag: $etag) !== null;

        //Request:
        //Header: if-match: 48f621eb-73af-45fa-8572-2a55efefdbdc

        //Response: code 204
    }

    public function getBusinessById(string $business_id): ?AppleBusinessEditResponse
    {
        //https://businessconnect.apple.com/docs/api/v1/business/get_by_id
        $response = $this->request('GET', 'companies/' . $this->getCompanyId() . '/businesses/' . $business_id);
        if($response === null)
            return null;
        return new AppleBusinessEditResponse($response);
    }

    public function getBusinesses(string $filter = null, string $after = null, int $limit = null): ?AppleBusinessPaginationResponse
    {
        //https://businessconnect.apple.com/docs/api/v1/business/get
        //For filtering see https://businessconnect.apple.com/docs/api/v1/references/filtering
        //Response:
        /*
         {
    "data": [
        {
            "id": "1541464898790064128",
            "state": "PUBLISHED",
            "createdDate": "2024-02-08T12:06:50.678Z",
            "updatedDate": "2024-02-08T12:21:33.676Z",
            "validationReports": [],
            "etag": "b960bbbe-dd3b-41db-9550-e480d0beb2b0",
            "companyId": "1469747224475254784",
            "businessDetails": {
                "partnersBusinessId": "4",
                "partnersBusinessVersion": "PBV01",
                "countryCodes": [
                    "DE"
                ],
                "displayNames": [
                    {
                        "name": "Test Business 4",
                        "locale": "de",
                        "primary": true
                    }
                ],
                "categories": [
                    "food.desserts",
                    "food.gelato"
                ],
                "urls": [
                    {
                        "url": "https://example4.com",
                        "type": "HOMEPAGE"
                    }
                ]
            }
        }
    ],
    "pagination": {
        "cursors": {
            "after": null
        },
        "next": null
    },
    "total": 1
}
         */
        $response = $this->request('GET', 'companies/' . $this->getCompanyId() . '/businesses', array(
            'query' => array(
                'after' => $after,
                'limit' => $limit,
                'ql' => $filter
            )

        ));
        if($response === null)
            return null;
        return new AppleBusinessPaginationResponse($response);
    }

    /**
     * @see https://businessconnect.apple.com/docs/api/v1/business_asset/create
     */
    public function createBusinessAsset(string $business_id, AppleBusinessAssetDetails $business_asset_detail): ?AppleBusinessAssetResponse{
        $response = $this->request('POST', 'companies/' . $this->getCompanyId() . '/businesses/' . $business_id . '/assets', array(
            'json' => array(
                'businessAssetDetails' => $business_asset_detail
            )
        ));
        if($response === null)
            return null;
        return new AppleBusinessAssetResponse($response);
        //Request:
        /*
         * {
  "businessAssetDetails": {
    "imageId": "5154f9da-c079-4ea6-a145-8e53341a463d",
    "partnersAssetId": "business_asset_10101",
    "intent": "PLACECARD_LOGO",
    "altTexts": [
      {
        "text": "A barista preparing a cafe latte",
        "locale": "de-DE"
      }
    ]
  }
}
         */
        //Response:
        /*
         {
    "id": "1500026630454247424",
    "state": "SUBMITTED",
    "createdDate": "2024-02-08T13:49:17.365Z",
    "updatedDate": "2024-02-08T13:49:17.365Z",
    "validationReports": [],
    "etag": "5a6c2b07-343c-4369-9c25-8ac6cdec2d33",
    "companyId": "1469747224475254784",
    "businessId": "1541464898790064128",
    "businessAssetDetails": {
        "imageId": "5154f9da-c079-4ea6-a145-8e53341a463d",
        "partnersAssetId": "business_asset_10101",
        "intent": "PLACECARD_LOGO",
        "altTexts": [
            {
                "text": "A barista preparing a cafe latte",
                "locale": "de-DE"
            }
        ]
    }
}
         */
    }

    /**
     * @see https://businessconnect.apple.com/docs/api/v1/business_asset/get_by_id
     */
    public function getBusinessAssetById(string $business_id, string $asset_id): ?AppleBusinessAssetResponse
    {
        $response = $this->request('GET', 'companies/' . $this->getCompanyId() . '/businesses/' . $business_id . '/assets/' . $asset_id);
        if($response === null)
            return null;
        return new AppleBusinessAssetResponse($response);
        //Response:
        /*
         {
    "id": "1500026630454247424",
    "state": "REJECTED",
    "createdDate": "2024-02-08T13:49:17.365Z",
    "updatedDate": "2024-02-08T13:50:20.527Z",
    "validationReports": [],
    "etag": "5a6c2b07-343c-4369-9c25-8ac6cdec2d33",
    "companyId": "1469747224475254784",
    "businessId": "1541464898790064128",
    "businessAssetDetails": {
        "imageId": "5154f9da-c079-4ea6-a145-8e53341a463d",
        "partnersAssetId": "business_asset_10101",
        "intent": "PLACECARD_LOGO",
        "altTexts": [
            {
                "text": "A barista preparing a cafe latte",
                "locale": "de-DE"
            }
        ]
    }
}
         */
    }

    /**
     * @see https://businessconnect.apple.com/docs/api/v1/business_asset/get
     */
    public function getBusinessAssets(string $business_id, string $filter = null, string $after = null, int $limit = null): ?AppleBusinessAssetResponse
    {
        //For filtering see https://businessconnect.apple.com/docs/api/v1/references/filtering
        $response = $this->request('GET', 'companies/' . $this->getCompanyId() . '/businesses/' . $business_id . '/assets', array(
            'query' => array(
                'after' => $after,
                'limit' => $limit,
                'ql' => $filter
            )
        ));
        if ($response === null)
            return null;
        return new AppleBusinessAssetResponse($response);
    }

    public function updateBusinessAsset(string $business_id, string $asset_id, AppleBusinessAssetDetails $business_asset_details, string $etag): ?AppleBusinessAssetResponse
    {
        $response = $this->request('PUT', 'companies/' . $this->getCompanyId() . '/businesses/' . $business_id . '/assets/' . $asset_id, array(
            'json' => array(
                'id' => $asset_id,
                'businessAssetDetails' => $business_asset_details
            )
        ), $etag);
        if($response === null)
            return null;
        return new AppleBusinessAssetResponse($response);
        //Request:
        /*
         {
  "id": "1500026630454247424",
  "businessAssetDetails": {
    "imageId": "5154f9da-c079-4ea6-a145-8e53341a463d",
    "partnersAssetId": "business_asset_10101",
    "intent": "PLACECARD_LOGO",
    "altTexts": [
      {
        "text": "A barista preparing a cafe latte",
        "locale": "de-DE"
      }
    ]
  }
}
         */
        //Response:
        /*
         * {
    "id": "1500026630454247424",
    "state": "SUBMITTED",
    "createdDate": "2024-02-08T13:49:17.365Z",
    "updatedDate": "2024-02-09T17:11:18.591Z",
    "validationReports": [],
    "etag": "3591dd05-fac9-4983-abbe-b27f953c54ed",
    "companyId": "1469747224475254784",
    "businessId": "1541464898790064128",
    "businessAssetDetails": {
        "imageId": "5154f9da-c079-4ea6-a145-8e53341a463d",
        "partnersAssetId": "business_asset_10101",
        "intent": "PLACECARD_LOGO",
        "altTexts": [
            {
                "text": "A barista preparing a cafe latte",
                "locale": "de-DE"
            }
        ],
        "captions": []
    }
}
         */
    }

    public function deleteBusinessAsset(string $business_id, string $asset_id, string $etag): bool{
        return $this->request('DELETE', 'companies/' . $this->getCompanyId() . '/businesses/' . $business_id . '/assets/' . $asset_id, etag: $etag) !== null;
    }

    /**
     * @see https://businessconnect.apple.com/docs/api/v1/media/import
     */
    public function importMedia(string $url): ?AppleMediaReadResponse
    {
        $response = $this->request('POST', 'companies/' . $this->getCompanyId() . '/images/import', array(
            'json' => array(
                'imageDetails' => array(
                    'url' => $url
                )
            )
        ));
        if($response === null)
            return null;
        return new AppleMediaReadResponse($response);
        //Request (PNG or JPG):
        /*
         * {
  "imageDetails": {
    "url": "https://www.google.com/images/branding/googlelogo/2x/googlelogo_light_color_272x92dp.png"
  }
}
         */
        //Response:
        /* headers: location: /api/v1/companies/9467895078742654934/images/9467895078742654959/metadata
         * {
    "id": "5154f9da-c079-4ea6-a145-8e53341a463d",
    "companyId": "1469747224475254784",
    "createdDate": "2024-02-08T13:13:50.824Z",
    "updatedDate": "2024-02-08T13:13:50.824Z",
    "state": "SUBMITTED"
}
         */
    }

    /**
     * @see https://businessconnect.apple.com/docs/api/v1/media/upload
     */
    public function uploadMedia(string $filename, string $base64_file): ?AppleMediaReadResponse{
        $response = $this->request('POST', 'companies/' . $this->getCompanyId() . '/images/upload', array(
            'multipart' => array(
                [
                    'name'     => 'file',
                    'contents' => fopen('data://text/plain;base64,'.$base64_file, 'r'),
                    'filename' => $filename//example.png
                ]
            )
        ));
        if($response === null)
            return null;
        return new AppleMediaReadResponse($response);
        //content-type: multipart/form-data; charset=utf-8; boundary="boundary"
        //Request:
        //file: file in form-data
        //Response:
        /*headers: location: /api/v1/companies/9467895078742654934/images/9467895078742654959/metadata
         {
    "id": "b56e56f8-4c86-4bb5-bb8a-aab1532a4816",
    "companyId": "1469747224475254784",
    "createdDate": "2024-02-08T13:29:41.865Z",
    "updatedDate": "2024-02-08T13:29:41.956Z",
    "state": "SUBMITTED",
    "filename": "pumpe.png",
    "width": 800,
    "height": 450,
    "fileSize": 59427,
    "contentType": "image/png"
}
         */
    }

    /**
     * @see https://businessconnect.apple.com/docs/api/v1/media/get_metadata
     */
    public function getMediaMetadata(string $media_id): ?AppleMediaReadResponse
    {
        $response = $this->request('GET', 'companies/' . $this->getCompanyId() . '/images/' . $media_id . '/metadata');
        if($response === null)
            return null;
        return new AppleMediaReadResponse($response);
    }

    public function getFeedback(AppleResourceType $resourceType = null, string $resourceId = null, string $etag = null): ?AppleFeedbackPaginationResponse
    {
        //https://businessconnect.apple.com/docs/api/v1/feedback/get
        //For filtering see https://businessconnect.apple.com/docs/api/v1/references/filtering
        $filter = array();
        if($resourceType !== null)
            $filter[] = 'resourceType==' . $resourceType->name;
        if($resourceId !== null)
            $filter[] = 'resourceId==' . $resourceId;
        if($etag !== null)
            $filter[] = 'etag==' . $etag;
        $response = $this->request('GET', 'companies/' . $this->getCompanyId() . '/feedback', array(
            'query' => array(
                'ql' => join(';', $filter)
            )
        ));
        if($response === null)
            return null;
        return new AppleFeedbackPaginationResponse($response);
    }

    public function getNotifications(AppleResourceType $resourceType = null, string $resourceId = null, string $etag = null): ?AppleNotificationPaginationResponse
    {
        //https://businessconnect.apple.com/docs/api/v1/notifications/get
        //For filtering see https://businessconnect.apple.com/docs/api/v1/references/filtering
        $filter = array();
        if($resourceType !== null)
            $filter[] = 'resourceType==' . $resourceType->name;
        if($resourceId !== null)
            $filter[] = 'resourceId==' . $resourceId;
        if($etag !== null)
            $filter[] = 'etag==' . $etag;
        $response = $this->request('GET', 'companies/' . $this->getCompanyId() . '/notifications', array(
            'query' => array(
                'ql' => join(';', $filter)
            )
        ));
        if($response === null)
            return null;
        return new AppleNotificationPaginationResponse($response);
    }

    public function createAggregateRating(string $location_id, AppleAggregateRatingDetails $aggregate_rating_details): ?AppleAggregateRatingResponse
    {
        //https://businessconnect.apple.com/docs/api/v1/agg_rating/create
        $response = $this->request('POST', 'companies/' . $this->getCompanyId() . '/locations/' . $location_id . '/aggregate-ratings', array(
            'json' => array(
                'aggregateRatingDetails' => $aggregate_rating_details
            )
        ));
        if($response === null)
            return null;
        return new AppleAggregateRatingResponse($response);
        //Request:
        /*
         * {
  "aggregateRatingDetails": {
    "starRatings": [
      {
        "category": "OVERALL",
        "bestRating": 5,
        "worstRating": 1,
        "ratingValue": 4.0,
        "ratingCount": 504,
        "reviewCount": 249,
        "distribution": [
          { "key": "1", "value": 7},
          { "key": "2", "value": 19},
          { "key": "3", "value": 25},
          { "key": "4", "value": 358},
          { "key": "5", "value": 95}
        ]
      }
    ],
    "pricing": {
      "indicator": 4
    }
  }
}
         */
        //Response:
        /*
         * {
    "companyId": "1469747224475254784",
    "locationId": "1549569011459555403",
    "createdDate": "2024-02-13T19:41:21.180Z",
    "updatedDate": "2024-02-13T19:41:21.180Z",
    "state": "SUBMITTED",
    "etag": "dd097dc0-caa7-11ee-ae75-df03cf03e9fe",
    "aggregateRatingDetails": {
        "starRatings": [
            {
                "category": "OVERALL",
                "bestRating": 5,
                "worstRating": 1,
                "ratingValue": 4.0,
                "ratingCount": 504,
                "reviewCount": 249,
                "distribution": [
                    {
                        "key": "1",
                        "value": 7
                    },
                    {
                        "key": "2",
                        "value": 19
                    },
                    {
                        "key": "3",
                        "value": 25
                    },
                    {
                        "key": "4",
                        "value": 358
                    },
                    {
                        "key": "5",
                        "value": 95
                    }
                ]
            }
        ],
        "pricing": {
            "indicator": 4
        }
    },
    "validationReports": []
}
         */

    }

    public function updateAggregateRating(string $location_id, AppleAggregateRatingDetails $aggregate_rating_details, string $etag): ?AppleAggregateRatingResponse
    {
        //https://businessconnect.apple.com/docs/api/v1/agg_rating/update
        $response = $this->request('PUT', 'companies/' . $this->getCompanyId() . '/locations/' . $location_id . '/aggregate-ratings', array(
            'json' => array(
                'aggregateRatingDetails' => $aggregate_rating_details
            )
        ), $etag);
        if($response === null)
            return null;
        return new AppleAggregateRatingResponse($response);
        //Request:
        /*
         *{
  "aggregateRatingDetails": {
    "starRatings": [
      {
        "category": "OVERALL",
        "bestRating": 5,
        "worstRating": 1,
        "ratingValue": 4.0,
        "ratingCount": 509,
        "reviewCount": 249,
        "distribution": [
          { "key": "1", "value": 7},
          { "key": "2", "value": 19},
          { "key": "3", "value": 25},
          { "key": "4", "value": 358},
          { "key": "5", "value": 100}
        ]
      }
    ],
    "pricing": {
      "indicator": 3
    }
  }
}
         */
        //Response:
        /*
         * {
    "companyId": "1469747224475254784",
    "locationId": "1549569011459555403",
    "createdDate": "2024-02-13T19:41:21.180Z",
    "updatedDate": "2024-02-13T19:59:14.951Z",
    "state": "SUBMITTED",
    "etag": "5d0df170-caaa-11ee-b862-ef73f26dbbba",
    "aggregateRatingDetails": {
        "starRatings": [
            {
                "category": "OVERALL",
                "bestRating": 5,
                "worstRating": 1,
                "ratingValue": 4.0,
                "ratingCount": 509,
                "reviewCount": 249,
                "distribution": [
                    {
                        "key": "1",
                        "value": 7
                    },
                    {
                        "key": "2",
                        "value": 19
                    },
                    {
                        "key": "3",
                        "value": 25
                    },
                    {
                        "key": "4",
                        "value": 358
                    },
                    {
                        "key": "5",
                        "value": 100
                    }
                ]
            }
        ],
        "pricing": {
            "indicator": 3
        }
    },
    "validationReports": []
}
         */
    }

    public function deleteAggregateRating(string $location_id, string $etag): bool{
        //https://businessconnect.apple.com/docs/api/v1/agg_rating/delete
        return $this->request('DELETE', 'companies/' . $this->getCompanyId() . '/locations/' . $location_id . '/aggregate-ratings', etag: $etag) !== null;
    }

    public function getAggregateRatingByLocationId(string $location_id): ?AppleAggregateRatingResponse{
        //https://businessconnect.apple.com/docs/api/v1/agg_rating/get_by_location
        $response = $this->request('GET', 'companies/' . $this->getCompanyId() . '/locations/' . $location_id . '/aggregate-ratings');
        if($response === null)
            return null;
        return new AppleAggregateRatingResponse($response);
    }

    public function createReview(string $location_id, AppleReviewDetails $review_details): ?AppleReviewResponse{
        //https://businessconnect.apple.com/docs/api/v1/review/create
        $response = $this->request('POST', 'companies/' . $this->getCompanyId() . '/locations/' . $location_id . '/aggregate-ratings/reviews', array(
            'json' => array(
                'reviewDetails' => $review_details
            )
        ));
        if($response === null)
            return null;
        return new AppleReviewResponse($response);
        //Request:
        /*
         * {
  "reviewDetails": {
    "partnersReviewId": "857127252",
    "dateAdded": "2022-12-01T20:06:00Z",
    "review": {
      "author": {
        "givenName": "Robert",
        "lastInitial": "S.",
        "imageUrl": "http://goodpartner.com/media/images/author_profile_pic/user_id=43767642526I/default-avatar.jpg"
      },
      "name": "Excellent Place",
      "reviewBody": "Warm, friendly and entirely accommodating to all our needs.",
      "locale": "en",
      "starRatings": [
        {
          "category": "OVERALL",
          "ratingValue": 4,
          "bestRating": 5
        }
      ],
      "interactionStatistics": [
        {
          "interactionType": "HELPFUL",
          "userInteractionCount": 25
        }
      ]
    }
  }
}
         */
        //Response:
        /*
         * {
    "companyId": "1469747224475254784",
    "locationId": "1549569011459555403",
    "id": "1842302987261706240",
    "createdDate": "2024-02-13T20:58:24.760Z",
    "updatedDate": "2024-02-13T20:58:24.760Z",
    "state": "SUBMITTED",
    "etag": "a0e7cf80-cab2-11ee-9fa2-bd56c408e948",
    "reviewDetails": {
        "partnersReviewId": "857127252",
        "dateAdded": "2022-12-01T20:06:00Z",
        "review": {
            "author": {
                "givenName": "Robert",
                "lastInitial": "S.",
                "imageUrl": "http://goodpartner.com/media/images/author_profile_pic/user_id=43767642526I/default-avatar.jpg"
            },
            "name": "Excellent Place",
            "reviewBody": "Warm, friendly and entirely accommodating to all our needs.",
            "locale": "en",
            "starRatings": [
                {
                    "category": "OVERALL",
                    "ratingValue": 4.0,
                    "bestRating": 5
                }
            ],
            "interactionStatistics": [
                {
                    "interactionType": "HELPFUL",
                    "userInteractionCount": 25
                }
            ]
        }
    },
    "validationReports": []
}
         */
    }

    public function updateReview(string $location_id, string $review_id, AppleReviewDetails $review_details, string $etag): ?AppleReviewResponse{
        //https://businessconnect.apple.com/docs/api/v1/review/update
        $response = $this->request('PUT', 'companies/' . $this->getCompanyId() . '/locations/' . $location_id . '/aggregate-ratings/reviews/' . $review_id, array(
            'json' => array(
                'id' => $review_id,
                'reviewDetails' => $review_details
            )
        ), $etag);
        if($response === null)
            return null;
        return new AppleReviewResponse($response);
        //Request:
        /*
         * {
    "id": "1842302987261706240",
  "reviewDetails": {
    "partnersReviewId": "857127252",
        "dateAdded": "2022-12-01T20:06:00Z",
        "review": {
            "author": {
                "givenName": "Roberto",
                "lastInitial": "X.",
                "imageUrl": "http://goodpartner.com/media/images/author_profile_pic/user_id=43767642526I/default-avatar.jpg"
            },
            "name": "Excellent Place, really",
            "reviewBody": "Warm, friendly and entirely accommodating to all our needs.",
            "locale": "de",
            "starRatings": [
                {
                    "category": "OVERALL",
                    "ratingValue": 3.0,
                    "bestRating": 5
                }
            ],
            "interactionStatistics": [
                {
                    "interactionType": "HELPFUL",
                    "userInteractionCount": 25
                }
            ]
        }
  }
}
         */
        //Response:
        /*
         * {
    "companyId": "1469747224475254784",
    "locationId": "1549569011459555403",
    "id": "1842302987261706240",
    "createdDate": "2024-02-13T20:58:24.760Z",
    "updatedDate": "2024-02-13T21:16:49.222Z",
    "state": "SUBMITTED",
    "etag": "33375660-cab5-11ee-ae75-df03cf03e9fe",
    "reviewDetails": {
        "partnersReviewId": "857127252",
        "dateAdded": "2022-12-01T20:06:00Z",
        "review": {
            "author": {
                "givenName": "Roberto",
                "lastInitial": "X.",
                "imageUrl": "http://goodpartner.com/media/images/author_profile_pic/user_id=43767642526I/default-avatar.jpg"
            },
            "name": "Excellent Place, really",
            "reviewBody": "Warm, friendly and entirely accommodating to all our needs.",
            "locale": "de",
            "starRatings": [
                {
                    "category": "OVERALL",
                    "ratingValue": 3.0,
                    "bestRating": 5
                }
            ],
            "interactionStatistics": [
                {
                    "interactionType": "HELPFUL",
                    "userInteractionCount": 25
                }
            ]
        }
    },
    "validationReports": []
}
         */
    }

    public function deleteReview(string $location_id, string $review_id, string $etag): bool{
        //https://businessconnect.apple.com/docs/api/v1/review/delete
        return $this->request('DELETE', 'companies/' . $this->getCompanyId() . '/locations/' . $location_id . '/aggregate-ratings/reviews/' . $review_id, etag: $etag) !== null;
    }

    public function getReviewById(string $location_id, string $review_id): ?AppleReviewResponse{
        //https://businessconnect.apple.com/docs/api/v1/review/get_by_id
        $response = $this->request('GET', 'companies/' . $this->getCompanyId() . '/locations/' . $location_id . '/aggregate-ratings/reviews/' . $review_id);
        if($response === null)
            return null;
        return new AppleReviewResponse($response);
    }

    public function getReviewByPartnerId(string $location_id, string $partner_review_id): ?AppleReviewResponse{
        //https://businessconnect.apple.com/docs/api/v1/review/get_by_id
        $response = $this->request('GET', 'companies/' . $this->getCompanyId() . '/locations/' . $location_id . '/aggregate-ratings/reviews/by-partner-reviewId/' . $partner_review_id);
        if($response === null)
            return null;
        return new AppleReviewResponse($response);
    }

}