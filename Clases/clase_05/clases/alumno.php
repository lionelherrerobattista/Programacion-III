<?php

    require_once "./clases/persona.php";

    class Alumno extends Persona
    {
        public $legajo;
        // public $rutaFoto;

        public function __construct($nombre, $apellido, $legajo)
        {
            parent::__construct($nombre, $apellido);

            $this->legajo = $legajo;

        }

        public static function MostrarAlumno($alumno)
        {
            $datos = "Nombre: " . ucwords($alumno->nombre) . "<br>";
            $datos = $datos . "Apellido: " . ucwords($alumno->apellido) . "<br>";
            $datos = $datos . "Legajo: "  . $alumno->legajo  . "<br><br>";

            return $datos;
        }

    }


?>