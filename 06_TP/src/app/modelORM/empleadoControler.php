<?php
namespace App\Models\ORM;

use Slim\App;
use App\Models\ORM\empleado;
use App\Models\ORM\pedidos;


include_once __DIR__ . '/empleado.php';
include_once __DIR__ . '/pedidos.php';


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

    public function VerPedidos($request, $response, $args)
    {
        $id = $request->getAttribute('id');

        $empleado = empleado::where('id', $id)->first();
        
        if($empleado != null)
        {
            switch($empleado->tipo)
            {
                case 'bartender':
                $pedidos = pedido::where([
                            ['tipo', 'bebida'],
                            ['estado', 'pendiente']])
                            ->select('pedidos.nombre', 'pedidos.estado')
                            ->get();
                break;

                case 'cervecero':
                $pedidos = pedido::where([
                    ['tipo', 'cerveza'],
                    ['estado', 'pendiente']])
                    ->select('pedidos.nombre', 'pedidos.estado')
                    ->get();
                break;

                case 'cocinero':
                $pedidos = pedido::where([
                    ['tipo', 'comida'],
                    ['estado', 'pendiente']])
                    ->select('pedidos.nombre', 'pedidos.estado')
                    ->get();
                break;

                case 'socio':
                $pedidos = pedido::all();
                break;



            }

            $newResponse = $response->withJson($pedidos, 200);
        }
        else
        {
            $newResponse = $response->withJson("No se encontro al empleado $id", 200); 
        }

        return $newResponse;
    }

    public function PrepararPedido($request, $response, $args)
    {
        $datos = $request->getParsedBody();

        $id = $request->getAttribute('id');
    
        $empleado = empleado::where('id', $id)->first();
        
        if($empleado != null)
        {
            if(isset($datos['tiempoEstimado']))
            {

                $tiempoEstimado = $datos['tiempoEstimado'];

                switch($empleado->tipo)
                {
                    case 'bartender':
                    $pedido = pedido::where([
                                ['tipo', 'bebida'],
                                ['estado', 'pendiente']])
                                ->first();

                    var_dump($pedido);
                    $pedido->estado = 'En preparación';
                    $pedido->tiempo_preparacion = $tiempoEstimado;
                    // sleep(500);//en segundos
                    $pedido->estado = 'listo para servir';
                    break;
        
                    case 'cervecero':
                    $pedido = pedido::where([
                        ['tipo', 'cerveza'],
                        ['estado', 'pendiente']])
                        ->first();
                    $pedido->estado = 'En preparación';
                    $pedido->tiempo_preparacion = $tiempoEstimado;
                    // sleep(500);//en segundos
                    $pedido->estado = 'listo para servir';
                    break;
        
                    case 'cocinero':
                    $pedido = pedido::where([
                        ['tipo', 'comida'],
                        ['estado', 'pendiente']])
                        ->first();
                    $pedido->estado = 'En preparación';
                    $pedido->tiempo_preparacion = $tiempoEstimado;//minutos
                    // sleep(500);//en segundos
                    $pedido->estado = 'listo para servir';
                    break;
                }

                $horaEntrega = \DateTime::createFromFormat('Y-m-d H:i:s', $pedido->hora_pedido);//timestamp creacion del pedido
                // $horaEntrega = $horaEntrega->setTimezone(new \DateTimeZone('America/Argentina/Buenos_Aires'));
                var_dump($pedido->hora_pedido);
                $minutos = rand(1, $tiempoEstimado+5);
     
                $horaEntrega = $horaEntrega->add((new \DateInterval('PT' . $minutos . 'M')));

                $pedido->hora_entrega = $horaEntrega;
                $pedido->save();

                $newResponse = $response->withJson("Pedido Listo", 200);
            }
            else
            {
                $newResponse = $response->withJson("Faltan datos", 200); 
            }
            
            
            

        }
        else
        {
            $newResponse = $response->withJson("No se encontro al empleado $id", 200); 
        }

        return $newResponse;
    }


  
}