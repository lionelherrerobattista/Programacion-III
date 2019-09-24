<?php

    require_once "./entidades/vehiculo.php";
    require_once "./entidades/servicio.php";
    require_once "./entidades/IApiUsable.php";

    class VehiculoApi
    {
        public function __construct()
        {

        }

        public static function consultarVehiculo($request, $response, $args)
        {
            $ruta = "./vehiculos.txt";
            $muestroVehiculo = false;
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
                    array_push($datos, $auxVehiculo);
                }

                $muestroVehiculo = false;

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

            $servicio = new Servicio(strtolower($args["id"]), strtolower($args["tipo"]), strtolower($args["precio"]), strtolower($args["demora"]));
                            
            Archivo::GuardarUno($ruta, $servicio);

            //ver id repetido

            $listaServicios = Servicio::TraerServicios($ruta);
            
            $newResponse = $response->withJson($listaServicios, 200);

            return $newResponse;
        }

        public static function sacarTurno($request, $response, $args)
        {
            $ruta = "./vehiculos.txt";
            $muestroVehiculo = false;
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
                    array_push($datos, $auxVehiculo);
                }

                $muestroVehiculo = false;

            }

            $newResponse = $response->withJson($datos, 200); //codigo de respuesta
            
        
            return $newResponse; //devolver siempre Json
        }

        // public static function BorrarUno($request, $response, $args)
        // {
            
        //     $ruta = "./objetos.json";

        //     Archivo::BorrarPersona($ruta, $args["legajo"]);

        //     return $response->getBody()->write('Alumno Borrado');

        // }

        // public static function ModificarUno($request, $response, $args)
        // {    
        //     $ruta = "./objetos.json";
        //     $destino = "./imagenes/";

        //     //le paso el archivo
        //     $archivo = $request->getUploadedFiles();

        //     $rutaFoto = Archivo::GuardarArchivoTemporal($archivo, $destino);

        //     $alumnoModificado = new Alumno($args["nombre"], $args["apellido"], $args["legajo"], $rutaFoto);

        //     Archivo::ModificarAlumno($ruta, $alumnoModificado);

        //     return $response->getBody()->write('Alumno Modificado');
        // }

    }

?>