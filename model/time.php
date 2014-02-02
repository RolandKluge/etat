<?php

class TimeUtils {

    private static $allMonths = array(
        1 => "Januar",
        2 => "Februar",
        3 => "März",
        4 => "April",
        5 => "Mai",
        6 => "Juni",
        7 => "Juli",
        8 => "August",
        9 => "September",
        10 => "Oktober",
        11 => "November",
        12 => "Dezember"
    );

    static function getCurrentYear() {
        return (int) date('Y');
    }

    static function getPreviousMonthId() {
        $current = (int) date('m');
        if ($current == 1) {
            return 12;
        } else {
            return $current - 1;
        }
    }

    static function getMonths() {
        return self::$allMonths;
    }

    /* @var $monthId int */
    static function getMonth($monthId) {
        $months = self::getMonths();
        return $months[$monthId];
    }

}
