<?php
class TypeChecker
{
    
    //
    //return bool
    //
    public static function IsInt($value)
    {
        if(preg_match("/[0-9]$/", $value))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    //
    //return bool
    //
    public static function IsNickname($value)
    {
        if(preg_match("/^[a-z0-9_-]{3,16}$/", $value))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    //
    //return bool
    //
    public static function IsPassword($value)
    {
        if(preg_match("/^[a-z0-9_-]{3,16}$/", $value))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
}
?>