<?php

namespace App\Http\Middleware\Employee;

use Closure;

class NotRequiresLogin {
    public function handle($request, Closure $next) {
        if ($request->session()->has('employee_login_token')) {
            return redirect('employee/');
        } else {
            return $next($request);
        }
    }
}
