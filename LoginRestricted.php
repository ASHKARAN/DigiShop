<?php

namespace DigiShop;
/*
 *  School Project
 */
use Rest\Core\Errors;
use Rest\Core\ErrorCode;
use Rest\Core\Login;
use Rest\Core\Actions;
/**
 * Description of LoginRestricted
 *
 * @author ali.ashkaran@gmail.com
 */
class LoginRestricted {


    private $userInfo;
    /**
     *  dataye studenti ke mikhaym be parent neshon bedim
     * @var type
     */
    private $childInfo;

    public $person = -1 ;

    /**
     * if any class extends this class login will be neccessary
     */
    public function __construct() {

          $headers = getallheaders();



         if(            !isset($headers['session'])   ||
                        !isset($headers['user_id'])    ||
                        !isset($headers['client'])    ||
                        !isset($headers['person'])    ||
                        !isset($headers['shobe'])     ||
                        !isset($headers['sal'])       ||
                        ($headers['person'] == 3 && !isset($headers['student_id'])) ||
                        ($headers['person'] == 3 && !isset($headers['student_shobe']))
                 ) {
             new  Errors("Not enough data", ErrorCode::$NOT_ENOUGH_DATA );
         }
         else {
             $login = new Login();

             if(!$login->isLogin($headers['user_id'], $headers['person'], $headers['session'], $headers['client'] , $headers['shobe'] , $headers['sal']))
                     new Errors("Login Required", ErrorCode::$LOGIN_REQUIRED , Actions::$LOGOUT , null , $headers['user_id']);
         }

         $this->userInfo = $login->getUser($headers['user_id'] , $headers['person'], $headers['shobe'], $headers['sal'] );

         $this->person = $headers['person'];
         if($this->person == \PersonEnum::$vali)
            $this->childInfo = $login->getUser($headers['student_id'] , \PersonEnum::$shagerd, $headers['student_shobe'], $headers['sal'] );
    }


    public function getUser($person = -1) {
        if($person != $this->person && $person != -1) {
            return $this->childInfo;
        }

        return $this->userInfo;
    }


    public function getChildStudent($person) {
         $headers = getallheaders();
         $login = new Login();

         return $login->getUser($headers['student_id'] , $person, $headers['student_shobe'], $headers['sal'] );
    }







}
