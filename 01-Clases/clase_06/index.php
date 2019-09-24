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
        $this->get('/{consulta}', \VehiculoApi::class . ':consultarVehiculo');

        $this->post('/servicio', \VehiculoApi::class . ':cargarTipoServicio');
        
        // //Modificar alumno sin foto:        
        // $this->put('/alumnos/{nombre}/{apellido}/{legajo}', \AlumnoApi::class . ':ModificarUno');

        // //Borrar alumno:
        // $this->delete('/{legajo}', \AlumnoApi::class . ':BorrarUno');

    });

    //siempre!!:
    $app->run();


?>