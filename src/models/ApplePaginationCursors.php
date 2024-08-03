<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

class ApplePaginationCursors extends DataClass
{

    protected ?string $after = null;
    protected ?string $before = null;

    public function __construct(array $data){
        parent::setProperties($data);
    }

}