<?php

namespace App\Helpers;

use Carbon\Carbon;

class CarbonHelper
{
    public static function datetime() {
        return Carbon::now()->toDateTimeString();
    }
}
