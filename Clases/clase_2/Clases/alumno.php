<?php
   

    class Alumno extends Persona
    {

        public function toString()
        {
            return json_encode($this); //devuelvo un string json
        }

        public static function mostrarListaAlumnos($alumnos)
        {
            return json_encode($alumnos);
        }

    }


?>