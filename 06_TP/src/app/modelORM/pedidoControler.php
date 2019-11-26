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
        
        if(isset($datos['nombre'], $datos['tipo']))
        {
            if(pedidoControler::ValidarTipo($datos['tipo']))
            {
                
                if(isset($datos['idMesa']))//Si una mesa quiere pedir algo más
                {
                    $idMesa = $datos['idMesa'];
                }
                else
                {
                    //creo id random para la mesa:
                    $idMesa = substr(md5(uniqid(rand(), true)), 0, 5);
                }

            
                if(is_array($datos['nombre']))//si pide más de 1 cosa
                {
                    $length = count($datos['nombre']);

                    for($i = 0; $i < $length; $i++)
                    {
                        $pedido = new pedido();
                        $pedido->id_mesa =  $idMesa; //asigno el id
                        $pedido->nombre = $datos['nombre'][$i];
                        $pedido->tipo = $datos['tipo'][$i];
    
                        $pedido->save();
                    }
                }
                else
                {
                    $pedido = new pedido();
                    $pedido->id_mesa =  $idMesa;
                    $pedido->nombre = $datos['nombre'];
                    $pedido->tipo = $datos['tipo'];
                    $pedido->save();
                }

                $newResponse = $response->withJson("Pedido en preparacion. Id: $idMesa", 200);//devuelvo el id de la mesa
            }
            else
            {
                $newResponse = $response->withJson("No es un tipo válido", 200);  
            }
            
        }
        else
        {
            
        
            $newResponse = $response->withJson("Falta dato", 200);  
            
        }

        return $newResponse;
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