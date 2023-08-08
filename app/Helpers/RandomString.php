<?php

namespace App\Helpers;

use phpDocumentor\Reflection\Types\Integer;

class RandomString
{
    static $integer = '0123456789';
    static $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    public static function getRandom($count = 20, $integer = true, $characters = true)
    {
        $string = '';
        if (intval($count) && $count > 0 && ($integer || $characters)) {
            $symbols = '';
            if ($integer) $symbols .= self::$integer;
            if ($characters) {
                $symbols .= self::$characters;
                $symbols .= strtolower(self::$characters);
            }
            if (!empty($symbols)) {
                for ($i = 0; $i < $count; $i++) {
                    $index = rand(0, strlen($symbols) - 1);
                    $string .= $symbols[$index];
                }

            }
        }

        return $string;
    }

}
