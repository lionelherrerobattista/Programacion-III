<?php
    require_once "./Clases/persona.php";
    require_once "./Clases/alumno.php";
    require_once "./Clases/alumnoDAO.php";
    
    session_start();
    //session_unset();

    if($_SERVER['REQUEST_METHOD'] == 'GET') //Muestro
    {
        if(isset($_GET["caso"]))
        {
            switch($_GET["caso"])
            {
                case "alumno":
                    $datos = AlumnoDAO::mostrarListaAlumnos();    
                    echo $datos;
                    break;
                default:
                    if(isset($_GET["caso"]))
                    {
                        echo "caso inválido";
                    }
                    
            }
        }
        else
        {
            echo "caso no existe";
        }
 
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST') //Guardo
    {
        if(isset($_POST["caso"]))
        {
            switch($_POST["caso"])
            {
                case "alumno":
                    $nombre = $_POST["nombre"];
                    $apellido = $_POST["apellido"];

                    $alumno = new Alumno($nombre, $apellido);

                    AlumnoDAO::guardar($alumno);   
                    break;

                default:
                    if(isset($_POST["caso"]))
                    {
                        echo "caso inválido";
                    }
                    
            }
        }
        else
        {
            echo "caso no existe";
        }
        
    }


?>

