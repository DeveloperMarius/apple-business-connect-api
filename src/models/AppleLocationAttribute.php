<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 *  "type": "crossbusiness.restrooms.gender_neutral_restroom",
 *  "provided": true
 *  }
 */
class AppleLocationAttribute extends DataClass
{

    protected AppleLocationAttributeType $type;
    protected bool $provided;

    public function __construct(array $data){
        parent::setProperties($data, array(
            'type' => AppleLocationAttributeType::class
        ));
    }

    public static function create(AppleLocationAttributeType $type, bool $provided = true): AppleLocationAttribute{
        return new AppleLocationAttribute(array(
            'type' => $type,
            'provided' => $provided
        ));
    }
}