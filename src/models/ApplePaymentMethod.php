<?php

namespace developermarius\applebusinessconnect\api\models;


enum ApplePaymentMethod implements \JsonSerializable
{

    case AMERICAN_EXPRESS;
    case BITCOIN;
    case CASH_PAYMENT;
    case CHECK;
    case UNION_PAY;
    case DEBIT_CARDS;
    case DINERS_CLUB;
    case DISCOVER;
    case FINANCING;
    case INVOICE;
    case JCB;
    case MAESTRO;
    case MASTERCARD;
    case MASTERCARD_DEBIT;
    case PAYPAL;
    case RUPAY;
    case STORE_CARD;
    case VISA;
    case VISA_DEBIT;

    public function jsonSerialize(): string{
        return $this->name;
    }
}
