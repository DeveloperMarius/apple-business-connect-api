<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 * "starRatings": [
 * {
 * "category": "OVERALL",
 * "bestRating": 5,
 * "worstRating": 1,
 * "ratingValue": 4.0,
 * "ratingCount": 504,
 * "reviewCount": 249,
 * "distribution": [
 * { "key": "1", "value": 7},
 * { "key": "2", "value": 19},
 * { "key": "3", "value": 25},
 * { "key": "4", "value": 358},
 * { "key": "5", "value": 95}
 * ]
 * }
 * ],
 * "pricing": {
 * "indicator": 4
 * }
 * }
 */
class AppleAggregateRatingDetails extends DataClass
{
    /**
     * @var AppleAggregateRatingStarRating[] $starRatings
     */
    protected array $starRatings;
    protected AppleAggregateRatingPricing $pricing;

    public function __construct(array $data){
        $this->setProperties($data, array(
            'starRatings' => AppleAggregateRatingStarRating::class,
            'pricing' => AppleAggregateRatingPricing::class
        ));
    }

    public function getStarRatings(): array
    {
        return $this->starRatings;
    }

    public function setStarRatings(array $starRatings): void
    {
        $this->starRatings = $starRatings;
    }

    public function getPricing(): AppleAggregateRatingPricing
    {
        return $this->pricing;
    }

    public function setPricing(AppleAggregateRatingPricing $pricing): void
    {
        $this->pricing = $pricing;
    }

}