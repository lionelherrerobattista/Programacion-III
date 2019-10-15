<?php

require_once "./entidades/usuario.php";
require_once "./entidades/archivo.php";
require_once "./entidades/log.php";

class LoginApi
{
    public static function cargarUsuario($request, $response)
    {
        $datos = $request->getParsedBody();
        $fotos = $request->getUploadedFiles();
        $newResponse;

        if(Usuario::ValidarLegajo($datos["legajo"]))
        {
            $usuario = new Usuario($datos["legajo"], $datos["email"], $datos["nombre"], $datos["clave"],
                $fotos["fotoUno"], $fotos["fotoDos"]);

            Usuario::GuardarUsuario($usuario);

            $newResponse = $response->withJson(Usuario::TraerUsuarios(), 200);
        }
        else
        {
            $newResponse = $response->withJson("Legajo repetido", 200);
        }


        $log = new Log("POST", "1.0.0.1");
        Log::GuardarLog($log);

        return $newResponse;
    }

    public static function loginUsuario($request, $response, $args)
    {
        $legajo = $request->getParam("legajo");
        $clave = $request->getParam("clave");
        $existeUsuario = false;
        $newResponse;

        $listaUsuarios = Usuario::TraerUsuarios();

        foreach($listaUsuarios as $auxUsuario)
        {
            if($auxUsuario->legajo == $legajo)
            {
                $existeUsuario = true;

                if($auxUsuario->clave == $clave)
                {

                    $newResponse = $response->withJson($auxUsuario, 200);
                }
                else
                {
                    $newResponse = $response->withJson("clave incorrecta", 200);
                }

                break;              
            }
        }

        if($existeUsuario == false)
        {
            $newResponse = $response->withJson("No existe el legajo", 200);
        }

        $log = new Log("GET", "1.0.0.1");
        Log::GuardarLog($log);

        return $newResponse;
    }

    public static function modificarUsuario($request, $response)
    {
        $datos = $request->getParsedBody();
        $fotos = $request->getUploadedFiles();

        
        if(!(Usuario::ValidarLegajo($datos["legajo"])))
        {
            $usuario = new Usuario($datos["legajo"], $datos["email"], $datos["nombre"], $datos["clave"],
                $fotos["fotoUno"], $fotos["fotoDos"]);

            Usuario::ModificarUsuario($usuario);
        }

        $newResponse = $response->withJson(Usuario::TraerUsuarios(), 200);

        $log = new Log("POST", "1.0.0.1");
        Log::GuardarLog($log);


        return $newResponse;
       
    }

    public static function verUsuarios($request, $response, $args)
    {
        $legajo = $request->getParam("legajo");

        $listaUsuarios =  Usuario::TraerUsuarios();
        $arrayDatos = array();

        foreach($listaUsuarios as $auxUsuario)
        {
            $usuario = array(
                "legajo"=> $auxUsuario->legajo,
                "nombre"=> $auxUsuario->nombre,
                "email"=> $auxUsuario->email,
                "fotoUno"=> $auxUsuario->fotoUno,
                "fotoDos"=> $auxUsuario->fotoDos);

            array_push($arrayDatos, $usuario);
        }

        $newResponse = $response->withJson($arrayDatos, 200);

        $log = new Log("GET", "1.0.0.1");
        Log::GuardarLog($log);

        return $newResponse;
    }

    public static function verUsuario($request, $response, $args)
    {
        $legajo = $request->getParam("legajo");
        $existeLegajo = false;
        $newResponse;

        $listaUsuarios = Usuario::TraerUsuarios();

        foreach($listaUsuarios as $auxUsuario)
        {
            if($auxUsuario->legajo == $legajo)
            {
                $existeLegajo = true;

                $newResponse = $response->withJson($auxUsuario, 200);

                break;

            }
        }

        if($existeLegajo == false)
        {
            $newResponse = $response->withJson("No se encontró el legajo", 200);
        }

        $log = new Log("GET", "1.0.0.1");
        Log::GuardarLog($log);

        return $newResponse;
    }

    public static function consultarLogs($request, $response, $args)
    {
        $fecha = $request->getParam("fecha");
        $fecha = new DateTime($fecha, new DateTimeZone('America/Argentina/Buenos_Aires'));
        $fechaLog;
        $datos = array();
        
        $listaLogs = Log::TraerLogs();

        foreach($listaLogs as $log)
        {
            $fechaLog = new DateTime($log->hora, new DateTimeZone('America/Argentina/Buenos_Aires'));

            if($fechaLog > $fecha)
            {             
                array_push($datos, $log);
            }
        }

        $newResponse = $response->withJson($datos, 200);

        return $newResponse;
    } 
}


?>
