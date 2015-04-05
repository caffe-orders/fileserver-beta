<?php

class Route
{
    public $param1;
    public $param2;
    public $param3;
    public $param4;
    
    public function start()
    {
        // контроллер и действие по умолчанию
        $param1 = '';
        $param2 = '';
        $param3 = '';
        $routes = explode('/', $_SERVER['REQUEST_URI']);

        // получаем имя экшена
        if ( !empty($routes[2]) )
        {
            $param1 = strtolower($routes[2]);
        }
        
        if ( !empty($routes[3]))
        {
            $param2 = $routes[3];
        }  
        
        if ( !empty($routes[4]))
        {
            $param3 = $routes[4];
        }
        
        if ( !empty($routes[5]))
        {
            $param4 = $routes[5];
        }  
        
        $this->param1 = $param1;
        $this->param2 = $param2;
        $this->param3 = $param3;
        $this->param4 = $param4;
    }
}
