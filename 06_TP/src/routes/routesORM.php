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
use App\Models\ORM\cliente;
use App\Models\ORM\clienteControler;



include_once __DIR__ . '/../../src/app/modelORM/empleado.php';
include_once __DIR__ . '/../../src/app/modelORM/empleadoControler.php';
include_once __DIR__ . '/../../src/app/modelORM/pedido.php';
include_once __DIR__ . '/../../src/app/modelORM/pedidoControler.php';
include_once __DIR__ . '/../../src/app/modelORM/mesa.php';
include_once __DIR__ . '/../../src/app/modelORM/mesaControler.php';
include_once __DIR__ . '/../../src/app/modelORM/comida.php';
include_once __DIR__ . '/../../src/app/modelORM/comidaControler.php';
include_once __DIR__ . '/../../src/app/modelORM/cliente.php';
include_once __DIR__ . '/../../src/app/modelORM/clienteControler.php';
include_once __DIR__ . '/../../src/middlewares/middlewaresRoutes.php';


return function (App $app) {
    $container = $app->getContainer();

    //empleados
     $app->group('/comandaORM/empleados', function () {   

        $this->post('', empleadoControler::class . ':CargarEmpleado')->add(Middleware::class . ':ValidarAdmin');//admin

        $this->post('/suspender/{idEmpleado}', empleadoControler::class . ':SuspenderEmpleado')->add(Middleware::class . ':ValidarAdmin');//socio?

        $this->post('/eliminar/{idEmpleado}', empleadoControler::class . ':BorrarEmpleado')->add(Middleware::class . ':ValidarAdmin');//admin

        $this->post('/modificar/{idEmpleado}', empleadoControler::class . ':ModificarEmpleado')->add(Middleware::class . ':ValidarAdmin');//admin

        

    })->add(Middleware::class . ':ValidarRuta');

    $app->post('/comandaORM/empleados/login', empleadoControler::class . ':LoginEmpleado');

    //pedidos
    $app->group('/comandaORM/pedidos', function () {   

        $this->post('', pedidoControler::class . ':CargarPedido')->add(Middleware::class . ':ValidarMozo');

        $this->post('/eliminar/{idPedido}', pedidoControler::class . ':BorrarPedido')->add(Middleware::class . ':ValidarMozo');//mozo

        $this->get('', pedidoControler::class . ':VerPedidos');//todos

        $this->post('/preparar/{idPedido}', pedidoControler::class . ':PrepararPedido');
        
        $this->post('/terminar/{idPedido}', pedidoControler::class . ':TerminarPedido');

        $this->post('/cancelar/{idPedido}', pedidoControler::class . ':CancelarPedido')->add(Middleware::class . ':ValidarMozo');
        
        $this->post('/servir/{idPedido}', pedidoControler::class . ':ServirPedido')->add(Middleware::class . ':ValidarMozo');//mozo
        
        $this->post('/cobrar/{codigoPedido}', pedidoControler::class . ':CobrarPedido')->add(Middleware::class . ':ValidarMozo');//mozo
        
    })->add(Middleware::class . ':ValidarRuta');

    //mesas
    $app->group('/comandaORM/mesas', function () {   


        $this->post('', mesaControler::class . ':CargarMesa')->add(Middleware::class . ':ValidarAdmin');//admin

        $this->post('/eliminar/{idMesa}', mesaControler::class . ':BorrarMesa')->add(Middleware::class . ':ValidarAdmin');//admin

        $this->post('/modificar/{idMesa}', mesaControler::class . ':ModificarMesa')->add(Middleware::class . ':ValidarAdmin');//admin

        $this->post('/cerrar/{idMesa}', mesaControler::class . ':CerrarMesa')->add(Middleware::class . ':ValidarSocio');//socio

 
    })->add(Middleware::class . ':ValidarRuta');

    //comidas
    $app->group('/comandaORM/comidas', function () {   

        $this->post('', comidaControler::class . ':CargarComida')->add(Middleware::class . ':ValidarAdmin');//admin

        $this->post('/eliminar/{idComida}', comidaControler::class . ':BorrarComida')->add(Middleware::class . ':ValidarAdmin');//admin

        $this->post('/modificar/{idComida}', comidaControler::class . ':ModificarComida')->add(Middleware::class . ':ValidarAdmin');

    })->add(Middleware::class . ':ValidarRuta');

    //cliente
    $app->group('/comandaORM/clientes', function () { 

        $this->get('/pedido', pedidoControler::class . ':MostrarTiempoRestante');
        
        $this->post('/encuesta', clienteControler::class . ':CompletarEncuesta');

    });

    //admin
    $app->group('/comandaORM/admin', function () { 

        $this->get('/operaciones', empleadoControler::class . ':ConsultarOperaciones');

        $this->get('/pedidos', pedidoControler::class . ':ConsultarPedidos');

        $this->get('/mesas', mesaControler::class . ':ConsultarMesas');
        

    })->add(Middleware::class . ':ValidarAdmin')->add(Middleware::class . ':ValidarRuta');
    



};