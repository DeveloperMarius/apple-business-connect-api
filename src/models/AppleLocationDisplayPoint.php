<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 * "displayPoint": {
 * "coordinates": {
 * "latitude": "52.358834",
 * "longitude": "4.893834"
 * },
 * "source": "CALCULATED"
 * }
 * }
 */
class AppleLocationDisplayPoint extends DataClass
{

    protected AppleCoordinates $coordinates;
    protected AppleLocationDisplayPointSource $source;

    public function __construct(array $data){
        self::setProperties($data, array(
            'coordinates' => AppleCoordinates::class,
            'source' => AppleLocationDisplayPointSource::class
        ));
    }

}