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

        public static function cargarVehiculo($request, $response) //no paso args
        {
            $args = $request->getParsedBody();
            $archivoFoto = $request->getUploadedFiles();        

            //Creo el objeto
            $vehiculo = new Vehiculo($args["marca"], $args["modelo"], $args["patente"], $args["precio"], $archivoFoto);

            //Guardo
            if(Vehiculo::GuardarVehiculo($vehiculo))
            {
                $listaVehiculos = Vehiculo::TraerVehiculos();

                $newResponse = $response->withJson($listaVehiculos, 200);
            }
            else
            {
                $newResponse = $response->withJson("Vehículo repetido", 404);
            }
                      
            return $newResponse;
        }

        public static function consultarVehiculo($request, $response, $args)
        {
            $muestroVehiculo = false;
            $encontro = false;
            $consulta = strtolower($args["consulta"]);

            $datos = array();

            $listavehiculos = Vehiculo::TraerVehiculos();
          
            foreach($listavehiculos as $auxVehiculo)
            {
                if(strcasecmp($auxVehiculo->marca, $consulta) == 0 ||
                    strcasecmp($auxVehiculo->modelo, $consulta) == 0 ||
                    strcasecmp($auxVehiculo->patente, $consulta) == 0)
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
                $datos = "No existe $consulta";
            }


            $newResponse = $response->withJson($datos, 200); //codigo de respuesta
            
        
            return $newResponse; //devolver siempre Json
        }

        public static function cargarTipoServicio($request, $response) //no paso args
        {
            $ruta = "./tipoServicio.txt";
            
            $args = $request->getParsedBody();

            $servicio = new Servicio($args["id"], $args["tipo"], $args["precio"], $args["demora"]);

            if($servicio->tipo != null)
            {
                Servicio::GuardarServicio($servicio);
            }
            
            $listaServicios = Servicio::TraerServicios($ruta);
            
            $newResponse = $response->withJson($listaServicios, 200);

            return $newResponse;
        }

        public static function sacarTurno($request, $response, $args)
        {

            $patente = $args["patente"];
            $fecha = $args["fecha"];
            
  
            $listaServicios = Servicio::TraerServicios();
            //servicio random
            $idServicio = rand(0, (sizeof($listaServicios) - 1) );
         
            $vehiculo = Vehiculo::TraerUnVehiculo($patente);

            if($listaServicios != null && $vehiculo != null)
            {
                
                $turno = new Turno($fecha, $patente, $vehiculo->marca, $vehiculo->modelo,
                    $listaServicios[$idServicio]->precio, $listaServicios[$idServicio]->tipo);

                Turno::GuardarTurno($turno);
            }
            
            $listaTurnos = Turno::TraerTurnos();

            $newResponse = $response->withJSON($listaTurnos, 200);

            return $newResponse;
            
        }

        public static function mostrarTurnos($request, $response, $args)
        {
            $listaTurnos = Turno::TraerTurnos();

            $tablaTurnos = Turno::CrearTabla($listaTurnos);

            return $response->getBody()->write($tablaTurnos);
        }


        public static function filtrarTurnos($request, $response, $args)
        {

            $listaTurnos = Turno::TraerTurnos();

            if(isset($args["filtro"]) && $listaTurnos != null)
            {

                $tablaTurnos = Turno::FiltrarLista($listaTurnos, $args["filtro"]);

            }

            return $response->getBody()->write($tablaTurnos);
        }


        public static function ModificarVehiculo($request, $response, $args)
        {    
            $args = $request->getParsedBody();   
            
            $archivoFoto = $request->getUploadedFiles();

            $listaVehiculos = Vehiculo::TraerVehiculos();

            foreach($listaVehiculos as $auxVehiculo)
            {
                if(strcasecmp($auxVehiculo->patente, $args["patente"]) == 0)
                {
                    $vehiculo = new Vehiculo($args["marca"], $args["modelo"], $args["patente"], $args["precio"], $archivoFoto);
            
                    Vehiculo::ModificarVehiculo($vehiculo);
                }
            }

            $listaVehiculos = Vehiculo::TraerVehiculos();

            $newResponse = $response->withJson($listaVehiculos, 200);

            return $newResponse;  

        }

        public static function mostrarVehiculos($request, $response, $args)
        {

            $listaVehiculos = Vehiculo::TraerVehiculos();

            $tablaVehiculos = Vehiculo::CrearTabla($listaVehiculos);

            return $response->getBody()->write($tablaVehiculos);
        }


    }

?>