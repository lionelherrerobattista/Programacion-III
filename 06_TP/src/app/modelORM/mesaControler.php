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
                $mesa->codigo_unico = $datos["codigoUnico"];           
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
        
        $idMesa = $request->getAttribute('idMesa');

        $mesa = mesa::where('id', $idMesa)->first();

        if($mesa != null)
        {
            $mesa->estado = 'Cerrada';
            $mesa->codigo_unico = null;
            $mesa->save();

            empleadoControler::RegistrarOperacion($empleado, 'Cerrar Mesa');

            $newResponse = $response->withJson("Mesa $idMesa cerrada", 200); 
        }
        else
        {
            $newResponse = $response->withJson("No se encontro la mesa $idMesa", 200); 
        }

        return $newResponse;
    }


    public function ConsultarMesas($request, $response, $args)
    {
        $listado = $request->getParam('listado');
        $idMesa = $request->getParam('idMesa');
        $fechaInicio = $request->getParam('fechaInicio');
        $fechaFin = $request->getParam('fechaFin');
        $informacion = null;
        
        switch($listado)
        {
            case "mas_usada":
                $informacion = factura::select('id_mesa')
                ->groupBy('id_mesa')
                ->orderByRaw('COUNT(*) DESC')
                ->selectRaw("COUNT(*) as veces_usada")
                ->limit(1)
                ->get();
            break;
            case "menos_usada":
                $informacion = factura::select('id_mesa')
                ->groupBy('id_mesa')
                ->orderByRaw('COUNT(*) ASC')
                ->selectRaw("COUNT(*) as veces_usada")
                ->limit(1)
                ->get();
            break;
            case "mas_facturo":
                $informacion = factura::select('id_mesa')
                ->groupBy('id_mesa')
                ->orderByRaw('SUM(monto) desc')
                ->selectRaw("SUM(monto) as monto_total")
                ->limit(1)
                ->get();
            break;
            case "menos_facturo":
                $informacion = factura::select('id_mesa')
                ->groupBy('id_mesa')
                ->orderByRaw('SUM(monto) asc')
                ->selectRaw("SUM(monto) as monto_total")
                ->limit(1)
                ->get();
            break;
            case "mayor_importe":
                $informacion = factura::orderBy('monto', 'desc')
                ->select('id_mesa', 'monto')
                ->first();
            break;
            case "menor_importe":
                $informacion = factura::orderBy('monto', 'asc')
                ->select('id_mesa', 'monto')
                ->first();
            break; 
            case "entre_dos_fechas":
                if($idMesa != null)
                {
                    $informacion = factura::where('id_mesa', $idMesa)
                    ->where('hora', '>=', $fechaInicio)
                    ->where('hora', '<=', $fechaFin)
                    ->get();
                }
            break;               
            case "mejores_comentarios":
                $informacion = encuesta::select('id_cliente', 'texto_experiencia')
                ->selectRaw("(puntaje_mesa + puntaje_restaurante + puntaje_mozo + puntaje_cocinero) as puntaje_total")
                ->orderByRaw('(puntaje_mesa + puntaje_restaurante + puntaje_mozo + puntaje_cocinero) desc')
                ->limit(3)
                ->get();
            break; 
            case "peores_comentarios":
                $informacion = encuesta::select('id_cliente', 'texto_experiencia')
                ->selectRaw("(puntaje_mesa + puntaje_restaurante + puntaje_mozo + puntaje_cocinero) as puntaje_total")
                ->orderByRaw('(puntaje_mesa + puntaje_restaurante + puntaje_mozo + puntaje_cocinero) asc')
                ->limit(3)
                ->get();
            break; 
        }

        if($informacion == null)
        {
            $informacion = 'No hay pedidos';
        }

        $newResponse = $response->withJson($informacion, 200);

        return $newResponse;
    }


  
}