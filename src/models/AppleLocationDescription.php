<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 *  "type": "ABOUT",
 *  "descriptions": [
 *  {
 *  "text": "Established in 1984, Malibu Ice Cream handcrafts artisan super premium ice creams, dairy-free fruit juices and frozen yogurt! We are the home of world famous Mexican Vanilla Ice Cream. Explore your favorite flavors at Malibu IceCream.",
 *  "locale": "de-DE"
 *  }
 *  ]
 *  }
 */
class AppleLocationDescription extends DataClass
{

    protected AppleLocationDescriptionType $type;
    /**
     * @var AppleText[] $descriptions
     */
    protected array $descriptions;

    public function __construct(array $data){
        parent::setProperties($data, array(
            'type' => AppleLocationDescriptionType::class,
            'descriptions' => AppleText::class
        ));
    }

    public static function create(string $description, string $locale = 'de-DE'): AppleLocationDescription
    {
        return new AppleLocationDescription(array(
            'type' => AppleLocationDescriptionType::ABOUT,
            'descriptions' => array(
                AppleText::create($description, $locale)
            )
        ));
    }
}