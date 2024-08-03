<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

enum AppleLocationDisplayPointSource implements \JsonSerializable
{

    case CALCULATED;
    case MANUALLY_PLACED;

    public function jsonSerialize(): string{
        return $this->name;
    }
}
