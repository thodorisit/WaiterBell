<?php

namespace App\Helpers;

class JwtHelper {
     
     public static function init_key() {
        $jwtKey = '@#kl$%13dk$di94%23%6!!-=9dSJnJ&*3dKl!d@dK5$dk';
        return $jwtKey;
     }
      
    public static function decode($jwt, $key = '', $verify = true) {
        $key = self::init_key();

        $tks = explode('.', $jwt);
        if (count($tks) != 3) {
            return null;
        }
        list($headb64, $payloadb64, $cryptob64) = $tks;
        if ( null === ($header = self::jsonDecode(self::urlsafeB64Decode($headb64))) ) {
            return null;
        }
        if ( null === $payload = self::jsonDecode(self::urlsafeB64Decode($payloadb64)) ) {
            return null;
        }
        $sig = self::urlsafeB64Decode($cryptob64);
        if ($verify) {
            if (empty($header->alg)) {
                return null;
            }
            if ($sig != self::sign("$headb64.$payloadb64", $key, $header->alg)) {
                return null;
            }
        }
        return $payload;
    }
  
    public static function encode($payload, $key = '', $algo = 'HS256') {
        $key = self::init_key();

        $header = array('typ' => 'jwt', 'alg' => $algo);

        $segments = array();
        $segments[] = self::urlsafeB64Encode(self::jsonEncode($header));
        $segments[] = self::urlsafeB64Encode(self::jsonEncode($payload));
        $signing_input = implode('.', $segments);

        $signature = self::sign($signing_input, $key, $algo);
        $segments[] = self::urlsafeB64Encode($signature);

        return implode('.', $segments);
    }
  
    public static function sign($msg, $key, $method = 'HS256') {
        $methods = array(
            'HS256' => 'sha256',
            'HS384' => 'sha384',
            'HS512' => 'sha512',
        );
        if (empty($methods[$method])) {
            return null;
        }
        return hash_hmac($methods[$method], $msg, $key, true);
    }
  
    public static function jsonDecode($input) {
        $obj = json_decode($input);
        if (function_exists('json_last_error') && $errno = json_last_error()) {
            self::handleJsonError($errno);
        } else if ($obj === null && $input !== 'null') {
            return null;
        }
        return $obj;
    }
  
    public static function jsonEncode($input) {
        $json = json_encode($input);
        if (function_exists('json_last_error') && $errno = json_last_error()) {
            self::handleJsonError($errno);
        } else if ($json === 'null' && $input !== null) {
            return null;
        }
        return $json;
    }
  
    public static function urlsafeB64Decode($input) {
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $padlen = 4 - $remainder;
            $input .= str_repeat('=', $padlen);
        }
        return base64_decode(strtr($input, '-_', '+/'));
    }

    public static function urlsafeB64Encode($input) {
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }
  
     private static function handleJsonError($errno) {
        $messages = array(
            JSON_ERROR_DEPTH => 'Maximum stack depth exceeded',
            JSON_ERROR_CTRL_CHAR => 'Unexpected control character found',
            JSON_ERROR_SYNTAX => 'Syntax error, malformed JSON'
        );
        return null;
    }
  
}