<?php
    //session_start();

    class AlumnoDAO
    {
        public static function mostrarListaAlumnos()
        {
            

            if(isset($_SESSION["alumnos"]))
            {
                $alumnos = $_SESSION["alumnos"];

                $datos = $alumnos;
       
            }

            return json_encode($datos);
        }

        public static function guardar($alumno)
        {           

            if(!isset($_SESSION["alumnos"]))
            {
                $alumnos = array($alumno);
                $indice = 0;
                $alumnos[$indice] = $alumno;
            }
            else
            {
                $alumnos = $_SESSION["alumnos"];

                $indice = count($alumnos); 


                $alumnos[$indice] = $alumno;
            }

            $_SESSION["alumnos"] = $alumnos;
                
            echo "Alumno Cargado";
        }
    }
    


?>