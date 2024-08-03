<?php

namespace developermarius\applebusinessconnect\api\models;

/**
 * @var https://businessconnect.apple.com/docs/data-specification/v1.3/location_asset/properties#intent
 */
enum AppleLocationAssetIntent implements \JsonSerializable {

    case COVER_PHOTO;
    case GALLERY;

    public function jsonSerialize(): string{
        return $this->name;
    }
}