<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\empleado;
use App\Models\ORM\empleadoControler;
use App\Models\ORM\pedido;
use App\Models\ORM\pedidoControler;
use App\Models\ORM\mesa;
use App\Models\ORM\mesaControler;
use App\Models\ORM\comida;
use App\Models\ORM\comidaControler;



include_once __DIR__ . '/../../src/app/modelORM/empleado.php';
include_once __DIR__ . '/../../src/app/modelORM/empleadoControler.php';
include_once __DIR__ . '/../../src/app/modelORM/pedido.php';
include_once __DIR__ . '/../../src/app/modelORM/pedidoControler.php';
include_once __DIR__ . '/../../src/app/modelORM/mesa.php';
include_once __DIR__ . '/../../src/app/modelORM/mesaControler.php';
include_once __DIR__ . '/../../src/app/modelORM/comida.php';
include_once __DIR__ . '/../../src/app/modelORM/comidaControler.php';
include_once __DIR__ . '/../../src/middlewares/middlewaresRoutes.php';


return function (App $app) {
    $container = $app->getContainer();

    //empleados
     $app->group('/comandaORM/empleados', function () {   

        $this->post('', empleadoControler::class . ':CargarEmpleado');//admin

        $this->post('/suspender/{idEmpleado}', empleadoControler::class . ':SuspenderEmpleado');//socio?

        $this->post('/eliminar/{idEmpleado}', empleadoControler::class . ':BorrarEmpleado');//admin

        $this->post('/modificar/{idEmpleado}', empleadoControler::class . ':ModificarEmpleado');//admin

        

    })->add(Middleware::class . ':ValidarRuta');

    $app->post('/comandaORM/empleados/login', empleadoControler::class . ':LoginEmpleado');

    //pedidos
    $app->group('/comandaORM/pedidos', function () {   

        $this->post('', pedidoControler::class . ':CargarPedido');//mozo

        $this->post('/eliminar/{idPedido}', pedidoControler::class . ':BorrarPedido');//mozo

        $this->get('', pedidoControler::class . ':VerPedidos');//todos

        $this->post('/preparar/{idPedido}', pedidoControler::class . ':PrepararPedido');
        
        $this->post('/terminar/{idPedido}', pedidoControler::class . ':TerminarPedido');

        $this->post('/cancelar/{idPedido}', pedidoControler::class . ':CancelarPedido');
        
        $this->post('/entregar/{idPedido}', pedidoControler::class . ':ServirPedido');//mozo
        
        $this->post('/cobrar/{codigoPedido}', pedidoControler::class . ':CobrarPedido');//mozo
        
    })->add(Middleware::class . ':ValidarRuta');

    //mesas
    $app->group('/comandaORM/mesas', function () {   


        $this->post('', mesaControler::class . ':CargarMesa');//admin

        $this->post('/eliminar/{idMesa}', mesaControler::class . ':BorrarMesa');//admin

        $this->post('/modificar/{idMesa}', mesaControler::class . ':ModificarMesa');//admin

        $this->post('/cerrar/{idMesa}', mesaControler::class . ':CerrarMesa');//socio

 
    })->add(Middleware::class . ':ValidarRuta');

    //comidas
    $app->group('/comandaORM/comidas', function () {   

        $this->post('', comidaControler::class . ':CargarComida');//admin

        $this->post('/eliminar/{idComida}', comidaControler::class . ':BorrarComida');//admin

        $this->post('/modificar/{idComida}', comidaControler::class . ':ModificarComida');

    })->add(Middleware::class . ':ValidarRuta');

    //cliente
    $app->get('/comandaORM/pedido', pedidoControler::class . ':MostrarTiempoRestante');



};