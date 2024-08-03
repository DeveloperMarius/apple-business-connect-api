<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example:
 * {
 * "id": "1541464898790064128",
 * "state": "PUBLISHED",
 * "createdDate": "2024-02-08T12:06:50.678Z",
 * "updatedDate": "2024-02-08T12:21:33.676Z",
 * "validationReports": [],
 * "etag": "b960bbbe-dd3b-41db-9550-e480d0beb2b0",
 * "companyId": "1469747224475254784",
 * "businessDetails": {
 * "partnersBusinessId": "4",
 * "partnersBusinessVersion": "PBV01",
 * "countryCodes": [
 * "DE"
 * ],
 * "displayNames": [
 * {
 * "name": "Test Business 4",
 * "locale": "de",
 * "primary": true
 * }
 * ],
 * "categories": [
 * "food.desserts",
 * "food.gelato"
 * ],
 * "urls": [
 * {
 * "url": "https://example4.com",
 * "type": "HOMEPAGE"
 * }
 * ]
 * }
 * }
 */
class AppleBusinessReadResponse extends DataClass{

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