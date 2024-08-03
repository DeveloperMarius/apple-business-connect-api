<?php

namespace developermarius\applebusinessconnect\api\models;

/**
 * @see https://businessconnect.apple.com/docs/data-specification/v1.3/business_asset/properties#intent
 */
enum AppleBusinessAssetIntent implements \JsonSerializable {

    case COVER_PHOTO;
    case PLACECARD_LOGO;

    public function jsonSerialize(): string{
        return $this->name;
    }

}