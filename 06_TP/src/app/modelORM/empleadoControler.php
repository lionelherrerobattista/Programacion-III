<?php
namespace App\Models\ORM;

use Slim\App;
use App\Models\ORM\empleado;
use App\Models\ORM\pedidos;
use App\Models\ORM\registro_login;


include_once __DIR__ . '/empleado.php';
include_once __DIR__ . '/pedido.php';
include_once __DIR__ . '/registro_login.php';


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\AutentificadorJWT;
use \Exception;


class empleadoControler
{

    private static $claveSecreta = 'claveSecreta1';

    public function CargarEmpleado($request, $response, $args) {
         
        $datos = $request->getParsedBody();
        
        if(isset($datos['nombre'], $datos['apellido'], $datos['tipo'],$datos['clave']))
        {
            $empleado = new empleado();
            $empleado->nombre = $datos['nombre'];            
            $empleado->apellido = $datos['apellido'];   
            $empleado->clave = crypt($datos["clave"], self::$claveSecreta);
                
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

    
    public function loginEmpleado($request, $response, $args)
    {
        $datos = $request->getParsedBody();

        if(isset($datos['id'], $datos['clave']))
        {
            $id = $datos['id'];
            $clave = $datos['clave'];
            
            $empleado = empleado::where('id', $id)->first();

            if($empleado != null)
            {
                if(hash_equals($empleado->clave, crypt($clave, self::$claveSecreta)))
                {
                    $datosToken = array(

                        'id' => $empleado->id,
                        'nombre' => $empleado->nombre,
                        'apellido' => $empleado->apellido,
                        'tipo' => $empleado->tipo
                    );

                    $token = AutentificadorJWT::CrearToken($datosToken);

                    $registroLogin = new registro_login();

                    //Guardo los datos del login
                    $horaLogin = new \DateTime();
                    $horaLogin = $horaLogin->setTimezone(new \DateTimeZone('America/Argentina/Buenos_Aires'));

                    $registroLogin->hora_login = $horaLogin;
                    $registroLogin->id_empleado = $empleado->id;
                    
                    $registroLogin->save();

                    $newResponse = $response->withJson($token, 200);  
                }
                else
                {
                    $newResponse = $response->withJson("Clave incorrecta", 200);  
                }
            
            }
            else
            {
                $newResponse = $response->withJson("No se encontró al empleado $id", 200);
            }
        }
        else
        {
            $newResponse = $response->withJson("Faltan datos", 200);
        }
        
        return $newResponse;
    }


  
}