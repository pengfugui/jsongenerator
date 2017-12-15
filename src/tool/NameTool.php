<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2017/12/15
 * Time: 15:49
 */

namespace jsongenerator\src\tool;


class NameTool
{
    /**
     * @tutorial user_name -> UserName
     * @param string $name
     * @return mixed
     */
    public static function toCamelCase($name) {
        $hump = preg_replace_callback('/(?:^|_)([a-z])/', function($var) {
            return strtoupper($var[1]);
        }, $name);
        return $hump;
    }

    public static function toClassPropertyName($name) {
        $tmp = self::toCamelCase($name);
        return lcfirst($tmp);
    }

    /**
     * @tutorial userName -> user_name
     * @param string $name
     * @return string
     */
    public static function toUnderscoreCase($name) {
        $temp_array = array();
        for($i=0;$i<strlen($name);$i++){
            $ascii_code = ord($name[$i]);
            if($ascii_code >= 65 && $ascii_code <= 90){
                if($i == 0){
                    $temp_array[] = chr($ascii_code + 32);
                }else{
                    $temp_array[] = '_'.chr($ascii_code + 32);
                }
            }else{
                $temp_array[] = $name[$i];
            }
        }
        return implode('',$temp_array);
    }

    public static function toClassSetterMethod($name) {
        $tmp = self::toCamelCase($name);
        return 'set'.$tmp;
    }

    public static function toClassGetterMethod($name) {
        $tmp = self::toCamelCase($name);
        return 'get'.$tmp;
    }

    /**
     * YF_user_id -> getUserId
     *
     * @param string $fieldName
     * @return string
     */
    public static function fromDbFieldToGetterMethod($fieldName) {
        $underscoreName = substr($fieldName, 3);
        return self::toClassGetterMethod($underscoreName);
    }


    public static function pluralize( $string )
    {

        $plural = array(
            array( '/(quiz)$/i',                         "$1zes"   ),
            array( '/^(ox)$/i',                      "$1en"    ),
            array( '/([m|l])ouse$/i',                "$1ice"   ),
            array( '/(matr|vert|ind)ix|ex$/i',  "$1ices"  ),
            array( '/(x|ch|ss|sh)$/i',              "$1es"    ),
            array( '/([^aeiouy]|qu)y$/i',       "$1ies"   ),
            array( '/([^aeiouy]|qu)ies$/i',     "$1y"     ),
            array( '/(hive)$/i',                        "$1s"     ),
            array( '/(?:([^f])fe|([lr])f)$/i',      "$1$2ves" ),
            array( '/sis$/i',                           "ses"     ),
            array( '/([ti])um$/i',                  "$1a"     ),
            array( '/(buffal|tomat)o$/i',       "$1oes"   ),
            array( '/(bu)s$/i',                         "$1ses"   ),
            array( '/(alias|status)$/i',            "$1es"    ),
            array( '/(octop|vir)us$/i',             "$1i"     ),
            array( '/(ax|test)is$/i',                 "$1es"    ),
            array( '/s$/i',                             "s"       ),
            array( '/$/',                                   "s"       )
        );

        $singular = array(
            array("/s$/",                                                                                               ""),
            array("/(n)ews$/",                                                                                      "$1ews"),
            array("/([ti])a$/",                                                                                         "$1um"),
            array("/((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/",    "$1$2sis"),
            array("/(^analy)ses$/",                                                                                 "$1sis"),
            array("/([^f])ves$/",                                                                                   "$1fe"),
            array("/(hive)s$/",                                                                                         "$1"),
            array("/(tive)s$/",                                                                                        "$1"),
            array("/([lr])ves$/",                                                                                       "$1f"),
            array("/([^aeiouy]|qu)ies$/",                                                                       "$1y"),
            array("/(s)eries$/",                                                                                        "$1eries"),
            array("/(m)ovies$/",                                                                                    "$1ovie"),
            array("/(x|ch|ss|sh)es$/",                                                                          "$1"),
            array("/([m|l])ice$/",                                                                                  "$1ouse"),
            array("/(bus)es$/",                                                                                         "$1"),
            array("/(o)es$/",                                                                                           "$1"),
            array("/(shoe)s$/",                                                                                         "$1"),
            array("/(cris|ax|test)es$/",                                                                            "$1is"),
            array("/([octop|vir])i$/",                                                                              "$1us"),
            array("/(alias|status)es$/",                                                                            "$1"),
            array("/^(ox)en/",                                                                                      "$1"),
            array("/(vert|ind)ices$/",                                                                          "$1ex"),
            array("/(matr)ices$/",                                                                                  "$1ix"),
            array("/(quiz)zes$/",                                                                                   "$1")
        );



        $irregular = array(
            array( 'move',   'moves'    ),
            array( 'sex',    'sexes'    ),
            array( 'child',  'children' ),
            array( 'man',    'men'      ),
            array( 'person', 'people'   )
        );

        $uncountable = array(
            'sheep',
            'fish',
            'series',
            'species',
            'money',
            'rice',
            'information',
            'equipment'
        );

        // save some time in the case that singular and plural are the same
        if ( in_array( strtolower( $string ), $uncountable ) )
            return $string;

        // check for irregular singular forms
        foreach ( $irregular as $noun )
        {
            if ( strtolower( $string ) == $noun[0] )
                return $noun[1];
        }

        // check for matches using regular expressions
        foreach ( $plural as $pattern )
        {
            if ( preg_match( $pattern[0], $string ) )
                return preg_replace( $pattern[0], $pattern[1], $string );
        }

        return $string;
    }
}