<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example:
 * "partnersLocationId": "4",
 * "partnersLocationVersion": "PV01",
 * "businessId": "1541464898790064128",
 * "displayNames": [
 * {
 * "name": "xyz GmbH",
 * "locale": "de-DE",
 * "primary": true
 * }
 * ],
 * "storeCode": "#123",
 * "internalNicknames": [
 * {
 * "name": "Thinking space",
 * "locale": "de-DE"
 * }
 * ],
 * "mainAddress": {
 * "structuredAddress": {
 * //"floor": "",
 * "thoroughfare": "street",//street name
 * "subThoroughfare": "16",//street number
 * "fullThoroughfare": "street 16",//full street
 * //"subLocality": "",
 * "locality": "Frankfurt am Main",
 * "administrativeArea": "Hessen",
 * "postCode": "60385",
 * "countryCode": "DE"
 * },
 * "locale": "de-DE"
 * },
 * "urls": [
 * {
 * "url": "http://example.com",
 * "type": "HOMEPAGE"
 * }
 * ],
 * "locationDescriptions": [
 * {
 * "type": "ABOUT",
 * "descriptions": [
 * {
 * "text": "Established in 1984, Malibu Ice Cream handcrafts artisan super premium ice creams, dairy-free fruit juices and frozen yogurt! We are the home of world famous Mexican Vanilla Ice Cream. Explore your favorite flavors at Malibu IceCream.",
 * "locale": "de-DE"
 * }
 * ]
 * }
 * ],
 * "openingHoursByDay": [
 * {
 * "day" : "MONDAY",
 * "times" : [
 * {
 * "startTime" : "10:00",
 * "endTime" : "22:00"
 * }
 * ]
 * },
 * {
 * "day" : "TUESDAY",
 * "times" : [
 * {
 * "startTime" : "10:00",
 * "endTime" : "22:00"
 * }
 * ]
 * },
 * {
 * "day" : "WEDNESDAY",
 * "times" : [
 * {
 * "startTime" : "10:00",
 * "endTime" : "22:00"
 * }
 * ]
 * },
 * {
 * "day" : "THURSDAY",
 * "times" : [
 * {
 * "startTime" : "10:00",
 * "endTime" : "22:00"
 * }
 * ]
 * },
 * {
 * "day" : "FRIDAY",
 * "times" : [
 * {
 * "startTime" : "10:00",
 * "endTime" : "22:00"
 * }
 * ]
 * },
 * {
 * "day" : "SATURDAY",
 * "times" : [
 * {
 * "startTime" : "09:00",
 * "endTime" : "23:30"
 * }
 * ]
 * }
 * ],
 * "specialHours": [
 * {
 * "hoursByDay": [
 * {
 * "day" : "SUNDAY",
 * "times" : [
 * {
 * "startTime" : "09:00",
 * "endTime" : "12:00"
 * }
 * ]
 * }
 * ],
 * "startDate": "2022-12-25",
 * "endDate": "2022-12-25",
 * "closed": false,
 * "descriptions": [
 * {
 * "text": "Weihnachten",
 * "locale": "de-DE"
 * }
 * ]
 * }
 * ],
 * "categories": [ "food.desserts", "food.gelato", "health.dietitians" ],
 * "locationAttributes": [
 * {
 * "type": "crossbusiness.restrooms.gender_neutral_restroom",
 * "provided": true
 * }
 * ],
 * "paymentMethods": [ "VISA", "MASTERCARD"],
 * "displayPoint": {
 * "coordinates": {
 * "latitude": "52.358834",
 * "longitude": "4.893834"
 * },
 * "source": "MANUALLY_PLACED"
 * },
 * "phoneNumbers": [
 * {
 * "phoneNumber": "+4915731626185",
 * "type": "LANDLINE",
 * "primary": true
 * }
 * ],
 * "locationStatus": {
 * "status": "OPEN"
 * },
 * "actionLinkDetails": {
 * "quicklinks": [
 * {
 * "category": "quicklinks.restaurant_order_food",
 * "quicklinkUrl": "https://www.provider.com/menu/malibu-icecream",
 * "appStoreUrl": "https://apps.apple.com/us/app/provider-name-food-delivery/id284910350",
 * "relationship": "AUTHORIZED"
 * }
 * ],
 * "storeCode": "#123",
 * }
 */
class AppleLocationDetails extends DataClass{

