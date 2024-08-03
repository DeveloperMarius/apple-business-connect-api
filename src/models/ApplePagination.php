<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 * "cursors": {
 * "after": "8U54a61d9b495324"
 * },
 * "next": "/v1/companies/9467895078742654934/businesses?ql=createdDate=gt=2022-06-30T00:00:00Z&limit=2&after=8U54a61d9b495324"
 * },
 *
 * Empty example:
 * {}
 */
class ApplePagination extends DataClass{

    protected ?ApplePaginationCursors $cursors = null;
    protected ?string $next = null;

    public function __construct(array $data){
        $this->setProperties($data, array(
            'cursors' => ApplePaginationCursors::class
        ));
    }

}