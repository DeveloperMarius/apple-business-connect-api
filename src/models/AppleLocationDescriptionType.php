<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * @see https://businessconnect.apple.com/docs/data-specification/v1.3/location/optional#location-descriptions
 */
enum AppleLocationDescriptionType implements \JsonSerializable {

    case ABOUT;

    public function jsonSerialize(): string{
        return $this->name;
    }
}