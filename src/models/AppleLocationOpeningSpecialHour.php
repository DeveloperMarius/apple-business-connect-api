<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example: {
 * "hoursByDay": [
 * {
 * "day" : "SUNDAY",
 * "times" : [
 * {
 * "startTime" : "09:00",
 * "endTime" : "12:00"
 * }
 * ]
 * }
 * ],
 * "startDate": "2022-12-25",
 * "endDate": "2022-12-25",
 * "closed": false,
 * "descriptions": [
 * {
 * "text": "Weihnachten",
 * "locale": "de-DE"
 * }
 * ]
 * }
 */
class AppleLocationOpeningSpecialHour extends DataClass
{

    /**
     * @var AppleLocationOpeningHour[]
     */
    protected array $hoursByDay;
    protected string $startDate;
    protected string $endDate;
    protected bool $closed;
    /**
     * @var AppleText[]
     */
    protected array $descriptions;

    public function __construct(array $data){
        parent::setProperties($data, array(
            'hoursByDay' => AppleLocationOpeningHour::class,
            'descriptions' => AppleText::class
        ));
    }
}