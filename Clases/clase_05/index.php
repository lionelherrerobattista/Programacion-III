<?php
    use Psr\Http\Message\RequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    require 'vendor/autoload.php';
    require_once "./clases/archivo.php";
    require_once "./clases/alumno.php";

    $config['displayErrorDetails'] = true;
    $config['addContentLengthHeader'] = false;

    $ruta = "./objetos.json";

    $app = new \Slim\App();

    //Agregar alumno:
    $app->post('/{nombre}/{apellido}/{legajo}', function (Request $req,  Response $res, $args = []) {

        $ruta = "./objetos.json";

        $alumno = new Alumno($args["nombre"], $args["apellido"], $args["legajo"]);

        $datos = Alumno::MostrarAlumno($alumno);

        Archivo::GuardarPersona($ruta, $alumno);

        return $res->getBody()->write($datos);
    });


    //Eliminar alumno:
    $app->get('/', function (Request $req,  Response $res, $args = []) {

        $ruta = "./objetos.json";
        
        $datos = Archivo::MostrarPersonas($ruta);
        
        return $res->getBody()->write($datos);

    });

    //Modificar alumno:
    $app->put('/{nombre}/{apellido}/{legajo}', function (Request $req,  Response $res, $args = []) {

        $ruta = "./objetos.json";

        $alumnoModificado = new Alumno($args["nombre"], $args["apellido"], $args["legajo"]);

        Archivo::ModificarAlumno($ruta, $alumnoModificado);

        return $res->getBody()->write(Alumno::MostrarAlumno($alumnoModificado));

    });

    $app->run();


?>