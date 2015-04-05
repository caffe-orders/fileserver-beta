<?php

class DownloadSessions 
{
    public function __construct()
    {
    }
    
    public function info($user_id, $code)
    {        
        $query = "downloadsessions/info?user_id=$user_id&code=$code";        
        $data = Curl::NewQuery($query);
        if(isset($data['data']))
        {
            return $data['data'];
        }
        else 
        {
            return null;
        }
    }
    
    public function fileload($user_id, $code)
    {
        $query = "downloadsessions/fileload?user_id=$user_id&code=$code";        
        $data = Curl::NewQuery($query);
        if(isset($data['data']))
        {
            return $data['data'];
        }
        else 
        {
            return null;
        }
    }
    
    public function delete($user_id)
    {
        $query = "downloadsessions/delete?user_id=$user_id";        
        Curl::NewQuery($query);
    }
}

