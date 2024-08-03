<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 * "companyId": "1469747224475254784",
 * "locationId": "1549569011459555403",
 * "id": "1842302987261706240",
 * "createdDate": "2024-02-13T20:58:24.760Z",
 * "updatedDate": "2024-02-13T20:58:24.760Z",
 * "state": "SUBMITTED",
 * "etag": "a0e7cf80-cab2-11ee-9fa2-bd56c408e948",
 * "reviewDetails": {
 * "partnersReviewId": "857127252",
 * "dateAdded": "2022-12-01T20:06:00Z",
 * "review": {
 * "author": {
 * "givenName": "Robert",
 * "lastInitial": "S.",
 * "imageUrl": "http://goodpartner.com/media/images/author_profile_pic/user_id=43767642526I/default-avatar.jpg"
 * },
 * "name": "Excellent Place",
 * "reviewBody": "Warm, friendly and entirely accommodating to all our needs.",
 * "locale": "en",
 * "starRatings": [
 * {
 * "category": "OVERALL",
 * "ratingValue": 4.0,
 * "bestRating": 5
 * }
 * ],
 * "interactionStatistics": [
 * {
 * "interactionType": "HELPFUL",
 * "userInteractionCount": 25
 * }
 * ]
 * }
 * },
 * "validationReports": []
 * }
 */
class AppleReviewResponse extends DataClass
{

    protected string $companyId;
    protected string $locationId;
    protected string $id;
    protected string $createdDate;
    protected string $updatedDate;
    protected AppleReviewState $state;
    protected string $etag;
    protected AppleReviewDetails $reviewDetails;
    /**
     * @var AppleValidationReport[] $validationReports
     */
    protected array $validationReports;

    public function __construct(array $data)
    {
        $this->setProperties($data, array(
            'state' => AppleReviewState::class,
            'reviewDetails' => AppleReviewDetails::class,
            'validationReports' => AppleValidationReport::class
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

    public function getState(): AppleReviewState
    {
        return $this->state;
    }

    public function getEtag(): string
    {
        return $this->etag;
    }

    public function getReviewDetails(): AppleReviewDetails
    {
        return $this->reviewDetails;
    }

    public function getValidationReports(): array
    {
        return $this->validationReports;
    }

}