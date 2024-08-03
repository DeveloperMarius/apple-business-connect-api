<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 *  "phoneNumber": "+4915731626185",
 *  "type": "LANDLINE",
 *  "primary": true
 *  }
 */
class ApplePhoneNumber extends DataClass
{

    protected string $phoneNumber;
    protected ApplePhoneNumberType $type;
    protected bool $primary;

    public function __construct(array $data){
        self::setProperties($data, array(
            'type' => ApplePhoneNumberType::class
        ));
    }

    public static function create(string $phoneNumber, ApplePhoneNumberType $type = ApplePhoneNumberType::LANDLINE, bool $primary = true): ApplePhoneNumber{
        return new ApplePhoneNumber(array(
            'phoneNumber' => $phoneNumber,
            'type' => $type,
            'primary' => $primary
        ));
    }
}