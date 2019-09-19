<?php

    require_once "./clases/persona.php";

    class Alumno extends Persona
    {
        public $legajo;
        public $rutaFoto;

        public function __construct($nombre, $apellido, $legajo, $rutaFoto)
        {
            parent::__construct($nombre, $apellido);

            $this->legajo = $legajo;
            $this->rutaFoto = $rutaFoto;

        }

        public static function MostrarAlumno($alumno)
        {
            $datos = "Nombre: " . ucwords($alumno->nombre) . "<br>";
            $datos = $datos . "Apellido: " . ucwords($alumno->apellido) . "<br>";
            $datos = $datos . "Legajo: "  . $alumno->legajo  . "<br><br>";
            $datos = $datos . "<img src='" . $alumno->rutaFoto . "'/><br>";

            return $datos;
        }

        //Manejo la fuente de datos acá:
        public static function TraerAlumnos()
        {
            $ruta = "./objetos.json";
            
            $datos = Archivo::MostrarPersonas($ruta);

            if($datos == null)
            {
                $datos = "Error al traer los datos";
            }

            return $datos;
        }

    }


?>