    protected string $partnersLocationId;
    protected string $partnersLocationVersion;
    protected ?string $businessId = null;//Provided by Apple
    /**
     * @var AppleDisplayName[] $displayNames
     */
    protected array $displayNames;
    protected ?string $storeCode = null;
    /**
     * @var AppleLocationInternalNickname[] $internalNicknames
     */
    protected array $internalNicknames;
    protected AppleLocationAddress $mainAddress;
    /**
     * @var AppleUrl[] $urls
     */
    protected array $urls;
    /**
     * @var AppleLocationDescription[] $locationDescriptions
     */
    protected array $locationDescriptions;
    /**
     * @var AppleLocationOpeningHour[] $openingHoursByDay
     */
    protected array $openingHoursByDay;
    /**
     * @var AppleLocationOpeningSpecialHour[] $specialHours
     */
    protected array $specialHours;
    /**
     * @var AppleCategory[] $categories
     */
    protected array $categories;
    /**
     * @var AppleLocationAttribute[] $locationAttributes
     */
    protected array $locationAttributes;
    /**
     * @var ApplePaymentMethod[] $paymentMethods
     */
    protected array $paymentMethods = array();
    protected ?AppleLocationDisplayPoint $displayPoint;
    /**
     * @var ApplePhoneNumber[] $phoneNumbers
     */
    protected array $phoneNumbers;
    protected AppleLocationStatus $locationStatus;
    protected AppleLocationActionLinkDetails $actionLinkDetails;

    public function __construct(array $data){
        $this->setProperties($data, array(
            'displayNames' => AppleDisplayName::class,
            'internalNicknames' => AppleLocationInternalNickname::class,
            'mainAddress' => AppleLocationAddress::class,
            'urls' => AppleUrl::class,
            'locationDescriptions' => AppleLocationDescription::class,
            'openingHoursByDay' => AppleLocationOpeningHour::class,
            'specialHours' => AppleLocationOpeningSpecialHour::class,
            'categories' => AppleCategory::class,
            'locationAttributes' => AppleLocationAttribute::class,
            'paymentMethods' => ApplePaymentMethod::class,
            'displayPoint' => AppleLocationDisplayPoint::class,
            'phoneNumbers' => ApplePhoneNumber::class,
            'locationStatus' => AppleLocationStatus::class,
            'actionLinkDetails' => AppleLocationActionLinkDetails::class
        ));
    }

    public function getPartnersLocationId(): string
    {
        return $this->partnersLocationId;
    }

    public function setPartnersLocationId(string $partnersLocationId): void
    {
        $this->partnersLocationId = $partnersLocationId;
    }

    public function getPartnersLocationVersion(): string
    {
        return $this->partnersLocationVersion;
    }

    public function setPartnersLocationVersion(string $partnersLocationVersion): void
    {
        $this->partnersLocationVersion = $partnersLocationVersion;
    }

    public function getBusinessId(): ?string
    {
        return $this->businessId;
    }

    public function setBusinessId(?string $businessId): void
    {
        $this->businessId = $businessId;
    }

    public function getDisplayNames(): array
    {
        return $this->displayNames;
    }

    public function setDisplayNames(array $displayNames): void
    {
        $this->displayNames = $displayNames;
    }

    public function getStoreCode(): ?string
    {
        return $this->storeCode;
    }

    public function setStoreCode(?string $storeCode): void
    {
        $this->storeCode = $storeCode;
    }

    public function getInternalNicknames(): array
    {
        return $this->internalNicknames;
    }

    public function setInternalNicknames(array $internalNicknames): void
    {
        $this->internalNicknames = $internalNicknames;
    }

    public function getMainAddress(): AppleLocationAddress
    {
        return $this->mainAddress;
    }

    public function setMainAddress(AppleLocationAddress $mainAddress): void
    {
        $this->mainAddress = $mainAddress;
    }

    public function getUrls(): array
    {
        return $this->urls;
    }

    public function setUrls(array $urls): void
    {
        $this->urls = $urls;
    }

    public function getLocationDescriptions(): array
    {
        return $this->locationDescriptions;
    }

    public function setLocationDescriptions(array $locationDescriptions): void
    {
        $this->locationDescriptions = $locationDescriptions;
    }

    public function getOpeningHoursByDay(): array
    {
        return $this->openingHoursByDay;
    }

