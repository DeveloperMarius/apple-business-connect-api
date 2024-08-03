<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example:
 * {
 *  "name": "Thinking space",
 *  "locale": "de-DE"
 *  }
 */
class AppleLocationInternalNickname extends DataClass
{

    protected string $name;
    protected string $locale;

    public function __construct(array $data){
        parent::setProperties($data);
    }

    public static function create(string $name, string $locale = 'de-DE'): AppleLocationInternalNickname
    {
        return new AppleLocationInternalNickname(array(
            'name' => $name,
            'locale' => $locale
        ));
    }
}