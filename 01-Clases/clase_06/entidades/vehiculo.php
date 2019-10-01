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
            
            $listaVehiculos = Archivo::LeerArchivo($ruta);

            if($listaVehiculos == null)
            {
                $listaVehiculos = "Error al traer los datos";
            }

            return $listaVehiculos;
        }

        public static function GuardarVehiculo($vehiculo)
        {
            $ruta = "./vehiculos.txt";
            $vehiculoRepetido = false;
            $guardo = false;

            if(file_exists($ruta))
            {
                $listavehiculos = Vehiculo::TraerVehiculos();

                //Veo si está repetido
                foreach($listavehiculos as $auxVehiculo)
                {
                    if($auxVehiculo->patente == strtolower($vehiculo->patente))
                    {
                        $vehiculoRepetido = true;
                        break;
                    }
                }
            }
                
            if($vehiculoRepetido == false)
            {
                Archivo::GuardarUno($ruta, $vehiculo);
                $guardo = true;
            }
            

            return $guardo;
        }  

    }


?>