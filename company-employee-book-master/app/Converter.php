<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Converter
{
    static private $arr = array();

    private function __construct()
    {

    }

    static public function convertObjToArr($obj)
    {
        return self::$arr = json_decode(json_encode($obj), true);
    }
}
