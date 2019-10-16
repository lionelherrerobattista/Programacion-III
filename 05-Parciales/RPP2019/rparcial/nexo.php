<?php
    
    require_once "./entidades/archivo.php";
    require_once "./entidades/vehiculo.php";
    require_once "./entidades/servicio.php";
    require_once "./entidades/turno.php";
    require_once "./entidades/turno.php";
    
    
    
    //POST
    if(isset($_POST["caso"]))
    {
        $caso = $_POST["caso"];

        switch($caso)
        {
            case "cargarVehiculo":
                if(isset($_POST["marca"], $_POST["patente"], $_POST["kms"], $_FILES["archivo"]))
                {     
                    if(Vehiculo::ValidarPatente($_POST["patente"]))
                    {
                        
                        $archivo = $_FILES["archivo"];

                        $rutaFoto = Archivo::GuardarArchivoTemporal($archivo, "./img/");

                        $vehiculo = new Vehiculo($_POST["marca"], $_POST["patente"], $_POST["kms"], $rutaFoto);

                        //Guardo
                        if(Vehiculo::GuardarVehiculo($vehiculo))
                        {
                            $listaVehiculos = Vehiculo::TraerVehiculos();
                            
                            $newResponse = json_encode($listaVehiculos);
                        }
                        
                    }
                    else
                    {
                        $newResponse = json_encode("Vehículo repetido");
                    }
                    
                }

                echo $newResponse;

                break;
            
            case "cargarTipoServicio":
                if(isset($_POST["id"], $_POST["tipo"], $_POST["precio"], $_POST["demora"]))
                {     
                    if(Servicio::ValidarTipo($_POST["tipo"]))
                    {

                        if(Servicio::ValidarId($_POST["id"]))
                        {
                            $servicio = new Servicio($_POST["id"], $_POST["tipo"], $_POST["precio"], $_POST["demora"]);
               
                            if(Servicio::GuardarServicio($servicio))
                            {
                                $listaServicios = Servicio::TraerServicios();
                                
                                $newResponse = json_encode($listaServicios);
                            }
                        }
                        else
                        {
                            $newResponse = json_encode("id invalido");
                        }

                        
                        
                    }
                    else
                    {
                        $newResponse = json_encode("Tipo invalido");
                    }
                    
                }

                echo $newResponse;

                break;

                case "modificarVehiculo":
                    if(isset($_POST["marca"], $_POST["patente"], $_POST["kms"], $_FILES["archivo"]))
                    {     
                        if(!(Vehiculo::ValidarPatente($_POST["patente"])))
                        {

                            $archivo = $_FILES["archivo"];

                            $rutaFoto = Archivo::GuardarArchivoTemporal($archivo, "./img/");

                            $vehiculo = new Vehiculo($_POST["marca"], $_POST["patente"], $_POST["kms"], $rutaFoto);

                            //Guardo
                            Vehiculo::ModificarVehiculo($vehiculo);
                            
                            $listaVehiculos = Vehiculo::TraerVehiculos();
                            
                            $newResponse = json_encode($listaVehiculos);
                            
                            
                        }
                        else
                        {
                            $newResponse = json_encode("Vehículo inválido");
                        }
                        
                    }

                    echo $newResponse;
                    break;
        }
    }
    else if(isset($_GET["caso"]))
    {

        $caso = $_GET["caso"];

        switch($caso)
        {
            case "consultarVehiculo":
            $arrayVehiculos = array();

            if(isset($_GET["marca"]) || isset($_GET["patente"]))
            {
                $existeVehiculo = false;

                $newResponse;

                if(isset($_GET["marca"]))
                {
                    $marca = $_GET["marca"];

                    $existeVehiculo = false;

                    $listaVehiculos = Vehiculo::TraerVehiculos();
    
                    foreach($listaVehiculos as $auxVehiculo)
                    {
                        if(strcasecmp($auxVehiculo->marca,$marca) == 0)
                        {
                            $existeVehiculo = true;

                            array_push($arrayVehiculos, $auxVehiculo);
                                      
                        }
                    }

                    if($existeVehiculo == false)
                    {
                        $newResponse = json_encode("No existe $marca");
                    }
                    else
                    {
                        $newResponse = json_encode($arrayVehiculos);
                    }

                }
                else if(isset($_GET["patente"]))
                {
                    $patente = $_GET["patente"];

                    $existeVehiculo = false;

                    $listaVehiculos = Vehiculo::TraerVehiculos();
    
                    foreach($listaVehiculos as $auxVehiculo)
                    {
                        if($auxVehiculo->patente == $patente)
                        {
                            $existeVehiculo = true;

                            array_push($arrayVehiculos, $auxVehiculo);

                            break;
                                      
                        }
                    }

                    if($existeVehiculo == false)
                    {
                        $newResponse = json_encode("No existe $patente");
                    }
                    else
                    {
                        $newResponse = json_encode($arrayVehiculos);
                    }
                }             

               
            
                echo $newResponse;
            }
            break;

            case "sacarTurno":
            if(isset($_GET["patente"], $_GET["precio"], $_GET["fecha"]))
            {
                $patente = $_GET["patente"];
                $precio= $_GET["precio"];
                $fecha = $_GET["fecha"];
                
    
                if(!(Vehiculo::ValidarPatente($_GET["patente"])))
                {
                    $listaServicios = Servicio::TraerServicios();

                    foreach($listaServicios as $auxServicio)
                    {
                        if($auxServicio->precio == $precio)
                        {
                            break;
                        }
                    }

                    // //servicio random
                    // $idServicio = rand(0, (sizeof($listaServicios) - 1) );
                
                    $vehiculo = Vehiculo::TraerUnVehiculo($patente);

                    if($listaServicios != null && $vehiculo != null)
                    {
                        
                        $turno = new Turno($fecha, $patente, $vehiculo->marca,
                            $auxServicio->precio, $auxServicio->tipo);

                        Turno::GuardarTurno($turno);
                    }
                    
                    $listaTurnos = Turno::TraerTurnos();

                    $newResponse = json_encode($listaTurnos);
                                                    
                }
                else
                {
                    $newResponse = "La patente no existe";
                }
                
            }

            echo $newResponse;
            break;
            
            case "turnos":
            $listaTurnos = Turno::TraerTurnos();
            $tablaTurnos = Turno::CrearTabla($listaTurnos);
            echo $tablaTurnos;
            break;

            case "servicio":
            if(isset($_GET["tipo"]) || isset($_GET["fecha"]))
            {
                if(isset($_GET["tipo"]))
                {
                    $filtro = $_GET["tipo"];

                    $listaTurnos = Turno::TraerTurnos();
    
                    $tablaTurnos = Turno::FiltrarLista($listaTurnos, $filtro);
                }
                else
                {
                    $filtro = $_GET["fecha"];

                    $listaTurnos = Turno::TraerTurnos();
    
                    $tablaTurnos = Turno::FiltrarLista($listaTurnos, $filtro);
                }
          
            }

            echo $tablaTurnos;
            break;

        }

    }
    

?>