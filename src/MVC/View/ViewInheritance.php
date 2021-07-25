<?php

/**
 * Alonity inheritance view class
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
 * @version 1.0.0
 *
 */

namespace alonity\alonity\MVC\View;

use alonity\alonity\Alonity;
use alonity\alonity\Tools\Temp;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ViewInheritance {



    /**
     * Returned templater loader
     *
     * @return FilesystemLoader
    */
    public static function templaterLoader() : FilesystemLoader {
        $loader = Temp::get('TEMPLATER_LOADER');

        if(!is_null($loader)){ return $loader; }

        /** @var $alonity Alonity */
        $alonity = Temp::get('ALONITY');

        return Temp::set('TEMPLATER_LOADER', new FilesystemLoader($alonity->getTemplateDir()));
    }



    /**
     * Returned templater Enviroment
     *
     * @return Environment
     */
    public static function templaterEnv() : Environment {
        $env = Temp::get('TEMPLATER_ENVIROMENT');

        if(!is_null($env)){ return $env; }

        return Temp::set('TEMPLATER_ENVIROMENT', new Environment(self::templaterLoader()));
    }



    /**
     * Add global variables by key => value array
     *
     * @param array $data
     *
     * @return Environment
     */
    public static function addGlobalVariables(array $data) : Environment {
        $env = self::templaterEnv();

        foreach($data as $k => $v){
            $env->addGlobal($k, $v);
        }

        return $env;
    }



    /**
     * Add global functions by key => value array
     *
     * @param array $data
     *
     * @return Environment
     */
    public static function addGlobalFunctions(array $data) : Environment {
        $env = self::templaterEnv();

        foreach($data as $k => $v){
            $env->addFunction(new TwigFunction($k, $v));
        }

        return $env;
    }



    /**
     * Add global filters by key => value array
     *
     * @param array $data
     *
     * @return Environment
     */
    public static function addGlobalFilters(array $data) : Environment {
        $env = self::templaterEnv();

        foreach($data as $k => $v){
            $env->addFilter(new TwigFilter($k, $v));
        }

        return $env;
    }



    /**
     * Write template
     *
     * @param string $filename
     *
     * @param array $data
     *
     * @return string
    */
    public static function render(string $filename, array $data = []) : string {
        try {
            $render = self::templaterEnv()->render($filename, $data);
        } catch (LoaderError | RuntimeError | SyntaxError $e) {
            $render = $e->getMessage();
        }

        return $render;
    }

}