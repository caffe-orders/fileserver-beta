<?php
ini_set('display_errors', 1);
session_start();
header('Access-Control-Allow-Origin: http://caffe.ru');
header('Access-Control-Allow-Headers: Cookie, origin, x-requested-with, content-type');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET,POST');
header('Content-Type', 'application/javascript; charset=utf8');
ob_implicit_flush(0);
date_default_timezone_set("Europe/Moscow");

$url = $_SERVER['DOCUMENT_ROOT']."/";
$apiUrl = 'http://api.caffe.ru/';                //Impotant 
define('URL',$url);
define('APIURL', $apiUrl);

$responce = 'load resurses fail';

include_once('core/Autoload.php');

$rawPost = json_decode(file_get_contents("php://input"));
foreach($rawPost as $key => $value)
{
    $_POST[$key] = $value;
}
print_r($_POST);


$sessionHash    = filter_input(INPUT_POST, 'sessionHash');
$token          = filter_input(INPUT_POST, 'token');
$filePath       = filter_input(INPUT_POST, 'path');
$fileType       = filter_input(INPUT_POST, 'fileType');
$fileName       = filter_input(INPUT_POST, 'fileName');

if(isset($sessionHash) && isset($token) && isset($filePath)
        && isset($fileType) && isset($fileName))
{
    $filesToken = new Token();
    $result = $filesToken->get($sessionHash, $token);
    
    if($result == $token)
    {        
        $userInfo = new UserInfo($sessionHash);
        $path = new routeCheck($filePath, $fileType, $userInfo->getPlacesAndRooms());      
        
        if($path->urlExists())
        {           
            if(isset($_FILES['file']))
            {
                $file = new fileCheck($_FILES['file'], $fileName, $fileType, $path->url);
                if($file->trueFormat())
                {
                    if($path->createUrl() == true)
                    {
                        if($file->upload() == true)
                        {
                            $filesToken->delete($sessionHash, $token);
                            $responce = array(200, 'File upload');
                        }
                        else
                        {
                            $responce = array(401, 'Error(load file)');
                        }
                    }
                    else
                    {
                        $responce = array(402, 'Error(create url)');
                    }                    
                }
                else
                {
                    $responce = array(403, 'Wrong file format');
                }
            }
            else
            {
                $responce = array(404, 'File not found');
            }
        }
        else
        {
            $responce = array(405, 'File path is wrong');
        }        
    }    
    else
    {
        $responce = array(406, 'Token not found');
    }
}
else
{
   $responce = array(407, 'Arguments is missing');
}
header('HTTP/1.0' . ' ' . $responce[0] . ' ' . $responce[1]);
echo $responce[1];