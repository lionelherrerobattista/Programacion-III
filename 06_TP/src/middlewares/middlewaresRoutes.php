<?php

use App\Models\AutentificadorJWT;
use App\Models\ORM\empleado;

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

    public function ValidarSocio($request, $response, $next)
    {
        
        $token = $request->getHeader('token');
        $token = $token[0];

        $datosToken = AutentificadorJWT::ObtenerData($token);     
        $idEmpleadoToken = $datosToken->id;

        $empleadoToken = empleado::where('id', $idEmpleadoToken)->first();

        if(strcasecmp($empleadoToken->tipo, 'socio') == 0 || strcasecmp($empleadoToken->tipo, 'admin') == 0)
        {
            $newResponse = $next($request, $response);
        }
        else
        {
            $newResponse = $response->withJson("No es socio", 200);
        }

        return $newResponse;
    }

    public function ValidarAdmin($request, $response, $next)
    {
        
        $token = $request->getHeader('token');
        $token = $token[0];

        $datosToken = AutentificadorJWT::ObtenerData($token);     
        $idEmpleadoToken = $datosToken->id;

        $empleadoToken = empleado::where('id', $idEmpleadoToken)->first();

        if(strcasecmp($empleadoToken->tipo, 'admin') == 0)
        {
            $newResponse = $next($request, $response);
        }
        else
        {
            $newResponse = $response->withJson("No es admin", 200);
        }

        return $newResponse;
    }

    public function ValidarMozo($request, $response, $next)
    {
        
        $token = $request->getHeader('token');
        $token = $token[0];

        $datosToken = AutentificadorJWT::ObtenerData($token);     
        $idEmpleadoToken = $datosToken->id;

        $empleadoToken = empleado::where('id', $idEmpleadoToken)->first();

        if(strcasecmp($empleadoToken->tipo, 'mozo') == 0 || strcasecmp($empleadoToken->tipo, 'admin') == 0)
        {
            $newResponse = $next($request, $response);
        }
        else
        {
            $newResponse = $response->withJson("No es mozo", 200);
        }

        return $newResponse;
    }


   
}
    
?>