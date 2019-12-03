<?php
namespace App\Models\ORM;

use Slim\App;
use App\Models\ORM\cliente;
use App\Models\ORM\encuesta;



include_once __DIR__ . '/cliente.php';
include_once __DIR__ . '/encuesta.php';



use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\AutentificadorJWT;
use \Exception;


class clienteControler
{

    public function CompletarEncuesta($request, $response, $args)
    {
        $datos = $request->getParsedBody();

        if(isset($datos["puntajeMesa"], $datos["puntajeRestaurante"], $datos["puntajeMozo"],
            $datos["puntajeCocinero"], $datos["textoExperiencia"], $datos["codigoMesa"]))
        {
            if(clienteControler::ValidarPuntaje($datos["puntajeMesa"]) &&
            clienteControler::ValidarPuntaje($datos["puntajeRestaurante"]) &&
            clienteControler::ValidarPuntaje($datos["puntajeMozo"]) &&
            clienteControler::ValidarPuntaje($datos["puntajeCocinero"]))
            {
                $encuesta = new encuesta();
                $encuesta->puntaje_mesa = $datos["puntajeMesa"];
                $encuesta->puntaje_restaurante = $datos["puntajeRestaurante"];
                $encuesta->puntaje_mozo = $datos["puntajeMozo"];
                $encuesta->puntaje_cocinero = $datos["puntajeCocinero"];
                $encuesta->texto_experiencia = $datos["textoExperiencia"];

                $cliente = cliente::where('codigo_mesa', $datos['codigoMesa'])->first();
                $encuesta->id_cliente = $cliente->id;

                $encuesta->save();

                $cliente->id_encuesta = $encuesta->id;
                $cliente->save();

                $newResponse = $response->withJson("Encuesta enviada", 200);
            }
            else
            {
                $newResponse = $response->withJson("El puntaje tiene que ser del 1 al 10", 200);
            }
        }
        else
        {
            $newResponse = $response->withJson("Faltan datos", 200);
        }

        return $newResponse;
    }


    public static function ValidarPuntaje($puntaje)
    {
        $esValido = false;

        if($puntaje >= 1 && $puntaje <= 10)
        {
            $esValido = true;
        }

        return $esValido;
    }
}