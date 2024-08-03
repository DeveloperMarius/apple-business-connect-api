<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 * "data": [
 * {
 * "id": "1574554842258538496_46c77276-5f27-4f43-a955-9640ed3c5b78_PROCESSING_SUCCESSFUL",
 * "companyId": "1469747224475254784",
 * "type": "PROCESSING_SUCCESSFUL",
 * "resourceDetails": {
 * "resourceType": "BUSINESS",
 * "resourceId": "1574554842258538496",
 * "etag": "46c77276-5f27-4f43-a955-9640ed3c5b78",
 * "state": "PUBLISHED"
 * },
 * "createdDate": "2024-02-08T08:43:04.000Z",
 * "feedbackUrl": "/api/v1/companies/1469747224475254784/feedback?ql=id==1574554842258538496_46c77276-5f27-4f43-a955-9640ed3c5b78_PROCESSING_SUCCESSFUL"
 * },
 * ],
 * "pagination": {
 * "cursors": {
 * "after": "AoE/e2h1bW1pbmdiaXJkX2ZlZWRiYWNrX2FwaV9xdWFsaWZpY2F0aW9uX3YzXzlmY2IxNDhlLTAxOGQtMTAwMC04ZjA3LWI5NDFmMGNmMDMwMl8xNTU4NTc3Mzg3ODEzMjA5NjEyX2ZmYjE4MjQwLWNhMDMtMTFlZS1hZGE5LTMxZjBiMWZkNjkzZV9WQUxJREFUSU9OX0ZBSUxVUkU="
 * },
 * "next": "/v1/companies/1469747224475254784/notifications?limit=100&after=AoE/e2h1bW1pbmdiaXJkX2ZlZWRiYWNrX2FwaV9xdWFsaWZpY2F0aW9uX3YzXzlmY2IxNDhlLTAxOGQtMTAwMC04ZjA3LWI5NDFmMGNmMDMwMl8xNTU4NTc3Mzg3ODEzMjA5NjEyX2ZmYjE4MjQwLWNhMDMtMTFlZS1hZGE5LTMxZjBiMWZkNjkzZV9WQUxJREFUSU9OX0ZBSUxVUkU="
 * }
 * }
 */
class AppleNotificationPaginationResponse extends DataClass
{
    /**
     * @var AppleNotificationResponse[] $data
     */
    protected array $data;
    protected ApplePagination $pagination;

    public function __construct(array $data){
        if(sizeof($data['pagination']) === 0)
            $data['pagination'] = new ApplePagination(array());
        $this->setProperties($data, array(
            'data' => AppleNotificationResponse::class,
            'pagination' => ApplePagination::class
        ));
    }

}