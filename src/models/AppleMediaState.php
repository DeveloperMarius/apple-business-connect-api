<?php

namespace developermarius\applebusinessconnect\api\models;


enum AppleMediaState implements \JsonSerializable
{

    case APPROVED;//Resource approved
    case DELETED;//Resource deleted
    case IN_REVIEW;//Resource under review
    case REJECTED;//Resource data validation or review failure
    case SUBMITTED;//Resource queued for processing or is in-process

    public function jsonSerialize(): string{
        return $this->name;
    }
}