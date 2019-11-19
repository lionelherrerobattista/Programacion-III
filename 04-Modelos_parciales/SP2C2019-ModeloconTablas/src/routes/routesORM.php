<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\usuario;
use App\Models\ORM\usuarioControler;
use App\Models\ORM\materia;
use App\Models\ORM\materiaControler;


include_once __DIR__ . '/../../src/app/modelORM/usuario.php';
include_once __DIR__ . '/../../src/app/modelORM/usuarioControler.php';
include_once __DIR__ . '/../../src/app/modelORM/materia.php';
include_once __DIR__ . '/../../src/app/modelORM/materiaControler.php';
include_once __DIR__ . '/../../src/middlewares/middlewaresRoutes.php';


return function (App $app) {
    $container = $app->getContainer();

     $app->group('/facultadORM', function () {   

        $this->post('/usuario', usuarioControler::class . ':cargarUno');

        $this->post('/login', usuarioControler::class . ':loginUsuario');

        $this->post('/materia', materiaControler::class . ':cargarUno')->add(Middleware::class . ':validarAdmin')->add(Middleware::class . ':validarRuta');

        $this->post('/usuario/{legajo}', usuarioControler::class . ':ModificarUno')->add(Middleware::class . ':validarRuta');
        
        $this->post('/inscripcion/{idMateria}', materiaControler::class . ':InscribirAlumno')->add(Middleware::class . ':validarRuta');

        $this->get('/materias', materiaControler::class . ':MostrarMaterias')->add(Middleware::class . ':validarRuta');

        $this->get('/materias/{idMateria}', materiaControler::class . ':TraerUno')->add(Middleware::class . ':validarRuta');
     
    });

};