<?php
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    require 'vendor/autoload.php';

    $config['displayErrorDetails'] = true;
    $config['addContentLengthHeader'] = false;

    $app = new \Slim\App(["settings" => $config]);

    $app->group('', function()
    {
        //cargar vehiculo
        $this->post('/vehiculo', \VehiculoApi::class . ':cargarVehiculo');

    });

    $app->run();


?>