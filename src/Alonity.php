<?php

/**
 * Alonity class
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
 * @version 2.0.0
 *
 */

namespace alonity\alonity;

use alonity\alonity\Tools\Temp;
use alonity\request\Request;
use alonity\router\RequestInterface;
use alonity\router\Router;

class Alonity {
    private $router, $request, $rootDir, $templateDir, $publicDir, $appDir;

    /**
     * Constructor class of Alonity
     *
     * @param RequestInterface | null $request
     *
     * @param Router | null $router
    */
    public function __construct(?RequestInterface $request = null, ?Router $router = null){

        $this->setRequest(is_null($request) ? new Request() : $request);

        $this->setRouter(is_null($router) ? new Router($this->getRequest()) : $router);

        Temp::set('REQUEST', $this->getRequest());

        Temp::set('ROUTER', $this->getRouter());

        Temp::set('ALONITY', $this);
    }



    /**
     * Getter of Router
     *
     * @return Router
    */
    public function getRouter() : Router {
        return $this->router;
    }



    /**
     * Setter of Router
     *
     * @param Router $router
     *
     * @return self
    */
    public function setRouter(Router $router) : self {
        $this->router = $router;

        return $this;
    }



    /**
     * Getter of Request
     *
     * @return RequestInterface
     */
    public function getRequest() : RequestInterface {
        return $this->request;
    }



    /**
     * Setter of Request
     *
     * @param RequestInterface $request
     *
     * @return self
     */
    public function setRequest(RequestInterface $request) : self {
        $this->request = $request;

        return $this;
    }



    /**
     * Setter of root directory
     *
     * @param string $directory
     *
     * @return self
     */
    public function setRootDir(string $directory) : self {
        $this->rootDir = $directory;

        return $this;
    }



    /**
     * Getter of root directory
     *
     * @return string
     */
    public function getRootDir() : string {
        if(!is_null($this->rootDir)){
            return $this->rootDir;
        }

        $dir = dirname(__DIR__);

        for($i = 0; $i < 10; $i++){
            if(is_dir("{$dir}/vendor")){ break; }

            $dir = dirname($dir);
        }

        $this->setRootDir($dir);

        return $this->rootDir;
    }



    /**
     * Setter of template directory
     *
     * @param string $directory
     *
     * @return self
     */
    public function setTemplateDir(string $directory) : self {
        $this->templateDir = $directory;

        return $this;
    }



    /**
     * Getter of template directory
     *
     * @return string
     */
    public function getTemplateDir() : string {
        if(!is_null($this->templateDir)){
            return $this->templateDir;
        }

        $this->setTemplateDir("{$this->getRootDir()}/template");

        return $this->templateDir;
    }



    /**
     * Setter of public directory
     *
     * @param string $directory
     *
     * @return self
     */
    public function setPublicDir(string $directory) : self {
        $this->publicDir = $directory;

        return $this;
    }



    /**
     * Getter of public directory
     *
     * @return string
     */
    public function getPublicDir() : string {
        if(!is_null($this->publicDir)){
            return $this->publicDir;
        }

        $this->setPublicDir("{$this->getRootDir()}/public");

        return $this->publicDir;
    }



    /**
     * Setter of app directory
     *
     * @param string $directory
     *
     * @return self
     */
    public function setAppDir(string $directory) : self {
        $this->appDir = $directory;

        return $this;
    }



    /**
     * Getter of app directory
     *
     * @return string
     */
    public function getAppDir() : string {
        if(!is_null($this->appDir)){
            return $this->appDir;
        }

        $this->setAppDir("{$this->getRootDir()}/app");

        return $this->appDir;
    }

    /**
     * @throws AlonityException
     */
    public function execute() {
        $appDir = $this->getAppDir();

        $publicDir = $this->getPublicDir();

        $templateDir = $this->getTemplateDir();

        if(!is_dir("{$appDir}/models")){

            throw new AlonityException("Incorrect directories pattern. Directory \"{$appDir}/models\" not found");

        }elseif(!is_dir("{$appDir}/views")){

            throw new AlonityException("Incorrect directories pattern. Directory \"{$appDir}/views\" not found");

        }elseif(!is_dir("{$appDir}/controllers")){

            throw new AlonityException("Incorrect directories pattern. Directory \"{$appDir}/controllers\" not found");

        }elseif(!is_dir($publicDir)){

            throw new AlonityException("Incorrect directories pattern. Directory \"{$publicDir}\" not found");

        }elseif(!is_dir($templateDir)){

            throw new AlonityException("Incorrect directories pattern. Directory \"{$templateDir}\" not found");

        }

        $this->getRouter()->execute();
    }
}