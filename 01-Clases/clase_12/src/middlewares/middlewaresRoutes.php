<?php

use App\Models\ORM\usuario;//ruta completa de la clase
use App\Models\AutentificadorJWT;

include_once __DIR__ . '/../../src/app/modelAPI/AutentificadorJWT.php';

class Middleware
{
    public function validarUsuario($request, $response, $next)
    {
        $datos = $request->getParsedBody();
        $email = $datos["email"];
        $clave = $datos["clave"];

        //Busco al usuario por email en la base de datos:
        $usuario = usuario::where('email', $email)->first();

       
        //Compruebo la clave:
        if($usuario != null && hash_equals($usuario->clave, crypt($clave, "aaa")) == true) //generar salt 2do parametro igual al anterior
        {

            //creo el token sin la clave
            $datosUsuario = array(

                'email' => $datos['email']
    
            );
    
            //Creo el token
            $token = AutentificadorJWT::CrearToken($datosUsuario);        

            //Reemplazo los datos del Body por el token, sin la clave
            $request = $request->withParsedBody(array('token' => $token));

            $response = $next($request, $response); 
        }
        else
        {
            $response->write("No existe $email", 200);
        }

        return $response;
    }
}
    
?>