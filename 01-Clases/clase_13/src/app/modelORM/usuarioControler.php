<?php

namespace App\Models\ORM;
use App\Models\ORM\usuario;
use App\Models\ORM\profesor_materia;
use App\Models\IApiControler;
use App\Models\AutentificadorJWT;

include_once __DIR__ . '/usuario.php';
include_once __DIR__ . '../../modelAPI/IApiControler.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class usuarioControler implements IApiControler 
{

    private static $claveSecreta = 'calveSecreta';
 	  
     public function TraerTodos($request, $response, $args) {
       	
        // $todosLosUsuarios = usuario::all();

        // $newResponse = $response->withJson($todosLosUsuarios,200); 

        // return $newResponse;
    }

    public function TraerUno($request, $response, $args) {
        
        // $id = $request->getParam('id');
        
        // $usuario = usuario::where('id', $id)->first();

        // if($usuario != null)
        // {
        //     $newResponse = $response->withJson($usuario, 200);
        // }
        // else
        // {
        //     $newResponse = $response->withJson("No se encontró al usuario", 200);
        // }
           
    	// return $newResponse;
    }
   
    public function CargarUno($request, $response, $args) {
         
        $datos = $request->getParsedBody();

        if(isset($datos['email'], $datos['clave'], $datos['tipo'], $datos['foto']))
        {
            $usuario = new usuario();
            $usuario->email = $datos['email'];
            $usuario->clave = crypt($datos['clave'], self::$claveSecreta);
            $usuario->foto = $datos['foto'];

            if(strcasecmp($datos['tipo'],'alumno') == 0 ||
                strcasecmp($datos['tipo'],'admin') == 0 ||
                strcasecmp($datos['tipo'],'profesor') == 0)
            {   
                $usuario->tipo = $datos['tipo'];
            }

            $usuario->save();
            
            $newResponse = $response->withJson("Usuario cargado", 200);  
        }
        else
        {
            $newResponse = $response->withJson("Falta dato", 200);  
        }
             
        return $newResponse;
    }

    public function BorrarUno($request, $response, $args) {
        
        // $datos = $request->getParsedBody();
        
        // $artista = artista::find($datos['id']);

        // if($artista != null)
        // {
        //     artista::destroy($datos['id']);
        //     $newResponse = $response->withJson("Artista borrado", 200);  
        // }
        // else
        // {
        //     $newResponse = $response->withJson("No se encontró al artista", 200);  
        // }

      	// return $newResponse;
    }
     
    public function ModificarUno($request, $response, $args) {

        
        $datos = $request->getParsedBody();
        // $legajo = $request->getParam('legajo');

        // $usuario = usuario::where('legajo', $legajo);

        // if($usuario != null)
        // {
        //     switch($usuario->tipo)
        //     {
        //         case 'alumno':
        //         $usuario->email = $datos['email'];
        //         $usuario->foto = $datos['foto'];
        //         break;

        //         // case 'profesor':
        //         // $usuario->email = $datos['email'];
        //         // foreach($datos['materia'] as $idMateria)
        //         // {
        //         //     $profesorMateria = new profesor_materia();
        //         //     $profesorMateria->id_profesor = $usuario->legajo;
        //         //     $profesorMateria->id_materia = $datos['materia'];
        //         //     $profesorMateria->save();
        //         // }             
        //         // break;

        //         // case 'admin':
        //         // $usuario->email = $datos['email'];
        //         // $usuario->foto = $datos['foto'];
        //         // foreach($datos['materia'] as $idMateria)
        //         // {
        //         //     $profesorMateria = new profesor_materia();
        //         //     $profesorMateria->id_profesor = $usuario->legajo;
        //         //     $profesorMateria->id_materia = $datos['materia'];
        //         //     $profesorMateria->save();
        //         // } 
        //         // break;
            

        //     }

        //     $newResponse = $response->withJson("Usuario modificado", 200);

            
        // }
        // else
        // {
        //     $newResponse = $response->withJson("No existe el usuario", 200);
        // }

        $newResponse = $response->withJson("No existe el usuario", 200);

		return 	$newResponse;
    }

    public function loginUsuario($request, $response, $args)
    {
        $datos = $request->getParsedBody();

        if(isset($datos["legajo"], $datos["clave"]))
        {
            $clave = $datos["clave"];
            $legajo = $datos["legajo"];

            $usuario = usuario::where('legajo', $legajo)->first();

            if($usuario != null)
            {
                if(hash_equals($usuario->clave, crypt($clave, self::$claveSecreta)))
                {
                    $datosUsuario = array(
                        'email' => $usuario->email,
                        'legajo' => $usuario->legajo,
                        'tipo' => $usuario->tipo
                    );

                    $token = AutentificadorJWT::CrearToken($datosUsuario);

                    $newResponse = $response->withJson($token, 200);
                }
                else
                {
                    $newResponse = $response->withJson('Clave incorrecta', 200);
                }
            }
            else
            {
                $newResponse = $response->withJson('No se encontró al usuario', 200);
            }
        }
        else
        {
            $newResponse = $response->withJson('Faltan datos', 200);
        }

        return $newResponse;

    }
    


  
}

?>