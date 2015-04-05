<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of routeCheck
 *
 * @author Broff
 */
class routeCheck
{
    public $url;
    public function __construct($ar1,$ar2,$ar3,$ar4)
    {
        $this->arg = array();        
        $this->arg[1] = $ar1;
        $this->arg[2] = $ar2;
        $this->arg[3] = $ar3;
        $this->arg[4] = $ar4;      
        $this->checkUrl();        
    }
    
    private function checkUrl()
    {
        $url = "";
        if($this->arg[1] == 'caffes')
        {
            $url .=$this->arg[1];
            if(is_numeric($this->arg[2]))
            {
                $url .= "/".$this->arg[2];
                if($this->arg[3] == 'album')
                {
                    $url .= "/".$this->arg[3]."/".$this->arg[4];                    
                }
                else if($this->arg[3] == 'rooms')
                {
                    if(is_numeric($this->arg[4]))
                    {
                        $url .= "/".$this->arg[3]."/".$this->arg[4]; 
                    }
                    else
                    {
                        return false;
                    }
                }
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
        $this->url = $url;
    }
    
    public function createUrl()
    {     
        if($this->url != false)
        {
            if(!file_exists($this->url))
            {
                if(mkdir($this->url, 0777, true))
                {
                    return true;
                }
                return false;
            }    
            else
            {   
                return true;
            }
            
        }
    }
}
