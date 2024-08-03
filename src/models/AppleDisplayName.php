<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 * "name": "Test Business 1",
 * "locale": "de",
 * "primary": true
 * }
 */
class AppleDisplayName extends DataClass {

    protected string $name;
    protected string $locale;
    protected bool $primary;

    public function __construct(array $data){
        parent::setProperties($data);
    }

    public static function create(string $name, bool $primary = true, string $locale = 'de-DE'): AppleDisplayName{
        return new AppleDisplayName(array(
            'name' => $name,
            'locale' => $locale,
            'primary' => $primary
        ));
    }
}