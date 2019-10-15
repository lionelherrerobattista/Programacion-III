<?php
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    require 'vendor/autoload.php';
    require_once "./entidades/loginApi.php";

    $config['displayErrorDetails'] = true;
    $config['addContentLengthHeader'] = false;

    $app = new \Slim\App(["settings" => $config]);

    $app->group('', function()
    {
        //cargar vehiculo
        $this->post('/cargarUsuario', \LoginApi::class . ':cargarUsuario');

        $this->get('/login', \LoginApi::class . ':loginUsuario');

        $this->post('/modificarUsuario', \LoginApi::class . ':modificarUsuario');

        $this->get('/verUsuarios', \LoginApi::class . ':verUsuarios');

        $this->get('/verUsuario', \LoginApi::class . ':verUsuario');

        $this->get('/logs', \LoginApi::class . ':consultarLogs');


    });

    $app->run();


?>