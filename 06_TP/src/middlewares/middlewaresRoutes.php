<?php

use App\Models\AutentificadorJWT;

include_once __DIR__ . '/../../src/app/modelAPI/AutentificadorJWT.php';

class Middleware
{
    public function ValidarRuta($request, $response, $next)
    {
        $esValido = false;

        $token = $request->getHeader('token');

        if($token != null)
        {
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

        }
        else
        {
            $newResponse = $response->withJson("No se envió le token", 200);
        }

        return $newResponse;
    }


   
}
    
?>