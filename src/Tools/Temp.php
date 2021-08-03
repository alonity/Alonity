<?php

/**
 * Alonity temprorary storage class
 *
 *
 * @author Qexy admin@qexy.org
 *
 * @copyright © 2021 Alonity
 *
 * @package alonity\alonity
 *
 * @license MIT
 *
 * @version 1.1.0
 *
 */

namespace alonity\alonity\Tools;

class Temp {
    private static $storage = [];


    /** Some salt. Just for stronger hash */
    private static $salt = "#kX*=LajeG\wK>&I]f)S%7y#l>fk4COv2giDP9*oR?C№k*q|№GY^&#c#|/=7%`%-";



    /**
     * Generage hash by key
     *
     * @param mixed $key
     *
     * @return string
    */
    private static function hash($key) : string {
        if(is_object($key)){
            $key = serialize($key);
        }

        $key = var_export($key, self::$salt);

        return md5($key);
    }



    /**
     * Set temporary value by key
     *
     * @param mixed $key
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public static function set($key, $value){
        $token = self::hash($key);

        self::$storage[$token] = $value;

        return $value;
    }



    /**
     * Get temporary value by key
     *
     * @param mixed $key
     *
     * @return mixed
     */
    public static function get($key){
        $token = self::hash($key);

        return self::$storage[$token] ?? null;
    }



    /**
     * Check exist variable by key
     *
     * @param mixed $key
     *
     * @return bool
     */
    public static function has($key) : bool {
        $token = self::hash($key);

        return isset(self::$storage[$token]);
    }



    /**
     * Delete variable by key
     *
     * @param mixed $key
     *
     * @return bool
     */
    public static function delete($key) : bool {
        $token = self::hash($key);

        if(array_key_exists($token, self::$storage)){
            unset(self::$storage[$token]);

            return true;
        }

        return false;
    }
}