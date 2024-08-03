<?php

namespace developermarius\applebusinessconnect\api\models;


enum AppleNotificationType implements \JsonSerializable
{

    case CLAIM_VALIDATION;
    case CUSTOMER_REPORT;
    case DELEGATION;
    case OAUTH_APP_GRANT;
    case PROCESSING_FAILURE;
    case PROCESSING_SUCCESSFUL;
    case VALIDATION_FAILURE;

    public function jsonSerialize(): string{
        return $this->name;
    }
}
