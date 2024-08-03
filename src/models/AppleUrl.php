<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example:
 * {
 * "url": "https://example.com",
 * "type": "HOMEPAGE"
 * }
 */
class AppleUrl extends DataClass{

    protected string $url;
    protected AppleUrlType $type;

    public function __construct(array $data){
        $this->setProperties($data, array(
            'type' => AppleUrlType::class
        ));
    }

    public static function create(string $url, AppleUrlType $type): AppleUrl{
        return new AppleUrl(array(
            'url' => $url,
            'type' => $type
        ));
    }
}