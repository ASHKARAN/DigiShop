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
    public function checkOtpCode($phoneNumber , $otpCode) {
        return MyPDO::doSelect(
            "SELECT otpCode FROM `user` WHERE  otpCode =  ? AND otpCode > 0   AND  phoneNumber = ? ",
            [$otpCode, $phoneNumber  ],
            false
        );
    }
    public function resetOtpCode($phoneNumber ) {
          MyPDO::doQuery(
            "UPDATE `user` SET otpCode =  0  WHERE phoneNumber = ? ",
            [$phoneNumber  ]
        );
    }
}
