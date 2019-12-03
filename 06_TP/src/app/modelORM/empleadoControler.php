<?php
namespace App\Models\ORM;

use Slim\App;
use App\Models\ORM\empleado;
use App\Models\ORM\pedidos;
use App\Models\ORM\operaciones_registro;


include_once __DIR__ . '/empleado.php';
include_once __DIR__ . '/pedido.php';
include_once __DIR__ . '/operaciones_registro.php';


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\AutentificadorJWT;
use \Exception;


class empleadoControler
{

    private static $claveSecreta = 'claveSecreta1';

    public function CargarEmpleado($request, $response, $args) {

        $token = $request->getHeader('token');
        $token = $token[0];
        $datosToken = AutentificadorJWT::ObtenerData($token);     
        $idEmpleadoToken = $datosToken->id;
        $empleadoToken = empleado::where('id', $idEmpleadoToken)->first();
         
        $datos = $request->getParsedBody();
        
        if(isset($datos['nombre'], $datos['apellido'], $datos['tipo'],$datos['clave']))
        {
                    
            //tipos
            if(empleadoControler::ValidarTipo($datos['tipo']))
            {   $empleado = new empleado();
                $empleado->nombre = $datos['nombre'];            
                $empleado->apellido = $datos['apellido'];   
                $empleado->clave = crypt($datos["clave"], self::$claveSecreta);
                $empleado->tipo = $datos['tipo'];

                
                $empleado->save();

                empleadoControler::RegistrarOperacion($empleadoToken, 'Cargar Empleado');
                
                $newResponse = $response->withJson("Empleado cargado", 200);  
            }
            else
            {
                $newResponse = $response->withJson("Tipo inválido", 200);  
            }
           
        }
        else
        {
            $newResponse = $response->withJson("Falta dato", 200);  
        }
             
        return $newResponse;
    }

