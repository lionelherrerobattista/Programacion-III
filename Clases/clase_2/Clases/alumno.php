<?php
   

    class Alumno extends Persona
    {

        public function toString()
        {
            return json_encode($this);
        }

    }


?>