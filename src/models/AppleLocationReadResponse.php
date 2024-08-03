<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 * "id": "1549569011482624136",
 * "companyId": "1469747224475254784",
 * "createdDate": "2024-02-08T12:21:32.384Z",
 * "updatedDate": "2024-02-08T12:21:32.384Z",
 * "etag": "97efbee0-c67c-11ee-9fa2-bd56c408e948",
 * "state": "SUBMITTED",
 * "placeCardUrl": "https://maps.apple.com/place?auid=7378763904743701440",
 * "locationDetails": {}
 * }
 */
class AppleLocationReadResponse extends DataClass
{

    protected string $id;
    protected string $companyId;
    protected string $createdDate;
    protected string $updatedDate;
    protected string $etag;
    protected AppleLocationState $state;
    protected ?string $placeCardUrl = null;
    protected AppleLocationDetails $locationDetails;

    public function __construct(array $data){
        self::setProperties($data, array(
            'state' => AppleLocationState::class,
            'locationDetails' => AppleLocationDetails::class
        ));
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCompanyId(): string
    {
        return $this->companyId;
    }

    public function getCreatedDate(): string
    {
        return $this->createdDate;
    }

    public function getUpdatedDate(): string
    {
        return $this->updatedDate;
    }

    public function getEtag(): string
    {
        return $this->etag;
    }

    public function getState(): AppleLocationState
    {
        return $this->state;
    }

    public function getPlaceCardUrl(): ?string
    {
        return $this->placeCardUrl;
    }

    public function getLocationDetails(): AppleLocationDetails
    {
        return $this->locationDetails;
    }

}