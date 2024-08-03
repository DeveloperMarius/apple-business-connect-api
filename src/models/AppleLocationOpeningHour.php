<?php

namespace developermarius\applebusinessconnect\api\models;


use utils\DataClass;

/**
 * @method AppleLocationOpeningHourDay getDay()
 * Example: {
 *  "day" : "MONDAY",
 *  "times" : [
 *  {
 *  "startTime" : "10:00",
 *  "endTime" : "22:00"
 *  }
 *  ]
 *  },
 */
class AppleLocationOpeningHour extends DataClass
{

    protected AppleLocationOpeningHourDay $day;
    /**
     * @var AppleLocationOpeningHourTime[]
     */
    protected array $times;

    public function __construct(array $data){
        parent::setProperties($data, array(
            'day' => AppleLocationOpeningHourDay::class,
            'times' => AppleLocationOpeningHourTime::class
        ));
    }

    /**
     * @param AppleLocationOpeningHourDay $day
     * @param string $start - format: "HH:MM"
     * @param string $end - format: "HH:MM"
     * @return AppleLocationOpeningHour
     */
    public static function create(AppleLocationOpeningHourDay $day, string $start, string $end): AppleLocationOpeningHour
    {
        return new AppleLocationOpeningHour(array(
            'day' => $day,
            'times' => array(
                AppleLocationOpeningHourTime::create($start, $end)
            )
        ));
    }
}