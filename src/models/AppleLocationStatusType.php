<?php

namespace developermarius\applebusinessconnect\api\models;


enum AppleLocationStatusType implements \JsonSerializable
{

    case CLOSED;
    case OPEN;
    case TEMPORARILY_CLOSED;

    public function jsonSerialize(): string{
        return $this->name;
    }
}
