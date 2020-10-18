<?php
namespace DigiShop\Controller;

use DigiShop\app;
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
        //TODO inja bayad sms befrestim
        if($userInstance == null) {//user not exists
            $userModel->addUserByPhoneNumber($json->phoneNumber, $otpCode);
            app::out("Activation code sent by SMS $otpCode" , HTTP_OK);
        }
        else {// user already exists
                $userModel->updateOtpCode($json->phoneNumber, $otpCode);
                app::out("Activation code sent by SMS $otpCode" , HTTP_OK);
        }
    }


}
