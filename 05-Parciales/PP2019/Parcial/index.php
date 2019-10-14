<?php
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    require 'vendor/autoload.php';
    require_once "./entidades/pizzeriaAPI.php";
    require_once "./entidades/pizza.php";
    require_once "./entidades/archivo.php";

    $config['displayErrorDetails'] = true;
    $config['addContentLengthHeader'] = false;

    $app = new \Slim\App(["settings" => $config]);

    //Agrupo las funciones comunes:
    $app->group('', function()
    {
        //cargar pizzas
        $this->post('/pizzas', \PizzeriaAPI::class . ':cargarPizza');

        //consultar pizzas
        $this->get('/pizzas/{tipo}/{sabor}', \PizzeriaAPI::class . ':consultarPizza');

        //ventas
        $this->post('/ventas', \PizzeriaAPI::class . ':cargarVentas');


    });

    //siempre!!:
    $app->run();


?>