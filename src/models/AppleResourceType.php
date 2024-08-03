<?php

namespace developermarius\applebusinessconnect\api\models;


enum AppleResourceType implements \JsonSerializable
{

    case AGGREGATE_RATING;
    case BUSINESS;
    case BUSINESS_ASSET;
    case COMPANY;
    case LOCATION;
    case LOCATION_ASSET;
    case REVIEW;
    case SHOWCASE;
    case SHOWCASE_CREATIVE;

    public function jsonSerialize(): string{
        return $this->name;
    }
}
