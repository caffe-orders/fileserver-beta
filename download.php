<?php

$url =$_SERVER['DOCUMENT_ROOT']."/";
$apiUrl = 'http://api.caffe.ru/';                //Impotant 
define('URL',$url);
define('APIURL', $apiUrl);

$responce = 'load resurses fail';

include_once('core/Autoload.php');

$user_id = filter_input(INPUT_GET, 'user_id');
$code = filter_input(INPUT_GET, 'code');
$ROUTE = new Route();
$ROUTE->start();

if(isset($user_id) && isset($code))
{
    $downloadsessions = new DownloadSessions();
    $result = $downloadsessions->info($user_id, $code);
    if($result != 'FALSE' && $result != null && is_numeric($result))
    {
        $path = new routeCheck($ROUTE->param1, $ROUTE->param2, $ROUTE->param3, $ROUTE->param4);        
        if($path->createUrl())
        {
            $downloadsessions->fileload($user_id, $code);
            if(isset($_FILES['file']) && isset($_POST['filename']))
            {
                $filename = $_POST['filename'];
                $temp = $_FILES['file']['tmp_name'];
                $name_file = $path->url.'/'.$filename;
                if(move_uploaded_file($temp, $name_file))
                {
                    $responce = 'TRUE';
                }
                else
                {
                    $responce = 'FALSE';
                }
            }
            else
            {
                $responce = 'FALSE';
            }
        }
        else
        {
            $responce = 'FALSE';
        }        
    }    
    else
    {
        $responce = 'NO_ACCESS_RIGHTS';
    }
}
else
{
   $responce = 'NO_ACCESS_RIGHTS';
}

echo $responce;