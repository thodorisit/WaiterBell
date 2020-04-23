<?php

namespace App\Http\Middleware\Business;

use Closure;

class NotRequiresLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->has('business_login_token')) {
            return redirect('business/');
        } else {
            return $next($request);
        }
    }
}
