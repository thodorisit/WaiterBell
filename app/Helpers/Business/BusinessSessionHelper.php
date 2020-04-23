<?php

namespace App\Helpers\Business;

use App\Helpers\JwtHelper as JWT;

class BusinessSessionHelper {
    
    public static function id() {
        $token = \Session::get('business_login_token');
        $token_decoded = JWT::decode($token);
        return $token_decoded->id;
    }

}
