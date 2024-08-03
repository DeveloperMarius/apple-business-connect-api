<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example {
 *  "author": {
 *  "givenName": "Robert",
 *  "lastInitial": "S.",
 *  "imageUrl": "http://goodpartner.com/media/images/author_profile_pic/user_id=43767642526I/default-avatar.jpg"
 *  },
 *  "name": "Excellent Place",
 *  "reviewBody": "Warm, friendly and entirely accommodating to all our needs.",
 *  "locale": "en",
 *  "starRatings": [
 *  {
 *  "category": "OVERALL",
 *  "ratingValue": 4,
 *  "bestRating": 5
 *  }
 *  ],
 *  "interactionStatistics": [
 *  {
 *  "interactionType": "HELPFUL",
 *  "userInteractionCount": 25
 *  }
 *  ]
 *  }
 */
class AppleReview extends DataClass
{

    protected string $name;
    protected string $reviewBody;
    protected string $locale;
    /**
     * @var AppleAggregateRatingStarRating[] $starRatings
     */
    protected array $starRatings;
    protected array $interactionStatistics;
    protected AppleReviewAuthor $author;

    public function __construct(array $data)
    {
        $this->setProperties($data, array(
            'starRatings' => AppleAggregateRatingStarRating::class,
            'author' => AppleReviewAuthor::class
        ));
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getReviewBody(): string
    {
        return $this->reviewBody;
    }

    public function setReviewBody(string $reviewBody): void
    {
        $this->reviewBody = $reviewBody;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }

    /**
     * @return AppleAggregateRatingStarRating[]
     */
    public function getStarRatings(): array
    {
        return $this->starRatings;
    }

    public function setStarRatings(array $starRatings): void
    {
        $this->starRatings = $starRatings;
    }

    public function getInteractionStatistics(): array
    {
        return $this->interactionStatistics;
    }

    public function setInteractionStatistics(array $interactionStatistics): void
    {
        $this->interactionStatistics = $interactionStatistics;
    }

    public function getAuthor(): AppleReviewAuthor
    {
        return $this->author;
    }

    public function setAuthor(AppleReviewAuthor $author): void
    {
        $this->author = $author;
    }

    public static function create(string $name, string $reviewBody, int $rating, AppleReviewAuthor $author, array $interactionStatistics, string $locale = 'de'): AppleReview
    {
        if($rating > 5 || $rating < 0){
            throw new \InvalidArgumentException('Rating must be between 0 and 5');
        }
        return new AppleReview([
            'name' => $name,
            'reviewBody' => $reviewBody,
            'locale' => $locale,
            'starRatings' => array(new AppleAggregateRatingStarRating(array(
                'category' => AppleAggregateRatingStarRatingCategory::OVERALL,
                'ratingValue' => $rating,
                'bestRating' => 5
            ))),
            'interactionStatistics' => $interactionStatistics,
            'author' => $author
        ]);
    }

}