<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 *  "latitude": "52.358834",
 *  "longitude": "4.893834"
 *  }
 *
 * @see https://businessconnect.apple.com/docs/data-specification/v1.3/location/required#display-point
 */
class AppleCoordinates extends DataClass
{

    protected string $latitude;
    protected string $longitude;

    public function __construct(array $data){
        parent::setProperties($data);
    }
}