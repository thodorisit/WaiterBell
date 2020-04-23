<?php

namespace App\Http\Middleware\Business;

use Closure;

use App\Business;
use App\Helpers\Business\BusinessSessionHelper as BusinessSessionHelper;

class RequiresLogin {
    public function handle($request, Closure $next) {
        if ($request->session()->has('business_login_token')) {
            //Check if token exists
            $token = \Session::get('business_login_token');
            $whereStatements = [
                ['id', '=', BusinessSessionHelper::id()],
                ['login_token', '=', $token]
            ];
            $results = Business::where($whereStatements)->first(['id']);
            if ($results != null) {
                return $next($request);
            } else {
                $request->session()->forget('business_login_token');
                return redirect('business/login');
            }
        } else {
            return redirect('business/login');
        }
    }
}
