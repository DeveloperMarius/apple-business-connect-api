<?php

namespace developermarius\applebusinessconnect\api\models;


enum AppleAggregateRatingStarRatingDistributionKey: string implements \JsonSerializable
{
    case ONE = "1";
    case TWO = "2";
    case THREE = "3";
    case FOUR = "4";
    case FIVE = "5";

    public function jsonSerialize(): mixed
    {
        return $this->value;
    }

}
