<?php

namespace App\Http\Middleware\Employee;

use Closure;

use App\Employee;
use App\Helpers\Employee\EmployeeSessionHelper as EmployeeSessionHelper;

class RequiresLogin {
    public function handle($request, Closure $next) {
        if ($request->session()->has('employee_login_token')) {
            //Check if token exists
            $token = \Session::get('employee_login_token');
            $whereStatements = [
                ['id', '=', EmployeeSessionHelper::id()],
                ['login_token', '=', $token]
            ];
            $results = Employee::where($whereStatements)->first(['id']);
            if ($results != null) {
                return $next($request);
            } else {
                $request->session()->forget('employee_login_token');
                return redirect('employee/login');
            }
        } else {
            return redirect('employee/login');
        }
    }
}
