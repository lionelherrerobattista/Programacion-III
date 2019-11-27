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

        $this->post('/empleado/suspender/{id}', empleadoControler::class . ':SuspenderEmpleado');

        $this->post('/empleado/eliminar/{id}', empleadoControler::class . ':BorrarEmpleado');

        $this->post('/pedidos', pedidoControler::class . ':CargarPedido');

        $this->get('/pedidos/{id}', empleadoControler::class . ':VerPedidos');

        $this->post('/pedido/preparacion/{id}', empleadoControler::class . ':PrepararPedido');

     
    });

};