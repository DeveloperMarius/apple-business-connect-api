<?php

namespace developermarius\applebusinessconnect\api\models;


enum AppleBusinessState implements \JsonSerializable {

    case DELETED;//Resource deleted (Expected in 1.0.2 release)
    case FAILED;//System failure
    case PUBLISHED;//Resource published
    case REJECTED;//Resource data validation or review failure
    case SUBMITTED;

    public function jsonSerialize(): string{
        return $this->name;
    }

}