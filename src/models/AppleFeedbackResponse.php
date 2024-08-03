<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 * "companyId": "1469747224475254784",
 * "id": "1549569011482624136_97efbee0-c67c-11ee-9fa2-bd56c408e948_VALIDATION_FAILURE",
 * "type": "VALIDATION_FAILURE",
 * "createdDate": "2024-02-08T12:21:33.527Z",
 * "resourceDetails": {
 * "resourceType": "LOCATION",
 * "resourceId": "1549569011482624136",
 * "etag": "97efbee0-c67c-11ee-9fa2-bd56c408e948",
 * "state": "REJECTED"
 * },
 * "validationReports": [
 * {
 * "code": "VALIDATION__PointMustBeContainedByCountry",
 * "message": "Point geometry must be contained by Country identified in mainAddress",
 * "severity": "VIOLATION",
 * "context": {},
 * "details": {
 * "compared": [],
 * "expected": [],
 * "submitted": [
 * {
 * "field": "/locationDetails/displayPoint/coordinates",
 * "value": {
 * "latitude": 52.358834,
 * "longitude": 4.893834
 * }
 * }
 * ],
 * "createdDate": "2024-02-08T12:21:32.798Z"
 * }
 * },
 * {
 * "code": "VALIDATION__DisplayPointCoordinatesNotContainedByExpectedPostCode",
 * "message": "Display Point '{{coordinates}}' not contained by post code in mainAddress",
 * "severity": "WARNING",
 * "context": {
 * "coordinates": {
 * "latitude": 52.358834,
 * "longitude": 4.893834
 * }
 * },
 * "details": {
 * "compared": [],
 * "expected": [],
 * "submitted": [
 * {
 * "field": "/locationDetails/displayPoint/coordinates",
 * "value": {
 * "latitude": 52.358834,
 * "longitude": 4.893834
 * }
 * }
 * ],
 * "createdDate": "2024-02-08T12:21:32.798Z"
 * }
 * },
 * {
 * "code": "VALIDATION__DisplayPointCoordinatesNotContainedByExpectedLocality",
 * "message": "Display Point '{{coordinates}}' not contained by locality in mainAddress",
 * "severity": "WARNING",
 * "context": {
 * "coordinates": {
 * "latitude": 52.358834,
 * "longitude": 4.893834
 * }
 * },
 * "details": {
 * "compared": [],
 * "expected": [],
 * "submitted": [
 * {
 * "field": "/locationDetails/displayPoint/coordinates",
 * "value": {
 * "latitude": 52.358834,
 * "longitude": 4.893834
 * }
 * }
 * ],
 * "createdDate": "2024-02-08T12:21:32.799Z"
 * }
 * }
 * ],
 * "processingReports": [],
 * "oauthAppGrantReports": []
 * }
 */
class AppleFeedbackResponse extends DataClass
{

    protected string $companyId;
    protected string $id;
    protected AppleFeedbackType $type;
    protected string $createdDate;
    protected AppleResourceDetails $resourceDetails;
    /**
     * @var AppleValidationReport[] $resourceDetails
     */
    protected array $validationReports;
    protected array $processingReports;
    protected array $oauthAppGrantReports;

    public function __construct(array $data)
    {
        $this->setProperties($data, array(
            'type' => AppleFeedbackType::class,
            'resourceDetails' => AppleResourceDetails::class,
            'validationReports' => AppleValidationReport::class
        ));
    }
}