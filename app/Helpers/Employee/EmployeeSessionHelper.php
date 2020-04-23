<?php

namespace App\Helpers\Employee;

use App\Helpers\JwtHelper as JWT;

class EmployeeSessionHelper {
    
    public static function id() {
        $token = \Session::get('employee_login_token');
        $token_decoded = JWT::decode($token);
        return $token_decoded->id;
    }
    
    public static function business_id() {
        $token = \Session::get('employee_login_token');
        $token_decoded = JWT::decode($token);
        return $token_decoded->business_id;
    }

}
