<?php

namespace developermarius\applebusinessconnect\api\models;


enum AppleAggregateRatingStarRatingCategory implements \JsonSerializable
{
    case OVERALL;

    public function jsonSerialize(): mixed
    {
        return $this->name;
    }
}
