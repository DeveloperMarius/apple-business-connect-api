<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example:
 * {
 * "data": [
 * {
 * "id": "1541464898790064128",
 * "state": "PUBLISHED",
 * "createdDate": "2024-02-08T12:06:50.678Z",
 * "updatedDate": "2024-02-08T12:21:33.676Z",
 * "validationReports": [],
 * "etag": "b960bbbe-dd3b-41db-9550-e480d0beb2b0",
 * "companyId": "1469747224475254784",
 * "businessDetails": {
 * "partnersBusinessId": "4",
 * "partnersBusinessVersion": "PBV01",
 * "countryCodes": [
 * "DE"
 * ],
 * "displayNames": [
 * {
 * "name": "Test Business 4",
 * "locale": "de",
 * "primary": true
 * }
 * ],
 * "categories": [
 * "food.desserts",
 * "food.gelato"
 * ],
 * "urls": [
 * {
 * "url": "https://example4.com",
 * "type": "HOMEPAGE"
 * }
 * ]
 * }
 * }
 * ],
 * "pagination": {
 * "cursors": {
 * "after": null
 * },
 * "next": null
 * },
 * "total": 1
 * }
 */
class AppleBusinessPaginationResponse extends DataClass{

    /**
     * @var AppleBusinessReadResponse[] $data
     */
    protected array $data;
    protected ApplePagination $pagination;
    protected int $total;

    public function __construct(array $data){
        if(sizeof($data['pagination']) === 0)
            $data['pagination'] = new ApplePagination(array());
        $this->setProperties($data, array(
            'data' => AppleBusinessReadResponse::class,
            'pagination' => ApplePagination::class
        ));
    }
}