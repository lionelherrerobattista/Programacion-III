<?php

use App\Models\ORM\usuario;//ruta completa del namespace de la clase
use App\Models\AutentificadorJWT;

include_once __DIR__ . '/../../src/app/modelAPI/AutentificadorJWT.php';

class Middleware
{
    public function validarRuta($request, $response, $next)
    {
        $esValido = false;

        $token = $request->getHeader('token');
        $token = $token[0];

        try
        {
            AutentificadorJWT::VerificarToken($token);

            $esValido = true;
        }
        catch(\Exception $e)
        {
            $newResponse = $response->withJson("Token inválido. Error: " . $e->getMessage(), 200);
        }

        if($esValido)
        {
            $newResponse = $next($request, $response);
        }
      
        

        return $newResponse;
    }


    public function validarAdmin($request, $response, $next)
    {
        //despues de validar token
        $token = $request->getHeader('token');
        $token = $token[0];

        $datos = AutentificadorJWT::ObtenerData($token);

        $usuario = usuario::where('legajo', $datos->legajo)->first();

        if(strcasecmp($usuario->tipo, 'admin') == 0)
        {
            $newResponse = $next($request, $response);
        }
        else
        {
            $newResponse = $response->withJson("No es admin" , 200);
        }

        return $newResponse;
    }
}
    
?>