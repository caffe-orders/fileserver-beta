<?php

class Token 
{
    public function __construct()
    {
    }
    
    public function get($sessionHash, $token)
    {        
        $query = "filesToken/get?token=$token&sessionHash=$sessionHash";        
        $data = Curl::NewQuery($query);
        if(isset($data))
        {
           
            return $data;
        }
        else 
        {
            return null;
        }
    }
    
    public function delete($sessionHash, $token)
    {
        $query = "filesToken/delete?token=$token&sessionHash=$sessionHash";        
        Curl::NewQuery($query);
    }
}

