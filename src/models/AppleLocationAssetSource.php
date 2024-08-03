<?php

namespace developermarius\applebusinessconnect\api\models;


enum AppleLocationAssetSource implements \JsonSerializable
{
    case BUSINESS;
    case USER;
    case VENDOR;

    public function jsonSerialize(): string{
        return $this->name;
    }

}
