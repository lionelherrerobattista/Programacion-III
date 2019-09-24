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

        // public static function MostrarAlumno($alumno)
        // {
        //     $datos = "Nombre: " . ucwords($alumno->nombre) . "<br>";
        //     $datos = $datos . "Apellido: " . ucwords($alumno->apellido) . "<br>";
        //     $datos = $datos . "Legajo: "  . $alumno->legajo  . "<br><br>";
        //     $datos = $datos . "<img src='" . $alumno->rutaFoto . "'/><br>";

        //     return $datos;
        // }

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