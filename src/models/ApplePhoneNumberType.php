<?php

namespace developermarius\applebusinessconnect\api\models;


enum ApplePhoneNumberType implements \JsonSerializable
{

    case FAX;
    case LANDLINE;
    case MOBILE;
    case TOLL_FREE;
    case TTY;

    public function jsonSerialize(): string{
        return $this->name;
    }
}
