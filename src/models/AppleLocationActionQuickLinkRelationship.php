<?php

namespace developermarius\applebusinessconnect\api\models;


enum AppleLocationActionQuickLinkRelationship implements \JsonSerializable
{

    case AUTHORIZED;
    case OTHER;
    case OWNER;

    public function jsonSerialize(): string{
        return $this->name;
    }
}
