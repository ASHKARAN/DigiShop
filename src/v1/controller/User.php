<?php
namespace DigiShop\Controller;

use DigiShop\app;
use DigiShop\Model\SMSModel;
use DigiShop\Model\UserModel;

class User
{
    public function Login($json) {
        if(!app::hasKeys($json, ['phoneNumber'])) {
            app::out(['Data' => 'Wrong inputs' , 'MissingKeys' => app::missingKeys($json, ['phoneNumber'])]);
        }
        $userModel = new UserModel();
        $userInstance = $userModel->getUserByPhoneNumber($json->phoneNumber);
        $otpCode = app::generateRandomInt();
        $smsModel = new SMSModel();
        if($userInstance == null) {//user not exists
            $userModel->addUserByPhoneNumber($json->phoneNumber, $otpCode);
            $smsModel->sendSMS($json->phoneNumber, $otpCode , "LoginRequest");
            app::out("Activation code sent by SMS $otpCode" , HTTP_OK);
        }
        else {// user already exists
                $userModel->updateOtpCode($json->phoneNumber, $otpCode);
                $smsModel->sendSMS($json->phoneNumber, $otpCode , "LoginRequest");
                app::out("Activation code sent by SMS $otpCode" , HTTP_OK);
        }
    }


}
