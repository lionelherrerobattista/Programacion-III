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
            $vehiculoRepetido = false;
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

            $tablaTurnos = "<table>
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Patente</th>
                                        <th>Marca</th>
                                        <th>Modelo</th>
                                        <th>Precio</th>
                                        <th>Servicio</th>
                                    </tr>     
                                </thead>
                                <tbody>";

            foreach($listaTurnos as $turno)
            {
                $tablaTurnos .=     "<tr>
                                        <td>" . $turno->fecha . "</td>
                                        <td> " . $turno->patente . "</td>
                                        <td>" . $turno->marca . "</td>
                                        <td>" . $turno->modelo . "</td>
                                        <td>" . $turno->precio . "</td>
                                        <td>" . $turno->tipoServicio . "</td>
                                    
                                    </tr>";
            }

                                
    
            $tablaTurnos .=  "</tbody></table>";


            return $response->getBody()->write($tablaTurnos);
        }


        public static function mostrarVehiculos($request, $response, $args)
        {
            $ruta = "./vehiculos.txt";

            $listaVehiculos = Vehiculo::TraerVehiculos($ruta);

            $tablaVehiculos = "<table>
                                <thead>
                                    <tr>
                                        <th>Marca</th>
                                        <th>Modelo</th>
                                        <th>Patente</th>
                                        <th>Precio</th>
                                        <th>Foto</th>
                                    </tr>     
                                </thead>
                                <tbody>";

            foreach($listaVehiculos as $vehiculo)
            {
                $tablaVehiculos .= "<tr>
                                        <td>" . $vehiculo->marca . "</td>
                                        <td> " . $vehiculo->modelo . "</td>
                                        <td>" . $vehiculo->patente . "</td>
                                        <td>" . $vehiculo->precio . "</td>
                                        <td>" . "<img src='$vehiculo->rutaFoto'/>" . "</td>
                                    </tr>";
            }

                                
    
            $tablaVehiculos .=  "</tbody></table>";


            return $response->getBody()->write($tablaVehiculos);
        }

        



        public static function inscripciones($request, $response, $args)
        {
            $ruta = "./turnos.txt";

            $listaTurnos = Turno::TraerTurnos($ruta);

            if(isset($args["filtro"]))
            {
                switch($args["filtro"])
                {
                    case "fecha":
                    usort($listaTurnos, array("vehiculoApi", "compararFecha"));
                    break;

                    case "servicio":
                    usort($listaTurnos, array("vehiculoApi", "compararServicio"));
                    break;
                }
                
            }

            $newResponse = $response->withJson($listaTurnos, 200);

            return $newResponse;
        }

        public static function ModificarVehiculo($request, $response, $args)
        {    
            $ruta = "./vehiculos.txt";
            $destino = "./imagenes/";
            $encontroVehiculo = false;

            $args = $request->getParsedBody();

            
   
            if(file_exists($ruta))
            {
                $listavehiculos = Vehiculo::TraerVehiculos($ruta);

                foreach($listavehiculos as $auxVehiculo)
                {
                    if($auxVehiculo->patente == strtolower($args["patente"]))
                    {
                        $encontroVehiculo = true;
                        break;
                    }
                }
            }

            if($encontroVehiculo == true)
            {
                $archivo = $request->getUploadedFiles();

                $rutaFoto = Archivo::GuardarArchivoTemporal($archivo, $destino, $args["patente"]);

                $vehiculo = new Vehiculo(strtolower($args["marca"]), strtolower($args["modelo"]),
                                             strtolower($args["patente"]), strtolower($args["precio"]), $rutaFoto);
                
                Archivo::ModificarUno($ruta, $vehiculo);

                $mensaje = "Vehículo Guardado";
            }
            else
            {
                $mensaje = "No encontrado";
            }


            $listaVehiculos = Vehiculo::TraerVehiculos($ruta);

            $newResponse = $response->withJson($listaVehiculos, 200);

            return $newResponse;  

        }



        //funiones que ordenan
        public static function compararFecha($elementoA, $elementoB)
        {

            return strcasecmp($elementoA->fecha, $elementoB->fecha);
        }

        public static function compararServicio($elementoA, $elementoB)
        {
            $retorno = 1;

            if($elementoA->tipoServicio < $elementoB->tipoServicio)
            {
                $retorno = -1;
            }
            else if($elementoA->tipoServicio == $elementoB->tipoServicio)
            {
                $retorno = 0;
            }

            return $retorno;

        }

        
        

    }

?>