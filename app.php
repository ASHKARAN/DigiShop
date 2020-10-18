<?php


namespace DigiShop;


class app
{


    public static function generateRandomString($length = 10)
    {
        $characters = '0123456789qwertyuiopasdfghjklzxcvbnm!@#$%^&*()';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function generateRandomInt($length = 6)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }



    public static function hasKeys($json , $items) {
        foreach ($items as $item) {
            if(!isset($json->$item)) return false;
        }

        return true ;
    }

    public static function missingKeys($json , $items) {
        $missing = array();
        foreach ($items as $item) {
            if(!isset($json->$item)) $missing[] =  $item;
        }

        return $missing ;
    }


    public static function out($response , $HTTP_STATUS_CODE = HTTP_BAD_REQUEST  ,   $system = false) {
        if(is_array($response))
             $res  = array('Success' => $HTTP_STATUS_CODE==200) + $response;
        else $res  = array('Success' => $HTTP_STATUS_CODE==200, "Data" => $response) ;


        if(!$system){
            http_response_code($HTTP_STATUS_CODE);
        }


       if($system) return $res;
       die(json_encode($res));
    }



    public static function getUserIpAddr(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }



    public static function splitMoney($money) {
        $money = strrev($money);
        $data = str_split($money , 3);
        $len = count($data);
        $value = "";
        for($i =0 ; $i<$len ; $i++) {
            if($i<$len-1) {
                $value .= $data[$i] . ",";
            }else   $value .= $data[$i]  ;
        }

        return strrev($value);
    }

    public static function now() {
        return (Jalalian::now()->format('Y-m-d H:i:s'));
    }

    public static function getallheaders() {
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
    public static  function isJson($string) {
        return ((is_string($string) &&
            (is_object(json_decode($string)) ||
                is_array(json_decode($string))))) ? true : false;
    }


}
