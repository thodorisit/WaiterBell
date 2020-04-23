<?php

namespace App\Helpers\Employee;

class LocalizationHelper {

    public static function languages_full() {
        $languages = [
            "en" => [
                "name" => "English",
                "nativeName" => "English"
            ],
        ];
        return $languages;
    }

    public static function languages() {
        return [
            "en"
        ];
    }

    public static function primary_language() {
        return "en";
    }

    public static function current() {
        if (\Session::get('employee_language')) {
            return \Session::get('employee_language');
        } else {
            return self::primary_language();
        }
    }

}
