<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 *  "status": "OPEN"
 *  }
 */
class AppleLocationStatus extends DataClass
{

    protected AppleLocationStatusType $status;

    public function __construct(array $data){
        self::setProperties($data, array(
            'status' => AppleLocationStatusType::class
        ));
    }

    public static function create(AppleLocationStatusType $status): AppleLocationStatus
    {
        return new AppleLocationStatus(array(
            'status' => $status
        ));
    }
}