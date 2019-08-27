<?php
    require_once "./Clases/persona.php";
    require_once "./Clases/alumno.php";
    
    $datos;
    $nombre;
    $alumno;

    if((isset($_GET["Nombre"])))
    {
        $nombre = $_GET["Nombre"];

        $alumno = new Alumno($nombre);

        $datos = $alumno->toString();
    
        echo $datos;
    }
   


  

    


?>

