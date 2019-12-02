<?php
namespace App\Models\ORM;

use Slim\App;
use App\Models\ORM\pedido;


include_once __DIR__ . '/pedido.php';


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\AutentificadorJWT;
use \Exception;


class pedidoControler
{

    public function CargarPedido($request, $response, $args)
    {
        $datos = $request->getParsedBody();
        $token = $request->getHeader('token');
        
        $token = $token[0];
        $datosToken = AutentificadorJWT::ObtenerData($token);  
        $idEmpleado = $datosToken->id;

        $empleado = empleado::where('id', $idEmpleado)->first();
        
        if(isset($datos['nombre'], $datos['idComida'], $datos['idMesa']))
        {
            $mesa = mesa::where('id', $datos['idMesa']);

            if($idMesa != null)
            {
                
                $horaCreacion = new \DateTime();//timestamp creacion del pedido
                $horaCreacion = $horaCreacion->setTimezone(new \DateTimeZone('America/Argentina/Buenos_Aires'));
                
                if(isset($datos['idMesa']))//Si una mesa quiere pedir algo más
                {
                    $codigoMesa = $datos['codigoMesa'];
                }
                else
                {
                    //creo id random para la mesa:
                    $codigoMesa = substr(md5(uniqid(rand(), true)), 0, 5);

                    //guardo el código de la mesa:
                    $mesa->codigo_unico = $codigoMesa;
                    $mesa->estado = 'Con cliente esperando pedido';
                    $mesa->save(); 
                }

                //codigo único del pedido:
                $codigoUnico = substr(md5(uniqid(rand(), true)), 0, 5);

            
                if(is_array($datos['idComida']))//si pide más de 1 cosa
                {
                    $length = count($datos['idComida']);

                    for($i = 0; $i < $length; $i++)
                    {
                        $pedido = new pedido();
                        $pedido->codigo_mesa =  $codigoMesa; //asigno el id
                        $pedido->codigo_unico = $codigoUnico;
                        $pedido->id_comida = $datos['idComida'][$i];
                        
                        $pedido->hora_creacion = $horaCreacion;
                    
                        $pedido->save();
                    }
                }
                else
                {
                    $pedido = new pedido();
                    $pedido->codigo_mesa =  $codigoMesa; //asigno el id
                    $pedido->codigo_unico = $codigoUnico;
                    $pedido->id_comida = $datos['idComida'];                 
                    
                    $pedido->hora_creacion = $horaCreacion;
                    $pedido->save();
                }

                empleadoControler::RegistrarOperacion($empleado, 'Cargar Pedido');

                $newResponse = $response->withJson("Pedido en preparacion. Id Mesa: $codigoMesa, Id Pedido: $codigoUnico", 200);//devuelvo el id de la mesa
        
            }
            else
            {
                $newResponse = $response->withJson("No existe la mesa $idMesa", 200);  
            }
      
        }
        else
        {      
            $newResponse = $response->withJson("Falta dato", 200);            
        }

        return $newResponse;
    }

    public function VerPedidos($request, $response, $args)
    {
        $token = $request->getHeader('token');
        $token = $token[0];
        $datosToken = AutentificadorJWT::ObtenerData($token); 
        
        $idEmpleado = $datosToken->id;
        $empleado = empleado::where('id', $idEmpleado)->first();
    
        switch($empleado->tipo)
        {
            case 'bartender':
            $pedidos = pedido::where([
                        ['tipo', 'bebida'],
                        ['estado', 'pendiente']])
                        ->select('nombre', 'estado')
                        ->get();
            break;

            case 'cervecero':
            $pedidos = pedido::where([
                ['tipo', 'cerveza'],
                ['estado', 'pendiente']])
                ->select('nombre', 'estado')
                ->get();
            break;

            case 'cocinero':
            $pedidos = pedido::where([
                ['tipo', 'comida'],
                ['estado', 'pendiente']])
                ->select('nombre', 'estado')
                ->get();
            break;

            case 'socio':
            $pedidos = pedido::all('nombre','tipo', 'estado',
                    'id_mesa', 'hora_creacion', 'tiempo_preparacion',
                    'hora_entrega');
            break;
        }

        empleadoControler::RegistrarOperacion($empleado, 'Ver Pedido');

        $newResponse = $response->withJson($pedidos, 200);
    
        return $newResponse;
    }

    public function PrepararPedido($request, $response, $args)
    {
        $token = $request->getHeader('token');
        $idPedido = $request->getAttribute('idPedido');
        $datos = $request->getParsedBody();

        $token = $token[0];
        $datosToken = AutentificadorJWT::ObtenerData($token);
        
        $idEmpleado = $datosToken->id;
        $empleado = empleado::where('id', $idEmpleado)->first();

        if($idPedido != null)
        {
            if(isset($datos['tiempoEstimado']))
            {

                $tiempoEstimado = $datos['tiempoEstimado'];

                $pedido = pedido::where('id', $idPedido)->first();
                if($pedido != null)
                {
                    $pedido->tiempo_preparacion = $tiempoEstimado;
                    $pedido->estado = 'En preparación';
                    $pedido->save();
        
                    empleadoControler::RegistrarOperacion($empleado, 'Preparar pedido');
        
                    $newResponse = $response->withJson("Pedido $idPedido en preparación", 200);   
                }
                else
                {
                    $newResponse = $response->withJson("No encontró el pedido $idPedido", 200);       
                }              
            }
            else
            {
                $newResponse = $response->withJson("No se estableció el tiempo estimado", 200);   
            }
        }
        else
        {
            $newResponse = $response->withJson("Falta id del pedido", 200); 
        }

        return $newResponse;
    }

