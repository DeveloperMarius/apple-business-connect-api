<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
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
 * "ratingValue": 4,
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
 * }
 */
class AppleReviewDetails extends DataClass
{

    protected string $partnersReviewId;
    protected string $dateAdded;
    protected AppleReview $review;

    public function __construct(array $data)
    {
        $this->setProperties($data, array(
            'review' => AppleReview::class
        ));
    }

    public function getPartnersReviewId(): string
    {
        return $this->partnersReviewId;
    }

    public function getDateAdded(): string
    {
        return $this->dateAdded;
    }

    public function getReview(): AppleReview
    {
        return $this->review;
    }

    public function setPartnersReviewId(string $partnersReviewId): void
    {
        $this->partnersReviewId = $partnersReviewId;
    }

    public function setDateAdded(string $dateAdded): void
    {
        $this->dateAdded = $dateAdded;
    }

    public function setReview(AppleReview $review): void
    {
        $this->review = $review;
    }

}