<?php

    class Servicio
    {
        public $id;
        public $tipo;
        public $precio;
        public $demora;

        public function __construct($id, $tipo, $precio, $demora)
        {

            if(strcasecmp("10.000km", $tipo) == 0 ||
                strcasecmp("20.000km", $tipo) == 0 ||
                    strcasecmp("50.000km", $tipo) == 0)
            {
             
                    
                $this->id = $id;
                $this->tipo = $tipo;
                $this->precio = $precio;
                $this->demora = $demora;   

            }
            

        }

        public static function TraerServicios()
        {
            $ruta = "./tipoServicio.txt";
            
            $listaServicios = Archivo::LeerArchivo($ruta);

            if($listaServicios == null)
            {
                $listaServicios = "Error al traer los datos";
            }

            return $listaServicios;
        }

        public static function GuardarServicio($vehiculo)
        {
            $ruta = "./tipoServicio.txt";
            
            $guardoServicio = false;

            if(Archivo::GuardarUno($ruta, $vehiculo))
            {
                $guardoServicio = true;
            }

            return $guardoServicio;
        }  

    }