    public function TerminarPedido($request, $response, $args)
    {

        $token = $request->getHeader('token');
        $idPedido = $request->getAttribute('idPedido');

        $token = $token[0];
        $datosToken = AutentificadorJWT::ObtenerData($token);     
        $idEmpleado = $datosToken->id;

        $empleado = empleado::where('id', $idEmpleado)->first();
        $pedido = pedido::where('id', $idPedido)->first();

        if($pedido != null && strcasecmp($pedido->estado, 'En preparación') == 0)
        {
            $pedido->estado = "Listo para servir";

            $pedido->save();

            empleadoControler::RegistrarOperacion($empleado, 'Terminar Pedido');
            
            $newResponse = $response->withJson("Pedido $idPedido listo para servir", 200);
        }
        else
        {
            $newResponse = $response->withJson('No se encontró el pedido', 200);
        }

        return $newResponse;
    }

    public function ServirPedido($request, $response, $args)
    {

        $token = $request->getHeader('token');
        $idPedido = $request->getAttribute('idPedido');

        $token = $token[0];
        $datosToken = AutentificadorJWT::ObtenerData($token);     
        $idEmpleado = $datosToken->id;

        $empleado = empleado::where('id', $idEmpleado)->first();
        $pedido = pedido::where('id', $idPedido)->first();

        if($pedido != null && strcasecmp($pedido->estado, 'Listo para servir') == 0)
        {
            $horaEntrega = new \DateTime();//timestamp creacion del pedido
            $horaEntrega = $horaEntrega->setTimezone(new \DateTimeZone('America/Argentina/Buenos_Aires'));

            
            $pedido->hora_entrega = $horaEntrega;
            $pedido->estado = "Entregado";
            $pedido->save();

            $codigoUnico = $pedido->codigo_mesa;

            $mesa = mesa::where('codigo_unico', $codigoUnico)->first();
            $mesa->estado = 'Con clientes comiendo';
            $mesa->save();

            empleadoControler::RegistrarOperacion($empleado, 'Servir Pedido');
            
            $newResponse = $response->withJson("Pedido $idPedido entregado", 200);
        }
        else
        {
            $newResponse = $response->withJson("No se encontró el pedido $idPedido", 200);
        }

        return $newResponse;
    }

    public function MostrarTiempoRestante($request, $response, $args)
    {
        $codigoMesa = $request->getParam('codigoMesa');
        $codigoPedido = $request->getParam('codigoPedido');

        if(isset($codigoMesa, $codigoPedido))
        {
            
            $pedido = pedido::where([['codigo_mesa', $codigoMesa], 
                                     ['codigo_unico', $codigoPedido]])->first();

            if($pedido != null)
            {
                $tiempoPreparacion = $pedido->tiempo_preparacion;

                $horaEntrega = \DateTime::createFromFormat('Y-m-d H:i:s', $pedido->hora_pedido);//timestamp creacion del pedido  
                $horaEntrega->modify("+$tiempoPreparacion minutes");//agrego los minutos
                $horaEntrega;

                $horaActual = new \DateTime();//timestamp creacion del pedido
                $horaActual = $horaActual->setTimezone(new \DateTimeZone('America/Argentina/Buenos_Aires'));
    
                $tiempoRestante = $horaEntrega->diff($horaActual);
                $tiempoRestante->format("%i minutos");

                $newResponse = $response->withJson("Faltan $tiempoRestante para su pedido", 200);
                    
            }
            else
            {
                $newResponse = $response->withJson("No se encontró el pedido", 200);
            }

        }
        else
        {
            $newResponse = $response->withJson("Faltan datos", 200);
        }

        return $newResponse;
        
    }

    public function CobrarPedido($request, $response, $args)
    {
        $token = $request->getHeader('token');
        $codigoPedido = $request->getAttribute('codigoPedido');

        $token = $token[0];
        $datosToken = AutentificadorJWT::ObtenerData($token);     
        $idEmpleado = $datosToken->id;

        $empleado = empleado::where('id', $idEmpleado)->first();
        
        //Busco las comidas y el precio:
        $pedido = $datos = alumno_materia::where('codigo_unico', $codigoPedido)
                ->join('comidas', 'pedidos.id_comida', '=', 'comidas.id')
                ->select('comidas.nombre', 'comidas.precio')
                ->get();
        //Saco el total:
        $montoTotal = 0;

        foreach($pedidos as $pedido)
        {
            $montoTotal += $pedido->monto;
        }

        //Modifico el estado de la mesa:        
        $codigoUnico = $pedido->codigo_mesa;
        $mesa = mesa::where('codigo_unico', $codigoUnico)->first();
        $mesa->estado = 'Con clientes pagando';
        $mesa->save();

        //facturación:
        $factura = new factura();
        $factura->id_mesa = $mesa->id;
        $factura->codigo_pedido = $codigoPedido;
        $factura->monto = $montoTotal;
        $factura->save();

        empleadoControler::RegistrarOperacion($empleado, 'Cobrar Pedido');

        $newResponse = $response->withJson("Total a pagar: $montoTotal",200);

        return $newResponse;

    }



    
  
}