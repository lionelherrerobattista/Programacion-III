<?php
namespace App\Models\ORM;

use Slim\App;
use App\Models\ORM\usuario;
use App\Models\ORM\profesor_materia;
use App\Models\IApiControler;

include_once __DIR__ . '/usuario.php';
include_once __DIR__ . '/profesor_materia.php';
include_once __DIR__ . '../../modelAPI/IApiControler.php';


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\AutentificadorJWT;
use \Exception;




class usuarioControler implements IApiControler 
{

  private static $claveSecreta = 'claveSecreta1';
 
  public function TraerTodos($request, $response, $args) {
        
    $todosLosUsuarios = usuario::all();
    
    $newResponse = $response->withJson($todosLosUsuarios, 200);  

    return $newResponse;
  }

  public function TraerUno($request, $response, $args) {
      //complete el codigo
    $newResponse = $response->withJson("sin completar", 200);  
    return $newResponse;
  }
    
  public function CargarUno($request, $response, $args) {
        
    $datos = $request->getParsedBody();
    $archivos = $request->getUploadedFiles();
    
    //Agrego a la base de datos:
    $usuario = new usuario;
    
    if(isset($datos["email"], $datos["clave"], $datos["tipo"] ))
    {
      if(strcasecmp($datos["tipo"], 'profesor') == 0 ||
        strcasecmp($datos["tipo"], 'alumno') == 0 ||
        strcasecmp($datos["tipo"], 'admin') == 0 )
      {
        
        $usuario->email = $datos["email"];
        $usuario->clave = crypt($datos["clave"], self::$claveSecreta);
        $usuario->tipo = $datos["tipo"];

        if($archivos != null)
        {
            $usuario->foto = usuarioControler::GuardarArchivoTemporal($archivos['foto'], __DIR__ . "../../../../img/",
                $usuario->legajo."_".$usuario->tipo);    
        }
        
        

        $usuario->save();

        $newResponse = $response->withJson("Usuario registrado", 200);  
       }
       else
       {
        $newResponse = $response->withJson("No es tipo válido", 200);  
       }
    
    }
    else
    {
      $newResponse = $response->withJson("Faltan datos", 200);  
    }
    
    return $newResponse;
  }

  public function BorrarUno($request, $response, $args) {
    //complete el codigo
    $newResponse = $response->withJson("sin completar", 200);  
    return $newResponse;
  }
      
  public function ModificarUno($request, $response, $args) {
    
    $token = $request->getHeader('token');
    $token = $token[0];
    $datosToken = AutentificadorJWT::ObtenerData($token);

    $datosParaModificar = $request->getParsedBody();
    $legajoUsuarioAModificar = $request->getAttribute('legajo');

    $usuario = usuario::where('legajo', $datosToken->legajo)->first();

    if((strcasecmp($usuario->tipo, 'profesor') == 0 ||
      strcasecmp($usuario->tipo, 'alumno') == 0) && 
      $usuario->legajo != $legajoUsuarioAModificar)
    {
      $newResponse = $response->withJson("No tiene permisos", 200);
    }
    else
    {

      $usuarioAModificar = usuario::where('legajo', $legajoUsuarioAModificar)->first();
 
      if($usuario != null)
      {
      
        switch($usuarioAModificar->tipo)
        {
          case 'alumno':        
            $foto = $request->getUploadedFiles();
            $foto = $foto['foto'];
            $usuarioAModificar->email = $datosParaModificar['email'];
            usuarioControler::HacerBackup(__DIR__ . "../../../../img/" , $usuarioAModificar);
            $usuarioAModificar->foto = usuarioControler::GuardarArchivoTemporal($foto, __DIR__ . "../../../../img/", $usuarioAModificar->legajo);
            $usuarioAModificar->save();
            break;

          case 'profesor':
          $usuarioAModificar->email = $datosParaModificar['email'];
          profesor_materia::where('id_profesor', $usuarioAModificar->legajo)->delete();

          if(is_array($datosParaModificar['materiasDictadas']))
          {
            $length = count($datosParaModificar['materiasDictadas']);
          }
          else
          {
            $length = 1;
          }

          for($i = 0; $i < $length; $i++)
          {
            $profesorMateria = new profesor_materia();
            $profesorMateria->id_profesor = $usuarioAModificar->legajo;
            $profesorMateria->id_materia = $datosParaModificar['materiasDictadas'][$i];
            $profesorMateria->save();

          }
          $usuarioAModificar->save();        
          break;
            
        }

        $newResponse = $response->withJson("Usuario modificado", 200);

      }
      else
      {
        $newResponse = $response->withJson("No se encontro el legajo $usuario->legajo", 200);
      }
    }
    


    return 	$newResponse;
  }

  public function loginUsuario($request, $response, $args)
  {
    $datos = $request->getParsedBody();
    if(isset($datos['legajo'], $datos['clave']))
    {
      $legajo = $datos['legajo'];
      $clave = $datos['clave'];
      
      $usuario = usuario::where('legajo', $legajo)->first();

      if($usuario != null)
      {
        if(hash_equals($usuario->clave, crypt($clave, self::$claveSecreta)))
        {

          $datosToken = array(
            'legajo' => $usuario->legajo,
            'email' => $usuario->email,
            'tipo' => $usuario->tipo,
            'foto' => $usuario->foto
          );

          $token = AutentificadorJWT::CrearToken($datosToken);

          $newResponse = $response->withJson($token, 200);  
        }
        else
        {
          $newResponse = $response->withJson("Clave incorrecta", 200);  
        }
      
      }
      else
      {
        $newResponse = $response->withJson("No se encontró el legajo $legajo", 200);
      }
    }
    else
    {
      $newResponse = $response->withJson("Faltan datos", 200);
    }
    
    return $newResponse;

  }

  public static function GuardarArchivoTemporal($archivo, $destino, $nombre)
    {
        $origen = $archivo->getClientFileName();
        
        $fecha = new \DateTime();
        $fecha = $fecha->setTimezone(new \DateTimeZone('America/Argentina/Buenos_Aires'));
        $fecha = $fecha->format("d-m-Y-His");
        $extension = pathinfo($archivo->getClientFileName(), PATHINFO_EXTENSION);
        $destino = "$destino$nombre-$fecha.$extension";
        $archivo->moveTo($destino);
        return $destino;
    }

    public static function HacerBackup($ruta, $elementoAModificar)
        {
      
            $fecha = new \DateTime();//timestamp para no repetir nombre
            $fecha = $fecha->setTimezone(new \DateTimeZone('America/Argentina/Buenos_Aires'));
            $fecha = $fecha->format("d-m-Y-His");
            
            $extension = pathinfo($elementoAModificar->foto, PATHINFO_EXTENSION);
            //Donde guardo el backup:
            $nombreBackup =  __DIR__ . "../../../../img/backup/backup$elementoAModificar->legajo-$fecha.$extension";
            //Muevo el backup de la foto:
            rename($elementoAModificar->foto, $nombreBackup);
        }
  




  
}