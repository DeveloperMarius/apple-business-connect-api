<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example:
 * {
 * "data": [],
 * "pagination": {
 * "cursors": {
 * "after": null
 * },
 * "next": null
 * },
 * "total": 1
 * }
 */
class AppleLocationAssetPaginationResponse extends DataClass{

    /**
     * @var AppleLocationAssetResponse[] $data
     */
    protected array $data;
    protected ApplePagination $pagination;
    protected int $total;

    public function __construct(array $data){
        if(sizeof($data['pagination']) === 0)
            $data['pagination'] = new ApplePagination(array());
        $this->setProperties($data, array(
            'data' => AppleLocationAssetResponse::class,
            'pagination' => ApplePagination::class
        ));
    }
}