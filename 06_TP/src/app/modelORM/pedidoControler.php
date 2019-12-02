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
        
        if(isset($datos['nombre'], $datos['tipo'], $datos['idMesa']))
        {
            $mesa = mesa::where('id', $datos['idMesa']);

            if($idMesa != null)
            {
                if(pedidoControler::ValidarTipo($datos['tipo']))
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

                
                    if(is_array($datos['nombre']))//si pide más de 1 cosa
                    {
                        $length = count($datos['nombre']);

                        for($i = 0; $i < $length; $i++)
                        {
                            $pedido = new pedido();
                            $pedido->codigo_mesa =  $codigoMesa; //asigno el id
                            $pedido->codigo_unico = $codigoUnico;
                            $pedido->nombre = $datos['nombre'][$i];
                            $pedido->tipo = $datos['tipo'][$i];
                            $pedido->hora_creacion = $horaCreacion;
                        
                            $pedido->save();
                        }
                    }
                    else
                    {
                        $pedido = new pedido();
                        $pedido->codigo_mesa =  $codigoMesa; //asigno el id
                        $pedido->codigo_unico = $codigoUnico;
                        $pedido->nombre = $datos['nombre'];                 
                        $pedido->tipo = $datos['tipo'];
                        $pedido->hora_creacion = $horaCreacion;
                        $pedido->save();
                    }

                    $newResponse = $response->withJson("Pedido en preparacion. Id Mesa: $codigoMesa, Id Pedido: $codigoUnico", 200);//devuelvo el id de la mesa
                }
                else
                {
                    $newResponse = $response->withJson("No es un tipo válido", 200);  
                }
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
        
                    //hora en la que entrega el pedido
                    // $horaEntrega = \DateTime::createFromFormat('Y-m-d H:i:s', $pedido->hora_pedido);//timestamp creacion del pedido  
                    // $horaEntrega->modify("+$minutos minutes");//agrego los minutos
                    // $pedido->hora_entrega = $horaEntrega;
                    
        
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
            
            $newResponse = $response->withJson("Pedido $idPedido entregado", 200);
        }
        else
        {
            $newResponse = $response->withJson("No se encontró el pedido $idPedido", 200);
        }

        return $newResponse;
    }

    public function CobrarPedido($request, $response, $args)
    {
        //Saco el total
        
        $codigoUnico = $pedido->codigo_mesa;

        $mesa = mesa::where('codigo_unico', $codigoUnico)->first();
        $mesa->estado = 'Con clientes pagando';
        $mesa->save();

    }

    //Valido el tipo de pedido
    public static function ValidarTipo($tipo)
    {
        $esValido = true;

        if(is_array($tipo))
        {
            $length = count($tipo);

            for($i = 0; $i < $length; $i++)
            {
                if(strcasecmp($tipo[$i],'cerveza') == 0 ||
                    strcasecmp($tipo[$i],'bebida') == 0 ||
                    strcasecmp($tipo[$i],'comida') == 0 )
                {
                    continue;
                }
                else
                {
                    $esValido = false;
                    break;
                }
            }
        }
        else
        {
            if(strcasecmp($tipo,'cerveza') == 0 ||
                    strcasecmp($tipo,'bebida') == 0 ||
                    strcasecmp($tipo,'comida') == 0 )
                {
                    $esValido = true;
                }
                else
                {
                    $esValido = false;
                }
        }



        return $esValido;
    }

  
}