    public function SuspenderEmpleado($request, $response, $args)
    {

        $token = $request->getHeader('token');
        $token = $token[0];
        $datosToken = AutentificadorJWT::ObtenerData($token);     
        $idEmpleadoToken = $datosToken->id;
        $empleadoToken = empleado::where('id', $idEmpleadoToken)->first();

        $idEmpleado = $request->getAttribute('idEmpleado');

        $empleado = empleado::where('id', $idEmpleado)->first();

        if($empleado != null)
        {
            if(strcasecmp($empleado->estado, 'activo') == 0)
            {
                $empleado->estado = 'suspendido';

                $empleado->save();

                $estado = $empleado->estado;

                empleadoControler::RegistrarOperacion($empleadoToken, 'Suspender Empleado');

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
            $newResponse = $response->withJson("No se encontro al empleado $idEmpleado", 200); 
        }


        return $newResponse;
    }


    public function BorrarEmpleado($request, $response, $args)
    {

        $token = $request->getHeader('token');
        $token = $token[0];
        $datosToken = AutentificadorJWT::ObtenerData($token);     
        $idEmpleadoToken = $datosToken->id;
        $empleadoToken = empleado::where('id', $idEmpleadoToken)->first();
        
        $idEmpleado = $request->getAttribute('idEmpleado');

        $empleado = empleado::where('id', $idEmpleado)->first();

        if($empleado != null)
        {
            $empleado->delete();

            empleadoControler::RegistrarOperacion($empleadoToken, 'Borrar Empleado');

            $newResponse = $response->withJson("Empleado $idEmpleado eliminado", 200); 
        }
        else
        {
            $newResponse = $response->withJson("No se encontro al empleado $idEmpleado", 200); 
        }


        return $newResponse;
    }

    public function ModificarEmpleado($request, $response, $args)
    {
        
        $token = $request->getHeader('token');
        $idEmpleado = $request->getAttribute('idEmpleado');
    
        $token = $token[0];
        $datosToken = AutentificadorJWT::ObtenerData($token);     
        $idEmpleadoToken = $datosToken->id;

        $empleado = empleado::where('id', $idEmpleadoToken)->first();

        $datos = $request->getParsedBody();

        //busco el empleado a modificar:
        $auxEmpleado = empleado::where('id', $idEmpleado)->first();

        if($auxEmpleado != null)
        {
            if(isset($datos["nombre"]))
            {
                $auxEmpleado->nombre = $datos["nombre"];    
            }

            if(isset($datos["apellido"]))
            {    
                $auxEmpleado->apellido = $datos["apellido"];           
            }

            if(isset($datos["clave"]))
            {    
                $auxEmpleado->clave = crypt($datos["clave"], self::$claveSecreta);         
            }

            if(isset($datos["tipo"]))
            {    
                $auxEmpleado->tipo = $datos["tipo"];           
            }
          
            $auxEmpleado->save();

            empleadoControler::RegistrarOperacion($empleado, 'Modificar Empleado');


            $newResponse = $response->withJson("Empleado modificado", 200);
        }
        else
        {
            $newResponse = $response->withJson("No se encontró al empleado $idEmpleado", 200);
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

                    //Guardo la operacion
                    empleadoControler::RegistrarOperacion($empleado, 'Login');

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

    public function ConsultarOperaciones($request, $response, $args)
    {
        $listado = $request->getParam('listado');
        $idEmpleado = $request->getParam('idEmpleado');

        

        switch($listado)
        {
            case "logins":
                $informacion = operaciones_registro::where('operacion', 'Login')
                    ->get(['id', 'operacion', 'id_empleado', 'hora']);
            break;
            case "operaciones_por_sector":
                $informacion = operaciones_registro::join('empleados', 'operaciones_registros.id_empleado', '=', 'empleados.id')
                    ->orderBy('empleados.tipo', 'asc')
                    ->get(['operaciones_registros.id', 'operacion', 'id_empleado', 'empleados.tipo', 'hora']);
            break;
            case "operaciones_por_sector_por_empleado":
                $informacion = operaciones_registro::join('empleados', 'operaciones_registros.id_empleado', '=', 'empleados.id')
                    ->orderBy('empleados.tipo', 'asc')
                    ->orderBy('empleados.id', 'asc')
                    ->get(['operaciones_registros.id', 'operacion', 'id_empleado', 'empleados.tipo', 'hora']);
            break;
            case "operaciones_del_empleado":
                if($idEmpleado != null)
                {
                    $informacion = operaciones_registro::where('id_empleado', $idEmpleado)
                    ->join('empleados', 'operaciones_registros.id_empleado', '=', 'empleados.id')
                    ->orderBy('empleados.tipo', 'asc')
                    ->orderBy('empleados.id', 'asc')
                    ->get(['operaciones_registros.id', 'operacion', 'id_empleado', 'empleados.tipo', 'hora']);
                }
                else
                {
                    $informacion = "Falta id empleado";            
                }
            break;
            default:
            $informacion = operaciones_registro::get();
                
        }

        $newResponse = $response->withJson($informacion, 200);

        return $newResponse;
    }

    public static function RegistrarOperacion($empleado, $operacion)
    {
        $hora = new \DateTime();
        $hora = $hora->setTimezone(new \DateTimeZone('America/Argentina/Buenos_Aires'));

        $registroOperacion = new operaciones_registro();
        $registroOperacion->hora = $hora;
        $registroOperacion->id_empleado = $empleado->id;
        $registroOperacion->operacion = $operacion;

        
        $registroOperacion->save();
    }

    public static function ValidarTipo($tipo)
    {
        $esValido = false;

        if(strcasecmp($tipo,'bartender') == 0 ||
                strcasecmp($tipo,'cervecero') == 0 ||
                strcasecmp($tipo,'cocinero') == 0 ||
                strcasecmp($tipo,'mozo') == 0 ||
                strcasecmp($tipo,'admin') == 0 ||
                strcasecmp($tipo,'socio') == 0)
        {   
            $esValido = true;
        }


        return $esValido;
    }


  
}