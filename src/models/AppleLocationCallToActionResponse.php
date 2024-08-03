<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example:{
 * "data":[
 * {
 * "type": "DELIVERY",
 * "text": "Feature to allow user to place a delivery order from a restaurant"
 * },
 * {
 * "type": "MENU",
 * "text": "Feature to allow user to view a restaurant's menu"
 * },
 * {
 * "type": "ORDER",
 * "text": "Feature to allow user to order food from a restaurant"
 * },
 * {
 * "type": "RESERVE_TABLE",
 * "text": "Feature that allows user to reserve a table."
 * }
 * ]
 * }
 */
class AppleLocationCallToActionResponse extends DataClass
{
    /**
     * @var AppleLocationCallToAction[] $data
     */
    protected array $data;

    public function __construct(array $data){
        $this->setProperties($data, array(
            'data' => AppleLocationCallToAction::class,
        ));
    }
}