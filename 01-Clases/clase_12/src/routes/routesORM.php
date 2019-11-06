<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\usuario;
use App\Models\ORM\usuarioControler;


include_once __DIR__ . '/../../src/app/modelORM/usuario.php';
include_once __DIR__ . '/../../src/app/modelORM/usuarioControler.php';


return function (App $app) {
    $container = $app->getContainer();

     $app->group('/usuarioORM', function () {   

        $this->get('/',usuarioControler::class . ':traerTodos');

        $this->post('/registroUsuario', usuarioControler::class . ':cargarUno');
        
        $this->get('/login', usuarioControler::class . ':loginUsuario')->add(function ($request, $response, $next){
		
		$email = $request->getParam("email");
        $clave = $request->getParam("clave");

        //Busco al usuario por email en la base de datos:
        $usuario = usuario::where('email', $email)->first();
        

        //Compruebo la clave:
        if($usuario != null && hash_equals($usuario->clave, crypt($clave, "aaa")) == true) //generar salt 2do parametro igual al anterior
        {
            $response = $next($request, $response); 
        }
        else
        {
            $response->write("No existe $email", 200);
        }

        return $response;

	    });
     
    });

};