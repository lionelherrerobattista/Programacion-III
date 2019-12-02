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
        $mesa = new mesa();

        $mesa->estado = 'Cerrada';

        $mesa->save();

    }


  
}