<?php

/**
 * Alonity inheritance controller class
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

namespace alonity\alonity\MVC\Controller;

use alonity\router\RequestInheritance;
use alonity\router\ResponseInheritance;

class ControllerInheritance {

    private $method = '';


    public function index(RequestInheritance $request, ResponseInheritance $response){
        $response->setCode(404)
            ->send("{$request->getMethod()} / 404 | Method \"{$this->method}\" not found");
    }



    /**
     * If call to undefined method, used index method
     * with response code 404
     *
     * Param $args[0] = request , $args[1] = response
     *
     * @param string $method
     *
     * @param array $args
    */
    public function __call(string $method, $args = []){
        $this->method = $method;

        $this->index($args[0], $args[1]);
    }
}