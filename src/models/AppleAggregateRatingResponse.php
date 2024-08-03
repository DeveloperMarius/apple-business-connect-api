<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 * "companyId": "1469747224475254784",
 * "locationId": "1549569011459555403",
 * "createdDate": "2024-02-13T19:41:21.180Z",
 * "updatedDate": "2024-02-13T19:41:21.180Z",
 * "state": "SUBMITTED",
 * "etag": "dd097dc0-caa7-11ee-ae75-df03cf03e9fe",
 * "aggregateRatingDetails": {
 * "starRatings": [
 * {
 * "category": "OVERALL",
 * "bestRating": 5,
 * "worstRating": 1,
 * "ratingValue": 4.0,
 * "ratingCount": 504,
 * "reviewCount": 249,
 * "distribution": [
 * {
 * "key": "1",
 * "value": 7
 * },
 * {
 * "key": "2",
 * "value": 19
 * },
 * {
 * "key": "3",
 * "value": 25
 * },
 * {
 * "key": "4",
 * "value": 358
 * },
 * {
 * "key": "5",
 * "value": 95
 * }
 * ]
 * }
 * ],
 * "pricing": {
 * "indicator": 4
 * }
 * },
 * "validationReports": []
 * }
 */
class AppleAggregateRatingResponse extends DataClass
{
    protected string $companyId;
    protected string $locationId;
    protected string $createdDate;
    protected string $updatedDate;
    protected AppleAggregateRatingState $state;
    protected string $etag;
    protected AppleAggregateRatingDetails $aggregateRatingDetails;
    /**
     * @var AppleValidationReport[] $validationReports
     */
    protected array $validationReports;

    public function __construct(array $data){
        $this->setProperties($data, array(
            'state' => AppleAggregateRatingState::class,
            'aggregateRatingDetails' => AppleAggregateRatingDetails::class
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

    public function getCreatedDate(): string
    {
        return $this->createdDate;
    }

    public function getUpdatedDate(): string
    {
        return $this->updatedDate;
    }

    /**
     * @return AppleAggregateRatingState
     */
    public function getState(): AppleAggregateRatingState
    {
        return $this->state;
    }

    public function getEtag(): string
    {
        return $this->etag;
    }

    public function getAggregateRatingDetails(): AppleAggregateRatingDetails
    {
        return $this->aggregateRatingDetails;
    }

    /**
     * @return AppleValidationReport[]
     */
    public function getValidationReports(): array
    {
        return $this->validationReports;
    }

}