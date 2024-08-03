<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 *  "id": "1574554842258538496_46c77276-5f27-4f43-a955-9640ed3c5b78_PROCESSING_SUCCESSFUL",
 *  "companyId": "1469747224475254784",
 *  "type": "PROCESSING_SUCCESSFUL",
 *  "resourceDetails": {
 *  "resourceType": "BUSINESS",
 *  "resourceId": "1574554842258538496",
 *  "etag": "46c77276-5f27-4f43-a955-9640ed3c5b78",
 *  "state": "PUBLISHED"
 *  },
 *  "createdDate": "2024-02-08T08:43:04.000Z",
 *  "feedbackUrl": "/api/v1/companies/1469747224475254784/feedback?ql=id==1574554842258538496_46c77276-5f27-4f43-a955-9640ed3c5b78_PROCESSING_SUCCESSFUL"
 *  }
 */
class AppleNotificationResponse extends DataClass
{
    protected string $id;
    protected string $companyId;
    protected AppleNotificationType $type;
    protected array $resourceDetails;
    protected string $createdDate;
    protected string $feedbackUrl;

    public function __construct(array $data)
    {
        $this->setProperties($data, array(
            'type' => AppleNotificationType::class,
            'resourceDetails' => AppleResourceDetails::class
        ));
    }

}