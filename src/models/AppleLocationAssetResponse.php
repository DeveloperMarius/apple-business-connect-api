<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 * "companyId": "1469747224475254784",
 * "locationId": "1549569011482624136",
 * "id": "1851310187914199046",
 * "createdDate": "2024-02-09T19:03:17.663Z",
 * "updatedDate": "2024-02-09T19:03:17.663Z",
 * "state": "SUBMITTED",
 * "etag": "e24d72f0-c77d-11ee-ada9-31f0b1fd693e",
 * "assetDetails": {
 * "partnersAssetId": "9090909090",
 * "dateAdded": "2022-09-10T12:45:34.000Z",
 * "intent": "GALLERY",
 * "captions": [
 * {
 * "title": "Exterior View",
 * "altText": "Storefront and and outdoor patio with tables and chairs",
 * "locale": "en-US"
 * }
 * ],
 * "source": "USER",
 * "capturedBy": "Jane D.",
 * "classifications": [
 * "exterior",
 * "outdoors"
 * ],
 * "coordinates": {
 * "latitude": "30.2210519",
 * "longitude": "-97.7199035"
 * },
 * "photos": {
 * "xxlarge": {
 * "pixelHeight": 1200,
 * "pixelWidth": 1200,
 * "url": "http://goodpartner.com/images/malibuicecream/3887887.jpg"
 * }
 * }
 * },
 * "validationReports": []
 * }
 */
class AppleLocationAssetResponse extends DataClass
{
    protected string $companyId;
    protected string $locationId;
    protected string $id;
    protected string $createdDate;
    protected string $updatedDate;
    protected AppleLocationAssetState $state;
    protected string $etag;
    protected AppleLocationAssetDetails $assetDetails;
    /**
     * @var AppleValidationReport[] $validationReports
     */
    protected array $validationReports;

    public function __construct(array $data){
        $this->setProperties($data, array(
            'state' => AppleLocationAssetState::class,
            'assetDetails' => AppleLocationAssetDetails::class,
            'validationReports' => AppleValidationReport::class,
        ));
    }

    public function getCompanyId(): string
    {
        return $this->companyId;
    }

    public function getLocationId(): string
    {
        return $this->locationId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCreatedDate(): string
    {
        return $this->createdDate;
    }

    public function getUpdatedDate(): string
    {
        return $this->updatedDate;
    }

    public function getState(): AppleLocationAssetState
    {
        return $this->state;
    }

    public function getEtag(): string
    {
        return $this->etag;
    }

    public function getAssetDetails(): AppleLocationAssetDetails
    {
        return $this->assetDetails;
    }

    public function getValidationReports(): array
    {
        return $this->validationReports;
    }

}