<?php
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    require 'vendor/autoload.php';
    require_once "./clases/archivo.php";
    require_once "./clases/alumnoApi.php";

    $config['displayErrorDetails'] = true;
    $config['addContentLengthHeader'] = false;

    $app = new \Slim\App(["settings" => $config]);

    //Agrupo las funciones comunes:
    $app->group('/alumnos', function()
    {
        //Agregar alumno o modificar (segun opcion):
        $this->post('/{nombre}/{apellido}/{legajo}/{opcion}', \AlumnoApi::class . ':GuardarUno');


        //Mostrar alumno:
        $this->get('/', \AlumnoApi::class . ':MostrarTodos');

        
        //Modificar alumno sin foto:        
        $this->put('/alumnos/{nombre}/{apellido}/{legajo}', \AlumnoApi::class . ':ModificarUno');

        //Borrar alumno:
        $this->delete('/{legajo}', \AlumnoApi::class . ':BorrarUno');

    });

    //siempre!!:
    $app->run();


?>