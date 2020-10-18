<?php
namespace DigiShop;



    //Allow AJAX Request
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
    date_default_timezone_set('Asia/Tehran');



    /**
     * include parent classes
     */
    include_once  'HttpStatusCode.php';
    include_once  'app.php';
    include_once  'Config.php';
    include_once  'MyPDO.php';
    include_once  'LoginRestricted.php';
    include_once  'Router.php';

    if(!isset($_GET['VERSION']))
        app::out(["Data" => "Not enough data, Version not found"] );

    $version = $_GET['VERSION'];



/**
 * Include all files inside src/v1 folder
 */
function load_classphp($directory) {
    if(is_dir($directory)) {
        $scan = scandir($directory);
        unset($scan[0], $scan[1]); //unset . and ..
        foreach($scan as $file) {
            if(is_dir($directory."/".$file)) {
                load_classphp($directory."/".$file);
            } else {
                if(strpos($file, '.php') !== false) {
                    include_once($directory."/".$file);
                }
            }
        }
    }
}
load_classphp("src/$version");


//Display Errors On OutPut
if(Config::$DEBUG_MODE) {
    ini_set('display_errors', 1);
    error_reporting( E_ALL );
}
else {
     ini_set('display_errors', 0);
}


 require  'vendor/autoload.php';



if(!isset($_GET['ROUTE']) || !isset($_GET['ACTION']))   {
     app::out(["Data" => "Not enough data"] );

}
else {
     $route     = $_GET['ROUTE'];
     $action    = $_GET['ACTION'];

    new  Router($route , $action);


}













