<?php
namespace App\Models\ORM;
use App\Models\ORM\cd;
use App\Models\IApiControler;

include_once __DIR__ . '/cd.php';
include_once __DIR__ . '/artista.php';
include_once __DIR__ . '../../modelAPI/IApiControler.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class cdControler implements IApiControler 
{
 	public function Beinvenida($request, $response, $args) {
      $response->getBody()->write("GET => Bienvenido!!! ,a UTN FRA SlimFramework");
    
    return $response;
    }
    
     public function TraerTodos($request, $response, $args) {
       	//return cd::all()->toJson();
        $todosLosCds=cd::all();

        //reemplazo el id por el nombre del artista
        foreach($todosLosCds as $auxCd)
        {
          $artista = artista::find($auxCd->interpret);

          $auxCd->interpret = $artista->nombre;
        }

        $newResponse = $response->withJson($todosLosCds, 200);  

        return $newResponse;
    }
    public function TraerUno($request, $response, $args) {
     	  
      $id = $request->getParam('id');
        
      $cd = cd::where('id', $id)->first();

      if($cd != null)
      {
          $newResponse = $response->withJson($cd, 200);
      }
      else
      {
          $newResponse = $response->withJson("No se encontró al cd", 200);
      }
         
    
    	return $newResponse;
    }
   
      public function CargarUno($request, $response, $args) {
        
        $datos = $request->getParsedBody();

        $cd = new cd();
        $cd->titel = $datos['titel']; 
        $cd->jahr = $datos['jahr'];
        $cd->interpret = $datos['interpret'];
        $cd->save();
         
        $newResponse = $response->withJson("Artista cargado", 200);  
         
        return $newResponse;
        
    }
      public function BorrarUno($request, $response, $args) {
       
        $datos = $request->getParsedBody();
        
        $cd = cd::find($datos['id']);

        if($cd != null)
        {
            cd::destroy($datos['id']);
            $newResponse = $response->withJson("cd borrado", 200);  
        }
        else
        {
            $newResponse = $response->withJson("No se encontró al cd", 200);  
        }

      	return $newResponse;
      
    }
     
     public function ModificarUno($request, $response, $args) {
     	 
      $datos = $request->getParsedBody();

      if(isset($datos['id']))
      {
        $cd = cd::find($datos['id']);

        if($cd != null && isset($datos['titel'], $datos['jahr'], $datos['interpret']))
        {
            $cd->titel = $datos['titel'];
            $cd->jahr = $datos['jahr'];
            $cd->interpret =  $datos['interpret'];
            $cd->save();
            
            $newResponse = $response->withJson("cd modificado", 200);      
        }
        elseif(!(isset($datos['titel'], $datos['jahr'], $datos['interpret'])))
        {
            $newResponse = $response->withJson("Falta un dato a modificar", 200); 
        }
        else
        {
            $newResponse = $response->withJson("No se encontró al cd", 200); 
        }
      }
      else
      {
        $newResponse = $response->withJson("Id no definido", 200);
      }    
       
      return 	$newResponse;
    }


  
}