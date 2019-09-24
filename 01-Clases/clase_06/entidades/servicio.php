<?php

    class Servicio
    {
        public $id;
        public $tipo;
        public $precio;
        public $demora;

        public function __construct($id, $tipo, $precio, $demora)
        {

            $this->id = $id;
            $this->tipo = $tipo;
            $this->precio = $precio;
            $this->demora = $demora;
            

        }

        public static function TraerServicios($ruta)
        {
            
            $listaServicios = Archivo::LeerArchivo($ruta);

            if($listaServicios == null)
            {
                $listaServicios = "Error al traer los datos";
            }

            return $listaServicios;
        }

    }
