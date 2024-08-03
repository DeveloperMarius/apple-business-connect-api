<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 * "id": "1500026630454247424",
 * "state": "SUBMITTED",
 * "createdDate": "2024-02-08T13:49:17.365Z",
 * "updatedDate": "2024-02-08T13:49:17.365Z",
 * "validationReports": [],
 * "etag": "5a6c2b07-343c-4369-9c25-8ac6cdec2d33",
 * "companyId": "1469747224475254784",
 * "businessId": "1541464898790064128",
 * "businessAssetDetails": {
 * "imageId": "5154f9da-c079-4ea6-a145-8e53341a463d",
 * "partnersAssetId": "business_asset_10101",
 * "intent": "PLACECARD_LOGO",
 * "altTexts": [
 * {
 * "text": "A barista preparing a cafe latte",
 * "locale": "de-DE"
 * }
 * ]
 * }
 * }
 */
class AppleBusinessAssetResponse extends DataClass
{

    protected string $id;
    protected AppleBusinessAssetState $state;
    protected string $createdDate;
    protected string $updatedDate;
    /**
     * @var AppleValidationReport[] $validationReports
     */
    protected array $validationReports;
    protected string $etag;
    protected string $companyId;
    protected string $businessId;
    protected AppleBusinessAssetDetails $businessAssetDetails;

    public function __construct(array $data){
        parent::setProperties($data, array(
            'state' => AppleBusinessAssetState::class,
            'businessAssetDetails' => AppleBusinessAssetDetails::class,
            'validationReports' => AppleValidationReport::class
        ));
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getState(): AppleBusinessAssetState
    {
        return $this->state;
    }

    public function getCreatedDate(): string
    {
        return $this->createdDate;
    }

    public function getUpdatedDate(): string
    {
        return $this->updatedDate;
    }

    public function getValidationReports(): array
    {
        return $this->validationReports;
    }

    public function getEtag(): string
    {
        return $this->etag;
    }

    public function getCompanyId(): string
    {
        return $this->companyId;
    }

    public function getBusinessId(): string
    {
        return $this->businessId;
    }

    public function getBusinessAssetDetails(): AppleBusinessAssetDetails
    {
        return $this->businessAssetDetails;
    }
}