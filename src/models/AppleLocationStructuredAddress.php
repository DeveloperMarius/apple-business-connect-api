<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 *   //"floor": "",
 *   "thoroughfare": "street",//street name
 *   "subThoroughfare": "16",//street number
 *   "fullThoroughfare": "street 16",//full street
 *   //"subLocality": "",
 *   "locality": "Frankfurt am Main",
 *   "administrativeArea": "Hessen",
 *   "postCode": "60385",
 *   "countryCode": "DE"
 *   }
 */
class AppleLocationStructuredAddress extends DataClass
{

    protected string $thoroughfare;
    protected ?string $subThoroughfare;
    protected string $fullThoroughfare;
    protected string $locality;
    protected string $administrativeArea;
    protected string $postCode;
    protected string $countryCode;

    public function __construct(array $data){
        if(!isset($data['fullThoroughfare'])){
            $data['fullThoroughfare'] = $data['thoroughfare'] . ' ' . $data['subThoroughfare'];
        }
        parent::setProperties($data);
    }

    public static function create(string $street, ?string $house_number, string $city, string $state, string $zip, string $country_code = 'DE'): AppleLocationStructuredAddress
    {
        return new AppleLocationStructuredAddress(array(
            'thoroughfare' => $street,
            'subThoroughfare' => $house_number,
            'fullThoroughfare' => $street . ($house_number !== null ? ' ' . $house_number : ''),
            'locality' => $city,
            'administrativeArea' => $state,
            'postCode' => $zip,
            'countryCode' => $country_code
        ));
    }

}