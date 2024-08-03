<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 *   "title": "Exterior View",
 *   "altText": "Storefront and and outdoor patio with tables and chairs",
 *   "locale": "en-US"
 *   }
 */
class AppleLocationAssetCaption extends DataClass
{

    protected string $title;
    protected string $altText;
    protected string $locale;

    public function __construct(array $data){
        parent::setProperties($data);
    }

    public static function create(string $title, string $altText, string $locale = 'de-DE'): AppleLocationAssetCaption{
        return new AppleLocationAssetCaption(array(
            'title' => $title,
            'altText' => $altText,
            'locale' => $locale
        ));
    }

}