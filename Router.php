<?php
namespace DigiShop;


/**
 *  Main App Starter
 *
 * @author ali
 */
class Router {



    /**
     *  Navigate the user to the target
     * @param String $route
     */

    public function __construct($route , $action ) {


        $json_str = file_get_contents('php://input');
        $json = json_decode($json_str);
        try {
            $class = "DigiShop\Controller\\".$route ;
            $instance = null;
            if(class_exists($class))   {
                $instance = new $class(false);
                if(method_exists($instance, $action))
                    $instance->{$action}($json);
                else app::out("Wrong Action");

            }else   app::out("Wrong Controller");
        }
        catch(\Exception $exc) {
            echo json_encode($exc);
        }










    }
}
