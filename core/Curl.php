<?php
class Curl
{
    private function __construct()
    {
        //You shall not pass!
    }

    private function __clone()
    {
        //Me not like clones! Me smash clones!
    }

    public static function NewQuery( $query)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, APIURL . $query);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $allData = json_decode(curl_exec($curl), true);
        curl_close($curl);
        return $allData;
    }
}
?>
