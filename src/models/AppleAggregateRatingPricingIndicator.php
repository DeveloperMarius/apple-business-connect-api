<?php

namespace developermarius\applebusinessconnect\api\models;


enum AppleAggregateRatingPricingIndicator: int implements \JsonSerializable
{

    case INEXPENSIVE = 1;
    case MODERATE = 2;
    case PRICEY = 3;
    case EXPENSIVE = 4;

    public function jsonSerialize(): int{
        return $this->value;
    }
}
