<?php


class Middleware
{
    function validarUsuario($request, $resposne, $next)
    {
        $email = $request->getParam("email");
        $clave = $request->getParam("clave");

        //Busco al usuario por email en la base de datos:
        $usuario = usuario::where('email', $email)->first();

        //Compruebo la clave:
       
        if(hash_equals($usuario->clave, crypt($clave, "aaa"))) //generar salt 2do parametro igual al anterior
        {
            $response = $next($request, $response);
        }
        else
        {
        $newResponse = $response->withJson("No existe $email", 200);
        }
    }
}
    
?>