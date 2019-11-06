<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\cd;
use App\Models\cdApi;

require_once "../entidades/alumno.php";
require_once "../entidades/archivo.php";

return function (App $app) {
    $container = $app->getContainer();

    // Rutas PDO
    $routes = require __DIR__ . '/../src/routes/routesPDO.php';
    $routes($app);
    

    // Rutas ORM
    $routes = require __DIR__ . '/../src/routes/routesORM.php';
    $routes($app);

    // Rutas JWT
    $routes = require __DIR__ . '/../src/routes/routesJWT.php';
    $routes($app);

    //Alumnos:
    $app->group('/alumno', function()
    {
        //cargar alumno
        $this->post('', function (Request $request, Response $response){

            $ruta = "../alumno.txt";
            
            $datos = $request->getParsedBody();

            $nombre = $datos["nombre"];
            $apellido = $datos["apellido"];
            $legajo = $datos["legajo"];
                        
            $alumno = new Alumno($nombre, $apellido, $legajo);

            Archivo::GuardarUno($ruta, $alumno);

            $newResponse = $response->withJson($alumno, 200);
                        
            return $newResponse;
        });

        $this->get("", function (Request $request, Response $response, $args){

            $ruta = "../alumno.txt";

            $datos = array();

            $legajo = $request->getParam("legajo");
            
            $listaAlumnos = Archivo::LeerArchivo($ruta);

            $existeDato = false;
        
            foreach($listaAlumnos as $auxAlumno)
            {
                if(strcasecmp($auxAlumno->legajo, $legajo) == 0)       
                {               
                    $existeDato = true;
                    array_push($datos, $auxAlumno);
                }
            }

            if($existeDato == false)
            {
                $datos = "No existe $legajo";
            }

            $newResponse = $response->withJson($datos, 200);
            
            return $newResponse;

        });

        //Modificar
        // $this->post("", function (Request $request, Response $response){
        
        //     $ruta = "./alumno.txt";
        //     $listaAlumnos = Archivo::LeerArchivo();

        //     for($i= 0 ; $i < count($listaAlumnos); $i++)
        //     {
        //         $alumnoAux = $listaAlumnos[$i];
        //         //Modifico
        //         if($alumnoAux->legajo == $elementoModificado->legajo)
        //         {
                    
        //             $listaAlumnos[$i] = $elementoModificado;

        //             Archivo::GuardarTodos($ruta, $listaAlumnos);
        //             break;
        //         }
        //     }

        //     $newResponse = $respon

        // });
    
        
    });


    $app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");
        // $container->get('logger')->addCritical('Hey, a critical log entry!');
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });




};
