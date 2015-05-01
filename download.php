<?php
ini_set('display_errors', 1);
session_start();
ob_implicit_flush(0);
date_default_timezone_set("Europe/Moscow");

$url = $_SERVER['DOCUMENT_ROOT']."/";
$apiUrl = 'http://api.caffe.ru/';                //Impotant 
define('URL',$url);
define('APIURL', $apiUrl);

$responce = 'load resurses fail';

include_once('core/Autoload.php');

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
        $path = new routeCheck($filePath, $fileType,$userInfo->getPlacesAndRooms());      
        
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
                            $responce = array(400, 'Error(load file)');
                        }
                    }
                    else
                    {
                        $responce = array(400, 'Error(create url)');
                    }                    
                }
                else
                {
                    $responce = array(400, 'Wrong file format');
                }
            }
            else
            {
                $responce = array(400, 'File not found');
            }
        }
        else
        {
            $responce = array(400, 'File path is wrong');
        }        
    }    
    else
    {
        $responce = array(400, 'Token not found');
    }
}
else
{
   $responce = array(400, 'Arguments is missing');
}
header('HTTP/1.0' . ' ' . $responce[0] . ' ' . $responce[1]);
echo $responce[1];