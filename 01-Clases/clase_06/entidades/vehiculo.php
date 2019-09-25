<?php

    class Vehiculo
    {
        public $marca;
        public $modelo;
        public $patente;
        public $precio;

        public function __construct($marca, $modelo, $patente, $precio)
        {

            $this->marca = $marca;
            $this->modelo = $modelo;
            $this->patente = $patente;
            $this->precio = $precio;
            

        }


        //Manejo la fuente de datos acá:
        public static function TraerVehiculos($ruta)
        {
            $ruta = "./vehiculos.txt";
            
            $listaVehiculos = Archivo::LeerArchivo($ruta);

            if($listaVehiculos == null)
            {
                $listaVehiculos = "Error al traer los datos";
            }

            return $listaVehiculos;
        }

    }


?>