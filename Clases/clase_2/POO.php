<?php
    require_once "./Clases/persona.php";
    require_once "./Clases/alumno.php";
    
    $datos;
    $nombre;
    $apellido;
    $alumno;

    if(isset($_GET["Nombre"]) && isset($_GET["Apellido"]))
    {
        $nombre = $_GET["Nombre"];
        $apellido = $_GET["Apellido"];

        $alumno = new Alumno($nombre, $apellido);

        $datos = $alumno->toString();
    
        echo $datos;
    }
   


  

    


?>

