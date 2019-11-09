<?php

namespace App\Models\ORM;
use App\Models\ORM\artista;
use App\Models\IApiControler;

include_once __DIR__ . '/artista.php';
include_once __DIR__ . '../../modelAPI/IApiControler.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class artistaControler implements IApiControler 
{
 	  
     public function TraerTodos($request, $response, $args) {
       	
        $todosLosArtistas = artista::all();

        $newResponse = $response->withJson($todosLosArtistas,200); 

        return $newResponse;
    }

    public function TraerUno($request, $response, $args) {
        
        $id = $request->getParam('id');
        
        $artista = artista::where('id', $id)->first();

        if($artista != null)
        {
            $newResponse = $response->withJson($artista, 200);
        }
        else
        {
            $newResponse = $response->withJson("No se encontró al artista", 200);
        }
           
    	return $newResponse;
    }
   
    public function CargarUno($request, $response, $args) {
         
        $datos = $request->getParsedBody();

        $artista = new artista();
        $artista->nombre = $datos['nombre'];
        $artista->save();
         
        $newResponse = $response->withJson("Artista cargado", 200);  
         
        return $newResponse;
    }

    public function BorrarUno($request, $response, $args) {
        
        $datos = $request->getParsedBody();
        
        $artista = artista::find($datos['id']);

        if($artista != null)
        {
            artista::destroy($datos['id']);
            $newResponse = $response->withJson("Artista borrado", 200);  
        }
        else
        {
            $newResponse = $response->withJson("No se encontró al artista", 200);  
        }

      	return $newResponse;
    }
     
    public function ModificarUno($request, $response, $args) {

        
        $datos = $request->getParsedBody();

        if(isset($datos['id']))
        {

            $artista = artista::find($datos['id']);

            if($artista != null && isset($datos['nombre']))
            {
                $artista->nombre = $datos['nombre'];
                $artista->save();
                $newResponse = $response->withJson("Artista modificado", 200);      
            }
            elseif(!(isset($datos['nombre'])))
            {
                $newResponse = $response->withJson("No indicó el nombre", 200); 
            }
            else
            {
                $newResponse = $response->withJson("No se encontró al artista", 200); 
            }
        }
        else
        {
            $newResponse = $response->withJson("Id no definido", 200);
        }

		return 	$newResponse;
    }


  
}

?>