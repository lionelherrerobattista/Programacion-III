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

        public static function TraerServicios()
        {
            $ruta = "./tipoServicio.txt";
            
            $listaServicios = Archivo::LeerArchivo($ruta);

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

        public static function ValidarTipo($servicio)
        {
            $validado = false;

            $listaServicios = Servicio::TraerServicios();
         
            if(strcasecmp($servicio, "10.000km") == 0 || strcasecmp($servicio, "20.000km") == 0
             || strcasecmp($servicio, "50.000km") == 0)
            {
                $validado = true;
                
            }
         
            return $validado;
        }


        public static function ValidarId($id)
        {
            $validado = true;

            $listaServicios = Servicio::TraerServicios();

            foreach($listaServicios as $auxServicio)
            {

                if($auxServicio->id == $id)
                {
                    $validado = false;
                    break;
                }

            }

            return $validado;
        }

    }
