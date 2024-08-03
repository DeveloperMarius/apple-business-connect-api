<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Examples: [{
 * "code": "VALIDATION__DisplayNamesLocaleNotMatchedBySpecialHoursDescriptionsLocale",
 * "message": "Location name locale not matched by locale in '{{specialHoursDescriptionsLocale}}' ",
 * "severity": "WARNING",
 * "context": {
 * "specialHoursDescriptionsLocale": "en-US"
 * },
 * "details": {
 * "compared": [],
 * "expected": [],
 * "submitted": [
 * {
 * "field": "/locationDetails/specialHours[0]/descriptions[0]/locale",
 * "value": "en-US"
 * },
 * {
 * "field": "/locationDetails/displayNames[0]/locale",
 * "value": "de"
 * }
 * ],
 * "createdDate": "2024-02-08T12:12:58.299Z"
 * }
 * },
 * {
 * "code": "VALIDATION__DisplayNamesLocaleNotMatchedBySpecialHoursDescriptionsLocale",
 * "message": "Location name locale not matched by locale in '{{specialHoursDescriptionsLocale}}' ",
 * "severity": "WARNING",
 * "context": {
 * "specialHoursDescriptionsLocale": "es"
 * },
 * "details": {
 * "compared": [],
 * "expected": [],
 * "submitted": [
 * {
 * "field": "/locationDetails/specialHours[0]/descriptions[1]/locale",
 * "value": "es"
 * },
 * {
 * "field": "/locationDetails/displayNames[0]/locale",
 * "value": "de"
 * }
 * ],
 * "createdDate": "2024-02-08T12:12:58.299Z"
 * }
 * },
 * {
 * "code": "VALIDATION__UnexpectedPhoneNumberFormatForCountryCode",
 * "message": "Unexpected '{{phoneNumber}}' format for country derived from Main Address",
 * "severity": "INFO",
 * "context": {
 * "phoneNumber": "+12225551212"
 * },
 * "details": {
 * "compared": [],
 * "expected": [],
 * "submitted": [
 * {
 * "field": "/locationDetails/phoneNumbers[0]/phoneNumber",
 * "value": "+12225551212"
 * }
 * ],
 * "createdDate": "2024-02-08T12:12:58.295Z"
 * }
 * },
 * {
 * "code": "VALIDATION__SpecialHours_ExpectedRegionSubtagForCountryNotPresent",
 * "message": "No Feature’s locale includes a Region Subtag corresponding to Country in mainAddress",
 * "severity": "INFO",
 * "context": {},
 * "details": {
 * "compared": [],
 * "expected": [],
 * "submitted": [
 * {
 * "field": "/locationDetails/specialHours[0]/descriptions[0]/locale",
 * "value": "en-US"
 * }
 * ],
 * "createdDate": "2024-02-08T12:12:58.299Z"
 * }
 * }]
 */
class AppleValidationReport extends DataClass
{
    protected string $code;
    protected string $message;
    protected string $severity;
    protected array $context;
    protected array $details;

    public function __construct(array $data){
        parent::setProperties($data);
    }

}