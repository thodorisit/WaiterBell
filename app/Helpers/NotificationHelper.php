<?php

namespace App\Helpers;

class NotificationHelper {
    
    public static function avalable_notification_states() {
        //Notifications database table, STATE column
        return [
            '0', // Pending
            '1', // Completed, Done
            //'9' Return all results in search
        ];
    }

    public static function is_valid_state_search($state) {
        if (in_array($state, self::avalable_notification_states()) || $state == 9) {
            return true;
        } else {
            return false;
        }
    }

    public static function is_valid_state_sql($state) {
        if (in_array($state, self::avalable_notification_states())) {
            return true;
        } else {
            return false;
        }
    }

}
