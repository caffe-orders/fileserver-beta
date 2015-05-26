<?php
/**
 * Description of routeCheck
 *
 * @author Broff
 */
class routeCheck
{
    public $url = null;
    private $splitedPath = array(); 
    private $schemeUrl = array(); 
    private $placesAndRooms = array(); 
    private $rooms = null;
    
    public function __construct($filePath, $fileType, $placesAndRooms)
    {
        $this->splitedPath = explode('/',$filePath);
        
        $this->placesAndRooms = $placesAndRooms;
        $this->initSchem($fileType);
        $this->initUrl();        
    }
    
    private function initUrl()
    {        
        
        if(count($this->splitedPath) != count($this->schemeUrl))
        {
            $this->url = null;
            return ;
        }
        $this->url = 'files/';
        foreach ($this->splitedPath as $key => $pathItem)
        {
            if($pathItem != $this->schemeUrl[$key])
            {
                switch ($this->schemeUrl[$key])
                {
                    case 'PLACE_ID':
                        if(TypeChecker::IsInt($pathItem))
                        {
                            $trueId = false;
                            if($this->placesAndRooms == null)
                            {
                                $this->url = null;
                                return ; 
                            }
                            foreach($this->placesAndRooms as $item)
                            {
                                if($item['placeId'] == $pathItem)
                                {
                                    $this->rooms = $item['roomsId'];
                                    $this->url .= $pathItem . '/';
                                    $trueId = true;
                                    break;
                                }
                            }    
                            if(!$trueId)
                            {
                                $this->url = null;
                                return ; 
                            }
                        }
                        else
                        {
                            $this->url = null;
                            return ;
                        }
                    break;
                    case 'ROOM_ID':
                        if(TypeChecker::IsInt($pathItem))
                        {
                            $this->url .= $pathItem . '/';
                        }
                        else
                        {
                            $this->url = null;
                            return ;
                        }
                    break;
                    default:
                        $this->url = null;
                    break;
                }
            }
            else
            {
                $this->url .= $pathItem . '/';
            }
        }        
    }
    
    public function urlExists()
    {        
        if($this->url == null)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    
    public function createUrl()
    {     
        $result = false;
        if($this->url != null)
        {
            if(!file_exists($this->url))
            {
                if(mkdir($this->url, 0777, true))
                {
                    $result = true;
                }
            }       
            else
            {
                $result = true;
            }
        }        
        return $result;        
    }
    
    private function initSchem($fileType)
    {
        $scheme = array();
        switch($fileType)
        {
             case 'previewPlace':
                $scheme = array(
                    'places',
                    'PLACE_ID'                    
                );
                break;        
             case 'previewComplexDinner':
                $scheme = array(
                    'complexDinner'                    
                );
                break; 
            case 'roomScheme':
                $scheme = array(
                    'places',
                    'PLACE_ID',
                    'rooms',
                    'ROOM_ID'
                );
                break;
            case 'albumImg':
                $scheme = array(
                    'places',
                    'PLACE_ID',
                    'album'
                );
                break;
            case 'dish':
                $scheme = array(
                    'dishs'
                );
                break;
            default :
                $scheme = array();
                break;
        }
        $this->schemeUrl = $scheme;
    }
}
