<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of fileCheck
 *
 * @author qw
 */
class fileCheck {
    
    
    private $scheme = array();
    private $file;
    private $fileName; 
    private $urlPath;
    
    public function __construct($file, $name, $type, $url) {
        $this->file = $file;
        $this->fileName = basename($name);
        $this->urlPath = $url;
        $this->initScheme($type);
    }   
    
    public function trueFormat()
    {
        $format = false;
        if($this->file['error'] === 0)
        {
            $fileType = explode('/', $this->file['type']);
            foreach ($this->scheme as $key => $value)
            {
                if($fileType[1] == $key)
                {
                    if($this->file['size'] <= 1024 * 1024 * $value)                
                    {
                        $format = true;                        
                    }     
                }
            }
        }
        return $format;
    }

    public function upload()
    {
        $upload = false;
        if($this->trueFormat())
        {
            $temp = $this->file['tmp_name'];
            $fileUrl = $this->urlPath . $this->fileName;
            if(move_uploaded_file($temp, $fileUrl))
            {
                $upload = true;
            }            
        }
        return $upload;
    }
    
    private function initScheme($type)
    {
        $scheme = array();
        switch($type)
        {
            case 'previewPlace':
                $scheme = array(
                    'jpeg'   => 1,
                    'jpg'   =>0.5
                );
                break;
            case 'dish':
                $scheme = array(
                    'jpg'   => 1,
                    'png'   => 1.3
                );
                break;
            case 'roomSheme':
                $scheme = array(
                    'jpg'   => 1,
                    'png'   => 1.3
                );
                break;
            case 'albumImg':
                $scheme = array(
                    'jpg'   => 1,
                    'png'   => 1.3
                );
                break;
            default :
                $scheme = array(
                    'jpg'   => 1,
                    'png'   => 1.3,
                    '3d'    => 20
                );
                break;
        }
        $this->scheme = $scheme;
    }
    //type - value
    //size
}
