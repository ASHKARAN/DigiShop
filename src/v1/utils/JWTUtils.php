<?php
namespace DigiShop\Utils;

use DigiShop\Config;
use \Firebase\JWT\JWT;

class JWTUtils
{


    public static function encode($inputs) {
        return JWT::encode($inputs, Config::$API_KEY_JWT);
    }
    public static function decode($inputs) {
       return JWT::decode($inputs, Config::$API_KEY_JWT, array('HS256'));
    }
}
