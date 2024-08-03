<?php

namespace developermarius\applebusinessconnect\api\models;


enum AppleFeedbackResourceDetailsState implements \JsonSerializable
{

    case DELETED;//Resource deleted
    case FAILED;//System failure
    case PUBLISHED;//Resource published
    case SUBMITTED;//Resource queued for processing or is in-process

    public function jsonSerialize(): string{
        return $this->name;
    }
}