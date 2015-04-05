<?php

function __autoload($className)
{ 
    if (file_exists($className . '.php'))
    { 
       require_once $className . '.php';          
    } 
    if(file_exists('core/'.$className . '.php'))
    {
        require_once 'core/'.$className . '.php'; 
    }
    if(file_exists('core/modules/'.$className . '.php'))
    {
        require_once 'core/modules/'.$className . '.php'; 
    }
} 