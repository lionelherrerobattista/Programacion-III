<?php
namespace App\Models\ORM;

use Slim\App;
use App\Models\ORM\empleado;


include_once __DIR__ . '/empleado.php';


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\AutentificadorJWT;
use \Exception;


class empleadoControler
{
    public function CargarEmpleado($request, $response, $args) {
         
        $datos = $request->getParsedBody();
        
        if(isset($datos['nombre'], $datos['tipo']))
        {
            $empleado = new empleado();
            $empleado->nombre = $datos['nombre'];            
            $empleado->apellido = $datos['apellido'];   
                
            //tipos
            if(strcasecmp($datos['tipo'],'bartender') == 0 ||
                strcasecmp($datos['tipo'],'cervecero') == 0 ||
                strcasecmp($datos['tipo'],'cocinero') == 0 ||
                strcasecmp($datos['tipo'],'mozo') == 0 ||
                strcasecmp($datos['tipo'],'socio') == 0)
            {   
                $empleado->tipo = $datos['tipo'];
            }
           
            $empleado->save();
            
            $newResponse = $response->withJson("Empleado cargado", 200);  
        }
        else
        {
            $newResponse = $response->withJson("Falta dato", 200);  
        }
             
        return $newResponse;
    }

    public function SuspenderEmpleado($request, $response, $args)
    {
        $id = $request->getAttribute('id');

        $empleado = empleado::where('id', $id)->first();

        if($empleado != null)
        {
            if(strcasecmp($empleado->estado, 'activo') == 0)
            {
                $empleado->estado = 'suspendido';

                $empleado->save();

                $estado = $empleado->estado;

                $newResponse = $response->withJson("Se cambió el estado a $estado", 200); 
            }
            else
            {
                $empleado->estado = 'activo';

                $empleado->save();

                $estado = $empleado->estado;

                $newResponse = $response->withJson("Se cambió el estado a $estado", 200); 

            }
            
        }
        else
        {
            $newResponse = $response->withJson("No se encontro al empleado $id", 200); 
        }


        return $newResponse;
    }


    public function BorrarEmpleado($request, $response, $args)
    {
        
        $id = $request->getAttribute('id');

        $empleado = empleado::where('id', $id)->first();

        if($empleado != null)
        {
            $empleado->delete();

            $newResponse = $response->withJson("Empleado $id eliminado", 200); 
        }
        else
        {
            $newResponse = $response->withJson("No se encontro al empleado $id", 200); 
        }


        return $newResponse;
    }


  
}