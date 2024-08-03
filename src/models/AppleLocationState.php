<?php

namespace developermarius\applebusinessconnect\api\models;


enum AppleLocationState implements \JsonSerializable
{

    case DELETED;//Resource deleted (Expected in 1.0.2 release)
    case FAILED;//System failure
    case PROCESSING;//Resource is being prepared to be PUBLISHED
    case PUBLISHED;//Resource published
    case REJECTED;//Resource data validation failure
    case SUBMITTED;//Resource queued for processing or is in-process

    public function jsonSerialize(): string{
        return $this->name;
    }
}
