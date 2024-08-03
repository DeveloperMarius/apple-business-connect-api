<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example:
 * {
 *   "text": "A barista preparing a cafe latte",
 *   "locale": "de-DE"
 *   }
 */
class AppleText extends DataClass
{

    protected string $text;
    protected string $locale;

    public function __construct(array $data){
        parent::setProperties($data);
    }

    public static function create(string $text, string $locale = 'de-DE'): AppleText
    {
        return new AppleText(array(
            'text' => $text,
            'locale' => $locale
        ));
    }
}