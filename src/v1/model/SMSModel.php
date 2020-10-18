<?php
namespace DigiShop\Model;


use DigiShop\Config;
use DigiShop\MyPDO;
use Kavenegar\KavenegarApi;
use Kavenegar\Exceptions\ApiException;
use Kavenegar\Exceptions\HttpException;
class SMSModel
{

    public function sendSMS($phoneNumber , $token, $template) {


        $error = "";
        $result = "";
        try{
            $api = new KavenegarApi(Config::$API_KEY_KAVENEGAR);
            $type = "sms";//sms | call
            $result = $api->VerifyLookup($phoneNumber,$token,"","",$template,$type);
            $result = print_r($result, true);
        }
        catch(ApiException $e){
            $error =  $e->errorMessage();
            $this->storeSMS($phoneNumber , $token, $template, $error, $result);
            return 0;
        }
        catch(HttpException $e){
            $error = $e->errorMessage();
            $this->storeSMS($phoneNumber , $token, $template, $error, $result);
            return 0;
        }
        $this->storeSMS($phoneNumber , $token, $template, $error, $result);
        return 1;
    }

    public function storeSMS($phoneNumber , $token, $template, $error , $result  ) {
        MyPDO::doQuery(
            "INSERT INTO `sms`(  `phoneNumber`,   `template`,   `token`, `status`, `result`, `error`) 
                 VALUES (?, ? , ? , ? , ? , ? )",[
                     $phoneNumber, $template,$token, $error == "" ?"Success":"Failed", $result,  $error
        ], false);


    }
}
