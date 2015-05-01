<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of userInfo
 *
 * @author Broff
 */
class UserInfo
{
    private $sessionHash;
    private $userId = null;
    private $placesAndRooms = array();
    
    public function __construct($sessionHash)
    {
        $this->sessionHash = $sessionHash;
        $this->initPlacesAndRooms();
    }
    
    public function getPlacesAndRooms()
    {        
        if($this->placesAndRooms != null)
        {
            return $this->placesAndRooms;
        }
        else
        {
            return null;
        }
    }
    private function initPlacesAndRooms()
    {
        if($this->initUserId())
        {
            if($this->initPlacesId())
            {
                $this->initRoomsId();
            }
        }        
    }
    
    private function initUserId()
    {
        $state = false;
        $query = "users/id?sessionHash=$this->sessionHash";        
        $data = Curl::NewQuery($query);        
        if(isset($data))
        {            
            if($data['isActive'] == 0 && $data['access'] >= 2)
            {
                $this->userId = $data['id'];
                $state = true;
            }
        }
        return $state;
    }
    
    private function initPlacesId()
    {
        $state = false;
        $query = "places/owned?userId=$this->userId";        
        $data = Curl::NewQuery($query);
        if(isset($data))
        {
            foreach($data as $place)
            {
                $this->placesAndRooms[] = array(
                    'placeId' => $place['id'],
                    'roomsId' => array()                    
                );
                $state = true;
            }
        }
        return $state;
    }
    
    private function initRoomsId()//Need model rooms in api
    {
        $state = false;
        foreach($this->placesAndRooms as $key => $place)
        {
            $placeId = $place['placeId'];
            $query = "rooms/list?placeId=$placeId";        
            $rooms = Curl::NewQuery($query);
            if(isset($rooms))
            {
                $arrRooms = array();
                foreach($rooms as $room)
                {
                     $arrRooms[] = $room['id'];
                }
                $this->placesAndRooms[$key]['roomsId'] = $arrRooms;
            } 
        }        
        return $state;
    }
}
