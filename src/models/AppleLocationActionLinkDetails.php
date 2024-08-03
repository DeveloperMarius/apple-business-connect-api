<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 *  "quicklinks": [
 *  {
 *  "category": "quicklinks.restaurant_order_food",
 *  "quicklinkUrl": "https://www.provider.com/menu/malibu-icecream",
 *  "appStoreUrl": "https://apps.apple.com/us/app/provider-name-food-delivery/id284910350",
 *  "relationship": "AUTHORIZED"
 *  }
 *  ]
 *  }
 */
class AppleLocationActionLinkDetails extends DataClass
{

    /**
     * @var AppleLocationActionQuickLink[] $quicklinks
     */
    protected array $quicklinks;

    public function __construct(array $data){
        self::setProperties($data, array(
            'quicklinks' => AppleLocationActionQuickLink::class
        ));
    }

    /**
     * @return array
     */
    public function getQuicklinks(): array
    {
        return $this->quicklinks;
    }

    /**
     * @param AppleLocationActionQuickLink[] $quicklinks
     * @return AppleLocationActionLinkDetails
     */
    public static function create(array $quicklinks): AppleLocationActionLinkDetails
    {
        return new AppleLocationActionLinkDetails(array(
            'quicklinks' => $quicklinks
        ));
    }
}