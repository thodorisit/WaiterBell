<?php

namespace App\Http\Middleware\Employee;

use Closure;

use App\Helpers\Employee\LocalizationHelper as LocalizationHelper;

class Localization {

    //Link/?changeLocale=LANGUAGE

    public function handle($request, Closure $next) {
        $languages = LocalizationHelper::languages();
        $primary_language = LocalizationHelper::primary_language();
        $change_locale = false;
        if ($request->input('changeLocale') && in_array($request->input('changeLocale'), $languages)) {
            $change_locale = $request->input('changeLocale');
            \App::setLocale($change_locale);
            \Session::put('employee_language', $change_locale);
            \Session::save();
        }

        if (\Session::get('employee_language')) {
            \App::setLocale(\Session::get('employee_language'));
        } else {
            \Session::put('employee_language', $primary_language);
            \Session::save();
            \App::setLocale($primary_language);
        }

        return $next($request);
    }
    
}
