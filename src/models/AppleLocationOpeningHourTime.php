<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * Example:
 *  {
 *  "startTime" : "10:00",
 *  "endTime" : "22:00"
 *  }
 * @see https://businessconnect.apple.com/docs/data-specification/v1.3/reference#times
 */
class AppleLocationOpeningHourTime extends DataClass
{

    protected string $startTime;
    protected string $endTime;

    public function __construct(array $data){
        parent::setProperties($data);
    }

    /**
     * @param string $start - format: "HH:MM"
     * @param string $end - format: "HH:MM"
     * @return AppleLocationOpeningHourTime
     */
    public static function create(string $start, string $end): AppleLocationOpeningHourTime
    {
        return new AppleLocationOpeningHourTime(array(
            'startTime' => $start,
            'endTime' => $end
        ));
    }

}