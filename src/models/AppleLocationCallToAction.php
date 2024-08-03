<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example:{
 *  "type": "ORDER",
 *  "text": "Feature to allow user to order food from a restaurant"
 *  },
 */
class AppleLocationCallToAction extends DataClass
{

    protected AppleLocationCallToActionType $type;
    protected string $text;

    public function __construct(array $data){
        $this->setProperties($data, array(
            'type' => AppleLocationCallToActionType::class,
        ));
    }

}