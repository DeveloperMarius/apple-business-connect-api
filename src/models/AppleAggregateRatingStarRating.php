<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 *  "category": "OVERALL",
 *  "bestRating": 5,
 *  "worstRating": 1,
 *  "ratingValue": 4.0,
 *  "ratingCount": 504,
 *  "reviewCount": 249,
 *  "distribution": [
 *  { "key": "1", "value": 7},
 *  { "key": "2", "value": 19},
 *  { "key": "3", "value": 25},
 *  { "key": "4", "value": 358},
 *  { "key": "5", "value": 95}
 *  ]
 *  }
 */
class AppleAggregateRatingStarRating extends DataClass
{

    protected AppleAggregateRatingStarRatingCategory $category;
    protected int $bestRating;
    protected int $worstRating;
    protected float $ratingValue;
    protected int $ratingCount;
    protected int $reviewCount;
    /**
     * @var AppleAggregateRatingStarRatingDistribution[] $distribution
     */
    protected array $distribution;

    public function __construct(array $data){
        $this->setProperties($data, array(
            'category' => AppleAggregateRatingStarRatingCategory::class,
            'distribution' => AppleAggregateRatingStarRatingDistribution::class
        ));
    }

    public function getCategory(): AppleAggregateRatingStarRatingCategory
    {
        return $this->category;
    }

    public function getBestRating(): int
    {
        return $this->bestRating;
    }

    public function getWorstRating(): int
    {
        return $this->worstRating;
    }

    public function getRatingValue(): float
    {
        return $this->ratingValue;
    }

    public function getRatingCount(): int
    {
        return $this->ratingCount;
    }

    public function getReviewCount(): int
    {
        return $this->reviewCount;
    }

    /**
     * @return AppleAggregateRatingStarRatingDistribution[]
     */
    public function getDistribution(): array
    {
        return $this->distribution;
    }
}