<?php
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    require 'vendor/autoload.php';
    require_once "./entidades/archivo.php";
    require_once "./entidades/vehiculoApi.php";

    $config['displayErrorDetails'] = true;
    $config['addContentLengthHeader'] = false;

    $app = new \Slim\App(["settings" => $config]);

    //Agrupo las funciones comunes:
    $app->group('', function()
    {
        //cargar vehiculo
        $this->post('/vehiculo', \VehiculoApi::class . ':cargarVehiculo');

        //consultar vehiculo
        $this->get('/vehiculo/{consulta}', \VehiculoApi::class . ':consultarVehiculo');

        //guardar servicio
        $this->post('/servicio', \VehiculoApi::class . ':cargarTipoServicio');

        //sacar turno
        $this->get('/turnos/{patente}/{fecha}', \VehiculoApi::class . ':sacarTurno');
        
        //Mostrar turnos
        $this->get('/turnos', \VehiculoApi::class . ':mostrarTurnos');

        //inscripciones
        $this->get('/inscripciones/{filtro}', \VehiculoApi::class . ':filtrarTurnos');

        //cargar vehiculo
        $this->post('/vehiculo/modificar', \VehiculoApi::class . ':modificarVehiculo');

        //Mostrar turnos
        $this->get('/vehiculos', \VehiculoApi::class . ':mostrarVehiculos');

    });

    //siempre!!:
    $app->run();


?>