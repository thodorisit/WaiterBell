<?php

namespace App\Http\Middleware\Employee;

use Closure;

use App\Helpers\Employee\LocalizationHelper as LocalizationHelper;

class ViewSharing {

    public function handle($request, Closure $next) {
        view()->share('__languages', [
            'all' => LocalizationHelper::languages_full(),
            'current' => LocalizationHelper::current()
        ]);
        return $next($request);
    }

}
