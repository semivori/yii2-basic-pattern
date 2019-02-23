<?php

namespace app\services\common;

use Yii;

/**
 * Class TimeZoneService
 * @package app\services\common
 */
class TimeZoneService
{
    /**
     * Get list of all time zones.
     * @return array|null
     */
    public static function getList()
    {
        $tzList = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);
        $tzList = array_flip($tzList);

        foreach ($tzList as $key => $value) {
            $tzList[$key] = $key;
        }

        return $tzList;
    }
}
