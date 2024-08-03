<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 *
 * @method string getId()
 * Example:
 * {
 * "id": "1574554842258538496",
 * "state": "SUBMITTED",
 * "createdDate": "2024-02-08T08:43:02.636Z",
 * "updatedDate": "2024-02-08T09:12:26.782Z",
 * "validationReports": [],
 * "etag": "48f621eb-73af-45fa-8572-2a55efefdbdc",
 * "companyId": "1469747224475254784",
 * "businessDetails": {
 * "partnersBusinessId": "1",
 * "partnersBusinessVersion": "PBV01",
 * "countryCodes": [
 * "DE"
 * ],
 * "displayNames": [
 * {
 * "name": "Test Business 1",
 * "locale": "de",
 * "primary": true
 * }
 * ],
 * "categories": [
 * "food.desserts"
 * ],
 * "urls": [
 * {
 * "url": "https://example.com",
 * "type": "HOMEPAGE"
 * }
 * ]
 * }
 * }
 */
class AppleBusinessEditResponse extends DataClass{

    protected string $id;
    protected AppleBusinessState $state;
    /**
     * Format: 2024-02-08T08:43:02.636Z
     */
    protected string $createdDate;
    /**
     * Format: 2024-02-08T08:43:02.636Z
     */
    protected string $updatedDate;
    /**
     * @var AppleValidationReport[] $validationReports
     */
    protected array $validationReports;
    protected string $etag;
    protected string $companyId;
    protected AppleBusinessDetail $businessDetails;

    public function __construct(array $data){
        $this->setProperties($data, array(
            'state' => AppleBusinessState::class,
            'businessDetails' => AppleBusinessDetail::class,
            'validationReports' => AppleValidationReport::class
        ));
    }
}