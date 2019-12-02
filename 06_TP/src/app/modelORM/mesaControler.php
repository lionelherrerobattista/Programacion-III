<?php
namespace App\Models\ORM;

use Slim\App;
use App\Models\ORM\mesa;


include_once __DIR__ . '/mesa.php';


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\AutentificadorJWT;
use \Exception;


class mesaControler
{

    public function CargarMesa($request, $response, $args)
    {
        
        $token = $request->getHeader('token');
        $idPedido = $request->getAttribute('idPedido');

        $token = $token[0];
        $datosToken = AutentificadorJWT::ObtenerData($token);     
        $idEmpleado = $datosToken->id;

        $empleado = empleado::where('id', $idEmpleado)->first();

        $mesa = new mesa();

        $mesa->estado = 'Cerrada';

        $mesa->save();

        empleadoControler::RegistrarOperacion($empleado, 'Cargar Mesa');

        $newResponse = $response->withJson("Mesa cargada", 200); 

        return $newResponse;

    }


    public function BorrarMesa($request, $response, $args)
    {
        
        $token = $request->getHeader('token');
        $idMesa = $request->getAttribute('idMesa');

        $token = $token[0];
        $datosToken = AutentificadorJWT::ObtenerData($token);     
        $idEmpleado = $datosToken->id;

        $empleado = empleado::where('id', $idEmpleado)->first();

        $mesa = mesa::where('id', $idMesa)->first();

        if($mesa != null)
        {
            $mesa->delete();

            empleadoControler::RegistrarOperacion($empleado, 'Borrar Mesa');

            $newResponse = $response->withJson("Mesa $idMesa eliminada", 200); 
        }
        else
        {
            $newResponse = $response->withJson("No se encontro la mesa $idMesa", 200); 
        }

        return $newResponse;
    }

    
    public function ModificarMesa($request, $response, $args)
    {
        
        $token = $request->getHeader('token');
        $idMesa = $request->getAttribute('idMesa');
    
        $token = $token[0];
        $datosToken = AutentificadorJWT::ObtenerData($token);     
        $idEmpleado = $datosToken->id;

        $empleado = empleado::where('id', $idEmpleado)->first();

        $datos = $request->getParsedBody();

        //busco la mesa:
        $mesa = mesa::where('id', $idMesa)->first();

        if($mesa != null)
        {
            if(isset($datos["estado"]))
            {
                $mesa->estado = $datos["estado"];    
            }

            if(isset($datos["codigoUnico"]))
            {    
                $mesa->codig_unico = $datos["codigoUnico"];           
            }
          
            $mesa->save();

            empleadoControler::RegistrarOperacion($empleado, 'Modificar Mesa');


            $newResponse = $response->withJson("Mesa modificada", 200);
        }
        else
        {
            $newResponse = $response->withJson("No se encontró la mesa $idMesa", 200);
        }         

        return $newResponse;
    }


    public function CerrarMesa($request, $response, $args)
    {
        
        $token = $request->getHeader('token');
        $idPedido = $request->getAttribute('idPedido');

        $token = $token[0];
        $datosToken = AutentificadorJWT::ObtenerData($token);     
        $idEmpleado = $datosToken->id;

        $empleado = empleado::where('id', $idEmpleado)->first();
        
        $id = $request->getAttribute('id');

        $mesa = mesa::where('id', $id)->first();

        if($mesa != null)
        {
            $mesa->estado = 'Cerrada';

            empleadoControler::RegistrarOperacion($empleado, 'Cerrar Mesa');

            $newResponse = $response->withJson("Mesa $id cerrada", 200); 
        }
        else
        {
            $newResponse = $response->withJson("No se encontro al mesa $id", 200); 
        }


        return $newResponse;
    }


  
}