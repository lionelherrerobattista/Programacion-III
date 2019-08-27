<?php
   

    class Alumno extends Persona
    {

        public function toString()
        {
            return "Nombre: " . (string) $this->nombre;
        }

    }


?>