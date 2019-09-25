<?php

    class Turno
    {
        public $fecha;
        public $patente;
        public $marca;
        public $modelo;
        public $precio;
        public $tipoServicio;

        public function __construct($fecha, $patente, $marca, $modelo, $precio, $tipoServicio)
        {

            $this->fecha = $fecha;
            $this->patente = $patente;
            $this->marca = $marca;
            $this->modelo = $modelo;
            $this->precio = $precio;
            $this->tipoServicio = $tipoServicio;
            
        }

        public static function TraerTurnos($ruta)
        {
            
            $listaServicios = Archivo::LeerArchivo($ruta);

            if($listaServicios == null)
            {
                $listaServicios = "Error al traer los datos";
            }

            return $listaServicios;
        }
    }

?>