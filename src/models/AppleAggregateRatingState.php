<?php

namespace developermarius\applebusinessconnect\api\models;


enum AppleAggregateRatingState implements \JsonSerializable
{
    case DELETED;//Resource deleted
    case FAILED;//System failure
    case PUBLISHED;//Resource published
    case SUBMITTED;//Resource queued for processing or is in-process

    case PROCESSING;//Not documented

    public function jsonSerialize(): mixed
    {
        return $this->name;
    }
}
