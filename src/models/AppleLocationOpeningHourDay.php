<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 *
 * @see https://businessconnect.apple.com/docs/data-specification/v1.3/reference#hours-by-day
 */
enum AppleLocationOpeningHourDay implements \JsonSerializable
{

    case SUNDAY;
    case MONDAY;
    case TUESDAY;
    case WEDNESDAY;
    case THURSDAY;
    case FRIDAY;
    case SATURDAY;

    public function jsonSerialize(): string{
        return $this->name;
    }
}