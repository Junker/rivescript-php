<?php

namespace Axiom\Rivescript\Support;

class Str
{
    /**
     * Trim leading and trailing whitespace as well as
     * whitespace surrounding individual arguments.
     *
     * @param string $string
     *
     * @return string
     */
    public static function removeWhitespace($string)
    {
        return preg_replace('/[\pC\pZ]+/u', ' ', trim($string));
    }

    /**
     * Determine if string starts with the supplied needle.
     *
     * @param string $haystack
     * @param string $needle
     *
     * @return bool
     */
    public static function startsWith($haystack, $needle)
    {
        return $needle === '' or mb_strrpos($haystack, $needle, -mb_strlen($haystack)) !== false;
    }

    /**
     * Determine if string ends with the supplied needle.
     *
     * @param string $haystack
     * @param string $needle
     *
     * @return bool
     */
    public static function endsWith($haystack, $needle)
    {
        return $needle === '' or (($temp = mb_strlen($haystack) - mb_strlen($needle)) >= 0 and mb_strpos($haystack, $needle, $temp) !== false);
    }

    public static  function replace($haystack, $needle, $replace, $limit, $start_pos = 0) 
    {
        if ($limit <= 0) {
            return $haystack;
        } else {
            $pos = strpos($haystack,$needle,$start_pos);
            if ($pos !== false) {
                $newstring = substr_replace($haystack, $replace, $pos, strlen($needle));
                return self::replace($newstring, $needle, $replace, $limit-1, $pos+strlen($replace));
            } else {
                return $haystack;
            }
        }
    }

    public static function ucwords($str)
    {
        return mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
    }

    public static function ucfirst($str)
    {
        return mb_strtoupper(mb_substr($str, 0, 1)).mb_strtolower(mb_substr($str, 1));
    }
}
