<?php

namespace App\Http\Middleware\Customer;

use Closure;

use App\Helpers\LanguageHelper as LanguageHelper;

class Localization {

    //Link/?changeLocale=LANGUAGE
    public function handle($request, Closure $next) {
        $languages = array_keys(LanguageHelper::get());
        //$primary_language = 'en';

        $change_locale = false;
        if ($request->input('changeLocale') && in_array($request->input('changeLocale'), $languages)) {
            $change_locale = $request->input('changeLocale');
            \App::setLocale($change_locale);
            \Session::put('customer_language', $change_locale);
            \Session::save();
        }

        if (\Session::get('customer_language')) {
            \App::setLocale(\Session::get('customer_language'));
        } else {
            /**
             * The default language is now set in CustomerController - home() 
             * On load it gets the language with is_default flag
             *  */
            //\Session::put('customer_language', $primary_language);
            //\App::setLocale($primary_language);
        }

        return $next($request);
    }

}
