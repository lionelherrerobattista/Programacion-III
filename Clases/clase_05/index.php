<?php
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    require 'vendor/autoload.php';
    require_once "./clases/archivo.php";
    require_once "./clases/alumno.php";

    $config['displayErrorDetails'] = true;
    $config['addContentLengthHeader'] = false;

    $ruta = "./objetos.json";

    $app = new \Slim\App(["settings" => $config]);

    //Agregar alumno o modificar (segun opcion):
    $app->post('/alumnos/{nombre}/{apellido}/{legajo}/{opcion}', function (Request $req,  Response $res, $args = []) {

        $ruta = "./objetos.json";
        $destino = "./imagenes/";
        $mensaje = "Error";

        //le paso el archivo
        $archivo = $req->getUploadedFiles();

        $rutaFoto = Archivo::GuardarArchivoTemporal($archivo, $destino);

        $alumno = new Alumno($args["nombre"], $args["apellido"], $args["legajo"], $rutaFoto);

        switch($args["opcion"])
        {
            case "agregar":
            Archivo::GuardarPersona($ruta, $alumno);
            $mensaje = "Alumno guardado";
            break;

            case "modificar":
            Archivo::ModificarAlumno($ruta, $alumno);
            $mensaje = "Alumno modificado";
            break;

            default:
            $mensaje = "Error";
            break;
        }

        return $res->getBody()->write($mensaje);
    });


    //Mostrar alumno:
    $app->get('/alumnos', function (Request $req,  Response $res, $args = []) {

        $ruta = "./objetos.json";
        
        $datos = Archivo::MostrarPersonas($ruta);
        
        return $res->getBody()->write($datos);

    });

    //Modificar alumno sin foto:
    // $app->put('/alumnos/{nombre}/{apellido}/{legajo}', function (Request $req,  Response $res, $args = []) {

    //     $ruta = "./objetos.json";
    //     $destino = "./imagenes/";

    //     //le paso el archivo
    //     $archivo = $req->getUploadedFiles();

    //     $rutaFoto = Archivo::GuardarArchivoTemporal($archivo, $destino);

    //     $alumnoModificado = new Alumno($args["nombre"], $args["apellido"], $args["legajo"], $rutaFoto);

    //     Archivo::ModificarAlumno($ruta, $alumnoModificado);

    //     return $res->getBody()->write('Alumno Modificado');

    // });

    //Borrar alumno:
    $app->delete('/alumnos/{legajo}', function (Request $req,  Response $res, $args = []) {

        $ruta = "./objetos.json";

        Archivo::BorrarPersona($ruta, $args["legajo"]);

        return $res->getBody()->write('Alumno Borrado');

    });

    $app->run();


?>