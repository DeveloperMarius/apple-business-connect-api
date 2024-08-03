<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 *   "category": "quicklinks.restaurant_order_food",
 *   "quicklinkUrl": "https://www.provider.com/menu/malibu-icecream",
 *   "appStoreUrl": "https://apps.apple.com/us/app/provider-name-food-delivery/id284910350",
 *   "relationship": "AUTHORIZED"
 *   }
 *
 * @see https://businessconnect.apple.com/docs/data-specification/v1.3/location/optional#action-link-details
 */
class AppleLocationActionQuickLink extends DataClass
{

    protected AppleLocationActionQuickLinkCategory $category;
    protected string $quicklinkUrl;
    protected ?string $appStoreUrl;
    protected AppleLocationActionQuickLinkRelationship $relationship;

    public function __construct(array $data){
        self::setProperties($data, array(
            'category' => AppleLocationActionQuickLinkCategory::class,
            'relationship' => AppleLocationActionQuickLinkRelationship::class
        ));
    }
}