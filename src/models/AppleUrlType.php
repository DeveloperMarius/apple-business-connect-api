<?php

namespace developermarius\applebusinessconnect\api\models;


/**
 * FACEBOOK, HOMEPAGE, INSTAGRAM, IOS_APP, TWITTER, YELP
 */
enum AppleUrlType implements \JsonSerializable {

    case FACEBOOK;
    case HOMEPAGE;
    case INSTAGRAM;
    case IOS_APP;
    case TWITTER;
    case YELP;

    public function jsonSerialize(): string{
        return $this->name;
    }

}