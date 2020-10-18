<?php
namespace DigiShop\Controller;

use DigiShop\app;
use DigiShop\Model\SMSModel;
use DigiShop\Model\UserModel;

class User
{
    private    $userModel ;
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function Login($json) {
        if(!app::hasKeys($json, ['phoneNumber'])) {
            app::out(['Data' => 'Wrong inputs' , 'MissingKeys' => app::missingKeys($json, ['phoneNumber'])]);
        }
        $userInstance = $this->userModel->getUserByPhoneNumber($json->phoneNumber);
        $otpCode = app::generateRandomInt();
        $smsModel = new SMSModel();
        if($userInstance == null) {//user not exists
            $this->userModel->addUserByPhoneNumber($json->phoneNumber, $otpCode);
            $smsModel->sendSMS($json->phoneNumber, $otpCode , "LoginRequest");
            app::out(["Result" => "Activation code sent by SMS", "OtpCode" => $otpCode] , HTTP_OK);
        }
        else {// user already exists
            $this->userModel->updateOtpCode($json->phoneNumber, $otpCode);
                $smsModel->sendSMS($json->phoneNumber, $otpCode , "LoginRequest");
                app::out(["Result" => "Activation code sent by SMS", "OtpCode" => $otpCode] , HTTP_OK);
        }
    }

    public function Activation($json) {
        if(!app::hasKeys($json, ['phoneNumber', 'otpCode'])) {
            app::out(['Data' => 'Wrong inputs' , 'MissingKeys' => app::missingKeys($json, ['phoneNumber', 'otpCode'])]);
        }

        if(!$this->userModel->getUserByPhoneNumber($json->phoneNumber)) {
            app::out("phone number not exists");
        }


        if(!$this->userModel->checkOtpCode($json->phoneNumber, $json->otpCode)) {
            app::out("otp code is wrong");
        }

        $this->userModel->resetOtpCode($json->phoneNumber);
        echo 'let s login';
        //TODO login





    }


}
