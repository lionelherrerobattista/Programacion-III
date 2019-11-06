<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\cd;
use App\Models\ORM\cdApi;


include_once __DIR__ . '/../../src/app/modelORM/cd.php';
include_once __DIR__ . '/../../src/app/modelORM/cdControler.php';

return function (App $app) {
    $container = $app->getContainer();

     $app->group('/cdORM', function () {   
         
        $this->get('/', function ($request, $response, $args) {
          
            //Agrego
            // $cd = new cd;
            // $cd->titel = "lalala";
            // $cd->interpret = "aaaaa";
            // $cd->jahr = 1999;
            // $cd->save();
          
            // modificar:
            // $cd = cd::find(7);
            // $cd->interpret = "bbbb";
            // $cd->save();
          
            //return cd::all()->toJson();

            //borrar:
            // cd::destroy(7);

          $todosLosCds=cd::all();

        //   $todosLosArtistas = artista::all();


          $newResponse = $response->withJson($todosLosCds, 200);  
          return $newResponse;
        });
    });


     $app->group('/cdORM2', function () {   

        $this->get('/',cdApi::class . ':traerTodos');
   
    });

};