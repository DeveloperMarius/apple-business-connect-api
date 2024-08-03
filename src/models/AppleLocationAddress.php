<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 *  "structuredAddress": {
 *  //"floor": "",
 *  "thoroughfare": "street",//street name
 *  "subThoroughfare": "16",//street number
 *  "fullThoroughfare": "street 16",//full street
 *  //"subLocality": "",
 *  "locality": "Frankfurt am Main",
 *  "administrativeArea": "Hessen",
 *  "postCode": "60385",
 *  "countryCode": "DE"
 *  },
 *  "locale": "de-DE"
 *  }
 */
class AppleLocationAddress extends DataClass
{

    protected AppleLocationStructuredAddress $structuredAddress;
    protected string $locale;

    public function __construct(array $data){
        parent::setProperties($data, array(
            'structuredAddress' => AppleLocationStructuredAddress::class
        ));
    }

    public static function create(AppleLocationStructuredAddress $address, $locale = 'de-DE')
    {
        return new AppleLocationAddress(array(
            'structuredAddress' => $address,
            'locale' => $locale
        ));
    }
}