<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\empleado;
use App\Models\ORM\empleadoControler;
use App\Models\ORM\pedido;
use App\Models\ORM\pedidoControler;



include_once __DIR__ . '/../../src/app/modelORM/empleado.php';
include_once __DIR__ . '/../../src/app/modelORM/empleadoControler.php';
include_once __DIR__ . '/../../src/app/modelORM/pedido.php';
include_once __DIR__ . '/../../src/app/modelORM/pedidoControler.php';
include_once __DIR__ . '/../../src/middlewares/middlewaresRoutes.php';


return function (App $app) {
    $container = $app->getContainer();

     $app->group('/comandaORM', function () {   

        $this->post('/empleados', empleadoControler::class . ':CargarEmpleado');

        $this->post('/empleados/suspender/{id}', empleadoControler::class . ':SuspenderEmpleado');

        $this->post('/empleados/eliminar/{id}', empleadoControler::class . ':BorrarEmpleado');

        $this->post('/empleados/login', empleadoControler::class . ':LoginEmpleado');

        // $this->post('/pedidos', pedidoControler::class . ':CargarPedido');

        // $this->get('/pedidos/{id}', empleadoControler::class . ':VerPedidos');

        // $this->post('/pedido/preparacion/{id}', empleadoControler::class . ':PrepararPedido');

     
    });


    $app->group('/comandaORM/pedidos', function () {   


        $this->post('', pedidoControler::class . ':CargarPedido');

        $this->get('', pedidoControler::class . ':VerPedidos');

        $this->post('/preparar/{idPedido}', pedidoControler::class . ':PrepararPedido');
        
        $this->post('/terminar/{idPedido}', pedidoControler::class . ':TerminarPedido');
        
        $this->post('/entregar/{idPedido}', pedidoControler::class . ':ServirPedido');
 
    })->add(Middleware::class . ':ValidarRuta');


    $app->group('/comandaORM/mesas', function () {   


        $this->post('', pedidoControler::class . ':CargarMesa');

 
    })->add(Middleware::class . ':ValidarRuta');



};