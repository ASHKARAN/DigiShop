<?php


namespace DigiShop\Model;


use DigiShop\MyPDO;

class UserModel
{

    public function getUserByPhoneNumber($phoneNumber) {
        return MyPDO::doSelect(
            "SELECT * FROM `user` WHERE phoneNumber = ?",
            [$phoneNumber],
            false
        );
    }
    public function addUserByPhoneNumber($phoneNumber , $otpCode = 0) {
        return MyPDO::doQuery(
            "INSERT INTO `user` (phoneNumber, otpCode ) VALUES (? , ? ) ",
            [$phoneNumber, $otpCode]
        );
    }
    public function updateOtpCode($phoneNumber , $otpCode = 0) {
        return MyPDO::doQuery(
            "UPDATE `user` SET otpCode =  ?  WHERE phoneNumber = ? ",
            [$otpCode, $phoneNumber  ]
        );
    }
}
