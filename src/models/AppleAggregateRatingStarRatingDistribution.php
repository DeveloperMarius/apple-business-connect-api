<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: { "key": "1", "value": 7}
 */
class AppleAggregateRatingStarRatingDistribution extends DataClass
{

    protected AppleAggregateRatingStarRatingDistributionKey $key;
    protected int $value;

    public function __construct(array $data){
        $this->setProperties($data, array(
            'key' => AppleAggregateRatingStarRatingDistributionKey::class
        ));
    }

    /**
     * @return AppleAggregateRatingStarRatingDistributionKey
     */
    public function getKey(): AppleAggregateRatingStarRatingDistributionKey
    {
        return $this->key;
    }

    public function getValue(): int
    {
        return $this->value;
    }

}