    public function setOpeningHoursByDay(array $openingHoursByDay): void
    {
        $this->openingHoursByDay = $openingHoursByDay;
    }

    public function getSpecialHours(): array
    {
        return $this->specialHours;
    }

    public function setSpecialHours(array $specialHours): void
    {
        $this->specialHours = $specialHours;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function setCategories(array $categories): void
    {
        $this->categories = $categories;
    }

    public function getLocationAttributes(): array
    {
        return $this->locationAttributes;
    }

    public function setLocationAttributes(array $locationAttributes): void
    {
        $this->locationAttributes = $locationAttributes;
    }

    public function getPaymentMethods(): array
    {
        return $this->paymentMethods;
    }

    public function setPaymentMethods(array $paymentMethods): void
    {
        $this->paymentMethods = $paymentMethods;
    }

    public function getDisplayPoint(): ?AppleLocationDisplayPoint
    {
        return $this->displayPoint;
    }

    public function setDisplayPoint(?AppleLocationDisplayPoint $displayPoint): void
    {
        $this->displayPoint = $displayPoint;
    }

    public function getPhoneNumbers(): array
    {
        return $this->phoneNumbers;
    }

    public function setPhoneNumbers(array $phoneNumbers): void
    {
        $this->phoneNumbers = $phoneNumbers;
    }

    public function getLocationStatus(): AppleLocationStatus
    {
        return $this->locationStatus;
    }

    public function setLocationStatus(AppleLocationStatus $locationStatus): void
    {
        $this->locationStatus = $locationStatus;
    }

    public function getActionLinkDetails(): AppleLocationActionLinkDetails
    {
        return $this->actionLinkDetails;
    }

    public function setActionLinkDetails(AppleLocationActionLinkDetails $actionLinkDetails): void
    {
        $this->actionLinkDetails = $actionLinkDetails;
    }

    public function toArray(bool $cleanData = false): array
    {
        $data = parent::toArray($cleanData);
        foreach ($data as $key => $value){
            if($value === null || (is_array($value) && sizeof($value) === 0)){
                unset($data[$key]);
            }
        }
        /*if(sizeof($this->getActionLinkDetails()->getQuicklinks()) === 0){
            unset($data['actionLinkDetails']);
        }*/
        return $data;
    }

    /**
     * @param string $partner_business_id
     * @param string $business_id
     * @param string $display_name
     * @param string $internal_nickname
     * @param AppleLocationAddress $main_address
     * @param AppleUrl[] $urls
     * @param string $description_about
     * @param AppleLocationOpeningHour[] $opening_hours
     * @param AppleCategory[] $categories
     * @param array $location_attributes
     * @param array $phone_numbers
     * @param string $partner_business_version
     * @param array $specialHours
     * @param ApplePaymentMethod[] $payment_methods
     * @param AppleLocationDisplayPoint|null $display_point
     * @param AppleLocationStatusType $location_status
     * @param AppleLocationActionQuickLink[] $quick_links
     * @return AppleLocationDetails
     */
    public static function create(string $partner_location_id, string $business_id, string $display_name, string $internal_nickname, AppleLocationAddress $main_address, array $urls, ?string $description_about, array $opening_hours, array $categories, array $location_attributes, array $phone_numbers, string $partner_business_version, array $specialHours = array(), array $payment_methods = array(), AppleLocationDisplayPoint $display_point = null, AppleLocationStatusType $location_status = AppleLocationStatusType::OPEN, array $quick_links = array())
    {
        return new AppleLocationDetails(array(
            'partnersLocationId' => $partner_location_id,
            'partnersLocationVersion' => $partner_business_version,
            'businessId' => $business_id,
            'displayNames' => array(AppleDisplayName::create($display_name)),
            'internalNicknames' => array(AppleLocationInternalNickname::create($internal_nickname)),
            'mainAddress' => $main_address,
            'urls' => $urls,
            'locationDescriptions' => $description_about !== null ? array(AppleLocationDescription::create($description_about)) : array(),
            'openingHoursByDay' => $opening_hours,
            'specialHours' => $specialHours,
            'categories' => $categories,
            'locationAttributes' => $location_attributes,
            'paymentMethods' => $payment_methods,
            'displayPoint' => $display_point,
            'phoneNumbers' => $phone_numbers,
            'locationStatus' => AppleLocationStatus::create($location_status),
            'actionLinkDetails' => AppleLocationActionLinkDetails::create($quick_links)
        ));
    }
}