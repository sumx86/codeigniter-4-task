<?php

namespace App\Libraries;

class Str {

    /*
        * Check if a string starts with a certain string
        */
    public static function startswith($string, $search, $ignorecase = false) {
        
    }

    /*
        * Check if a string ends with a certain string
        */
    public static function endswith($string, $search, $ignorecase = false) {
        
    }

    /*
        * Check if a string contains atleast one uppercase letter
        */
    public static function contains_upper($string) {
        return preg_match('/[A-Z]/', $string);
    }

    /*
        * Check if a string contains atleast one digit
        */
    public static function contains_digit($string) {
        return preg_match('/[0-9]/', $string);
    }

    /*
        * Check if a given string is empty
        */
    public static function is_empty($string) {
        return trim($string) == '';
    }

    /*
        * Split a string by the number of characters specified in $limit
        */
    public static function splitfixed($string, $limit) {
        if( self::length($string) <= $limit ) {
            return [$string];
        }
        $array = [];
        $count = ceil(self::length($string) / $limit);
        for( $i = 0, $j = 0;
                $i < $count;
                $i++,
                $j += $limit )
        {
            array_push($array, self::substring($string, $j, $limit));
        }
        return $array;
    }

    /*
        * Reassemble a string array into a single string
        */
    public static function reassemble($array) {
        $string = '';
        foreach($array as $str) {
            $string .= $str;
        }
        return $string;
    }

    /*
        * Check if a string's length is in a given range
        */
    public static function in_range($string, $range) {
        $min = $range[0];
        $max = $range[1];
        $len = self::length($string);
        return $len >= $min && $len <= $max;
    }

    /*
        * Count the number of occurrences of $search in $str
        */
    public static function count($str, $search) {
        return mb_substr_count($str, $search, 'UTF-8');
    }

    /*
        * Get a substring from a string
        */
    public static function substring($string, $start, $length = null) {
        return mb_substr((string) $string, $start, $length, 'UTF-8');
    }

    /*
        * Check if a string contains a certain substring
        */
    public static function contains($string, $search, $ignorecase = false) {
        if( $search == '' ) {
            return false;
        }
        switch( $ignorecase ) {
            case true:
                $string = self::lower($string);
                $search = self::lower($search);
                break;
            default:
                break;
        }
        if( mb_strpos($string, $search, 0, 'UTF-8') != false ) {
            return true;
        }
        return false;
    }

    /*
        * Check if two strings are equal
        */
    public static function equal($str1, $str2) {
        return $str1 == $str2;
    }

    /*
        * Check if a $string is any of the values provided in $array, if not return $default one, otherwise return the $string
        */
    public static function getstr($string, $array, $default) {
        if(!in_array($string, $array)) {
            return $default;
        }
        return $string;
    }

    /*
        * Check if the string $string is in the array $array
        */
    public static function is_in($string, $array) {
        foreach($array as $item) {
            if(self::equal($string, $item)) {
                return true;
            }
        }
        return false;
    }

    /*
        * Replace all occurrences of each element in the array with its associated value
        */
    public static function replace_all($string, $array) {
        $newString = '';
        if(count($array) > 0) {
            $newString = str_replace(array_keys($array), array_values($array), $string);
        }
        return $newString;
    }

    /*
        * Replace single and double quotes
        */
    public static function replace_all_quotes($string, $inverse = false) {
        return $inverse ? self::replace_all($string, ['[quot1]' => '\'', '[quot2]' => '"', '[colon]' => ';'])
                        : self::replace_all($string, ['\'' => '[quot1]', '"' => '[quot2]', ';' => '[colon]']);
    }

    /*
        * Convert quotes to html entities
        */
    public static function htmlEnt($string) {
        return htmlentities($string, ENT_QUOTES, 'UTF-8');
    }

    /*
        * Truncate a string to the number of characters specified
        */
    public static function truncate($string, $numchars = 0) {
        return ($numchars > 0 && self::length($string) > $numchars) ? self::substring($string, 0, $numchars) . "..." : $string;
    }

    /*
        * Convert to upper case
        */
    public static function upper($string) {
        return mb_strtoupper((string) $string, 'UTF-8');
    }

    /*
        * Convert to lower case
        */
    public static function lower($string) {
        return mb_strtolower((string) $string, 'UTF-8');
    }

    /*
        * Convert to title case
        */
    public static function title($string) {
        return mb_convert_case((string) $string, MB_CASE_TITLE, 'UTF-8');
    }
    
    /*
        * Check if the given string contains only ascii characters
        */
    public static function is_ascii($string) {
        return mb_detect_encoding((string) $string, 'ASCII', true);
    }

    /*
        * Returns the length of a string
        */
    public static function length($string) {
        return mb_strlen($string);
    }
}
?>