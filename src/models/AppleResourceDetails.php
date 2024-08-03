<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 *  "resourceType": "LOCATION",
 *  "resourceId": "1549569011482624136",
 *  "etag": "97efbee0-c67c-11ee-9fa2-bd56c408e948",
 *  "state": "REJECTED"
 *  }
 */
class AppleResourceDetails extends DataClass
{

    protected AppleResourceType $resourceType;
    protected string $resourceId;
    protected string $etag;
    protected string $state;//Depends on type

    public function __construct(array $data){
        self::setProperties($data, array(
            'resourceType' => AppleResourceType::class
        ));
    }

}