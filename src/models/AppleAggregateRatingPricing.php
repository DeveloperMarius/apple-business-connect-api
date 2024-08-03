<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 *  "indicator": 4
 *  }
 */
class AppleAggregateRatingPricing extends DataClass
{
    protected AppleAggregateRatingPricingIndicator $indicator;

    public function __construct(array $data)
    {
        $this->setProperties($data, array(
            'indicator' => AppleAggregateRatingPricingIndicator::class
        ));
    }

    /**
     * @return AppleAggregateRatingPricingIndicator
     */
    public function getIndicator(): AppleAggregateRatingPricingIndicator
    {
        return $this->indicator;
    }

    /**
     * @param AppleAggregateRatingPricingIndicator $indicator
     */
    public function setIndicator(AppleAggregateRatingPricingIndicator $indicator): void
    {
        $this->indicator = $indicator;
    }

}