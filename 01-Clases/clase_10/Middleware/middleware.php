<?php

class Middleware
{

    //Se ejecuta primero:
    public static function ValidarClave($request, $response, $next)
    {
        $datos = $request->getParsedBody();

        $response->write("  antes  ");

        //Valido datos:
        if($datos["usuario"] == "juan" && $datos["pass"] == "1234")
        {
            //invoco la api
            $response = $next($request, $response);

            $response->write("Se logeo");
        }
        else
        {
            $response->write("Datos incorrectos");
        }

        //Después de que se ejecuto la api:
        $response->write("  despues  ");

        return $response;
    }
}


?>