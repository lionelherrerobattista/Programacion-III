<?php
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    require 'vendor/autoload.php';
    require_once "./entidades/pizzeriaAPI.php";

    $config['displayErrorDetails'] = true;
    $config['addContentLengthHeader'] = false;

    $app = new \Slim\App(["settings" => $config]);

    $app->group('', function()
    {
        //cargar vehiculo
        $this->post('/pizzas', \PizzeriaAPI::class . ':cargarPizza');

        $this->get('/pizzas', \PizzeriaAPI::class . ':consultarPizza');

        $this->post('/ventas', \PizzeriaAPI::class . ':venderPizza');

        $this->post('/pizza', \PizzeriaAPI::class . ':modificarPizza');

        $this->get('/ventas', \PizzeriaAPI::class . ':consultarVenta');

        $this->delete('/pizzas', \PizzeriaAPI::class . ':borrarPizza');

        $this->get('/logs', \PizzeriaAPI::class . ':consultarLog');

    });

    $app->run();


?>