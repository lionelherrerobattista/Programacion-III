<?php

    require_once "./entidades/vehiculo.php";
    require_once "./entidades/servicio.php";
    require_once "./entidades/IApiUsable.php";
    require_once "./entidades/turno.php";

    class VehiculoApi
    {
        public function __construct()
        {

        }

        public static function consultarVehiculo($request, $response, $args)
        {
            $ruta = "./vehiculos.txt";
            $muestroVehiculo = false;
            $encontro = false;
            $consulta = strtolower($args["consulta"]);

            $datos = array();


            $listavehiculos = Vehiculo::TraerVehiculos($ruta);

                
            foreach($listavehiculos as $auxVehiculo)
            {
                if($auxVehiculo->marca == $consulta || $auxVehiculo->modelo == $consulta ||
                    $auxVehiculo->patente == $consulta)
                {
                    $muestroVehiculo = true;
                }

                if($muestroVehiculo == true)
                {
                    $encontro = true;
                    array_push($datos, $auxVehiculo);
                }

                $muestroVehiculo = false;

            }

            if($encontro == false)
            {
                $datos = "No encontró $consulta";
            }


            $newResponse = $response->withJson($datos, 200); //codigo de respuesta
            
        
            return $newResponse; //devolver siempre Json
        }

        
        public static function cargarVehiculo($request, $response) //no paso args
        {
            $ruta = "./vehiculos.txt";
            $vehiculoRepetido = false;
            $mensaje = "Error";
            $args = $request->getParsedBody();

            $vehiculo = new Vehiculo(strtolower($args["marca"]), strtolower($args["modelo"]), strtolower($args["patente"]), strtolower($args["precio"]));
   
            if(file_exists($ruta))
            {
                $listavehiculos = Vehiculo::TraerVehiculos($ruta);

                foreach($listavehiculos as $auxVehiculo)
                {
                    if($auxVehiculo->patente == strtolower($vehiculo->patente))
                    {
                        $vehiculoRepetido = true;
                    }
                }
            }
                
            if($vehiculoRepetido == false)
            {
                Archivo::GuardarUno($ruta, $vehiculo);
                $mensaje = "Vehículo Guardado";
            }
            else
            {
                $mensaje = "Vehiculo repetido";
            }

            return $response->getBody()->write($mensaje);
        }

        public static function cargarTipoServicio($request, $response) //no paso args
        {
            $ruta = "./tipoServicio.txt";
            
            $args = $request->getParsedBody();

            //comprobar que el tipo sea el correcto
            $servicio = new Servicio(strtolower($args["id"]), strtolower($args["tipo"]), strtolower($args["precio"]), strtolower($args["demora"]));
                            
            Archivo::GuardarUno($ruta, $servicio);

            //ver id repetido

            $listaServicios = Servicio::TraerServicios($ruta);
            
            $newResponse = $response->withJson($listaServicios, 200);

            return $newResponse;
        }

        public static function sacarTurno($request, $response, $args)
        {
            $ruta = "./turnos.txt";
            $rutaVehiculos =  "./vehiculos.txt";
            $rutaServicios = "./tipoServicio.txt";
            $muestroVehiculo = false;
            $patente = strtolower($args["patente"]);
            $fecha = strtolower($args["fecha"]);
            $datos = array();
            $vehiculo = null;


            
            $listaServicios = Servicio::TraerServicios($rutaServicios);

           
            if(file_exists($rutaVehiculos))
            {
                $listavehiculos = Vehiculo::TraerVehiculos($rutaVehiculos);

                foreach($listavehiculos as $auxVehiculo)
                {
                    if($auxVehiculo->patente == $patente)
                    {
                        $vehiculo = $auxVehiculo;
                        break;
                    }
                }
            }


            $turno = new Turno($fecha, $patente, $vehiculo->marca, $vehiculo->modelo, $listaServicios[0]->precio, $listaServicios[0]->tipo);

            Archivo::GuardarUno($ruta, $turno);

            Turno::TraerTurnos($ruta);

            
        }

        public static function mostrarTurnos($request, $response, $args)
        {
            $ruta = "./turnos.txt";

            $listaTurnos = Turno::TraerTurnos($ruta);

            $newResponse = $response->withJson($listaTurnos, 200);

            return $newResponse;
        }

        public static function inscripciones($request, $response, $args)
        {
            $ruta = "./turnos.txt";

            $listaTurnos = Turno::TraerTurnos($ruta);

           
            // usort(//array , //funcion que ordena);
         

            $newResponse = $response->withJson($listaOrdenada, 200);

            return $newResponse;
        }


        

    }

?>