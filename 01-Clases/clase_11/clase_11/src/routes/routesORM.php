<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\cd;
use App\Models\ORM\cdControler;
use App\Models\ORM\artista;
use App\Models\ORM\artistaControler;


include_once __DIR__ . '/../../src/app/modelORM/cd.php';
include_once __DIR__ . '/../../src/app/modelORM/cdControler.php';
include_once __DIR__ . '/../../src/app/modelORM/artista.php';
include_once __DIR__ . '/../../src/app/modelORM/artistaControler.php';

return function (App $app) {

    $container = $app->getContainer();

     $app->group('/cdORM', function () {   
         
        $this->get('/artistas', artistaControler::class . ':traerTodos');
        
        $this->get('/artista', artistaControler::class . ':traerUno');
        
        $this->post('/nuevoArtista', artistaControler::class . ':cargarUno');

        $this->post('/borrarArtista', artistaControler::class . ':borrarUno');

        $this->post('/modificarArtista', artistaControler::class . ':modificarUno');

        $this->get('/cds', cdControler::class . ':traerTodos');
        
        $this->post('/nuevoCd', cdControler::class . ':cargarUno');

        $this->post('/borrarCd', cdControler::class . ':borrarUno');

        $this->post('/modificarCd', cdControler::class . ':modificarUno');
    });

};