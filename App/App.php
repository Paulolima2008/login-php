<?php

namespace App;

use App\Controllers\UserController;
use Exception;

class App
{
    private $controller;
    private $controllerFile;
    private $action;
    private $params;
    public  $controllerName;

    public function __construct()
    {
        /*
         * Constantes do sistema
         */
        define('APP_HOST'       , $_SERVER['HTTP_HOST'] . "/login-php");
        define('PATH'           , realpath('./'));
        define('TITLE'          , "Autenticação - Sistema de gestão araújo seguros");
        define('DB_HOST'        , "localhost");
        define('DB_USER'        , "root");
        define('DB_PASSWORD'    , "");
        define('DB_NAME'        , "login_php");
        define('DB_DRIVER'      , "mysql");
        define('SMS_USER'       , "plima");
        define('SMS_PASSWORD'   , "LDPg7x563enEdFH8");
/*
        define('APP_HOST'       , $_SERVER['HTTP_HOST'] . "/auth");
        define('PATH'           , realpath('./'));
        define('TITLE'          , "Autenticação - Sistema de gestão araújo seguros");
        define('DB_HOST'        , "localhost");
        define('DB_USER'        , "u258278060_super");
        define('DB_PASSWORD'    , "RYqSb7abp!HZv7BAc6#!");
        define('DB_NAME'        , "u258278060_login_araujo");
        define('DB_DRIVER'      , "mysql");
        define('SMS_USER'       , "plima");
        define('SMS_PASSWORD'   , "LDPg7x563enEdFH8");

*/
        $this->url();
    }

    public function run()
    {
        if ($this->controller) {
            $this->controllerName = ucwords($this->controller) . 'Controller';
            $this->controllerName = preg_replace('/[^a-zA-Z]/i', '', $this->controllerName);
        } else {
            $this->controllerName = "UserController";
        }

        $this->controllerFile   = $this->controllerName . '.php';
        $this->action           = preg_replace('/[^a-zA-Z]/i', '', $this->action);

        if (!$this->controller) {
            $this->controller = new UserController($this);
            $this->controller->index();
        }

        if (!file_exists(PATH . '/App/Controllers/' . $this->controllerFile)) {
            throw new Exception("Página não encontrada.", 404);
        }

        $nomeClasse     = "\\App\\Controllers\\" . $this->controllerName;
        $objetoController = new $nomeClasse($this);

        if (!class_exists($nomeClasse)) {
            throw new Exception("Erro na aplicação", 500);
        }

        if (method_exists($objetoController, $this->action)) {
            $objetoController->{$this->action}($this->params);
            return;
        } else if (!$this->action && method_exists($objetoController, 'index')) {
            $objetoController->index($this->params);
            return;
        } else {
            throw new Exception("Nosso suporte já esta verificando desculpe!", 500);
        }
        throw new Exception("Página não encontrada.", 404);
    }

    public function url () {

        if ( isset( $_GET['url'] ) ) {

            $path = $_GET['url'];
            $path = rtrim($path, '/');
            $path = filter_var($path, FILTER_SANITIZE_URL);

            $path = explode('/', $path);

            $this->controller  = $this->verificaArray( $path, 0 );
            $this->action      = $this->verificaArray( $path, 1 );

            if ( $this->verificaArray( $path, 2 ) ) {
                unset( $path[0] );
                unset( $path[1] );
                $this->params = array_values( $path );
            }
        }
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getControllerName()
    {
        return $this->controllerName;
    }

    private function verificaArray ( $array, $key ) {
        if ( isset( $array[ $key ] ) && !empty( $array[ $key ] ) ) {
            return $array[ $key ];
        }
        return null;
    }
}
