<?php

    class Vehiculo
    {
        public $marca;
        public $modelo;
        public $patente;
        public $precio;
        public $rutaFoto;

        public function __construct($marca, $modelo, $patente, $precio, $archivoFoto)
        {

            $this->marca = $marca;
            $this->modelo = $modelo;
            $this->patente = $patente;
            $this->precio = $precio;

            $rutaFoto = Archivo::GuardarArchivoTemporal($archivoFoto, "./imagenes/", $patente);

            $this->rutaFoto = $rutaFoto;
            

        }


        //Manejo la fuente de datos acá:
        public static function TraerVehiculos()
        {
            $ruta = "./vehiculos.txt";
            
            $listaVehiculos = Archivo::LeerArchivo($ruta);

            if($listaVehiculos == null)
            {
                $listaVehiculos = "Error al traer los datos";
            }

            return $listaVehiculos;
        }

        public static function TraerUnVehiculo($patente)
        {
            $ruta = "./vehiculos.txt";
            
            $listaVehiculos = Vehiculo::TraerVehiculos($ruta);

            $vehiculo = null;

            if($listaVehiculos != null)
            {
            
                foreach($listaVehiculos as $auxVehiculo)
                {
                    if(strcasecmp($auxVehiculo->patente, $patente) == 0)
                    {
                        $vehiculo = $auxVehiculo;
                        break;
                    }
                }
            
            }

            return $vehiculo;
        }

        public static function GuardarVehiculo($vehiculo)
        {
            $ruta = "./vehiculos.txt";
            $vehiculoRepetido = false;
            $guardo = false;

            //Veo si está repetido
            if(file_exists($ruta))
            {
                $listavehiculos = Vehiculo::TraerVehiculos();

                
                foreach($listavehiculos as $auxVehiculo)
                {
                    if($auxVehiculo->patente == strtolower($vehiculo->patente))
                    {
                        $vehiculoRepetido = true;
                        break;
                    }
                }
            }
                
            //guardo
            if($vehiculoRepetido == false)
            {
                Archivo::GuardarUno($ruta, $vehiculo);
                $guardo = true;
            }
            

            return $guardo;
        }  

        public static function CrearTabla($listaVehiculos)
        {
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

            return $tablaVehiculos;
        }

    }
    


?>