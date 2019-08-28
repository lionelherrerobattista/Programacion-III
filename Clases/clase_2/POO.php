<?php
    require_once "./Clases/persona.php";
    require_once "./Clases/alumno.php";
    
    session_start();
    //session_unset();
    //$i = 0;

    /*
    if(isset($_GET["Nombre"]) && isset($_GET["Apellido"]))
    {
        $nombre = $_GET["Nombre"];
        $apellido = $_GET["Apellido"];

        $alumno = new Alumno($nombre, $apellido);

        $datos = $alumno->toString();
    
        echo $datos;
    }*/
    
    /*
            $cantidad = $_POST["cantidad"];
    
        while($i < $cantidad)
        {
            $alumno = new Alumno("alumno " . ($i + 1),
                        "apellido " . ($i + 1));
            
            $alumnos[$i] = $alumno;

            $i++;
        }
    */
    

    /*
    $datos = Alumno::mostrarListaAlumnos($alumnos);

    echo $datos;*/

    if($_SERVER['REQUEST_METHOD'] == 'GET')
    {

        $nombre = $_GET["Nombre"];
        $apellido = $_GET["Apellido"];

        $alumno = new Alumno($nombre, $apellido);

        //$datos = $alumno->toString();

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

        echo "Alumno Cargado<br>";

        //$datos = $alumno->toString();

        //echo $datos;
        
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(isset($_SESSION["alumnos"]))
        {
            $alumnos = $_SESSION["alumnos"];

            $datos = Alumno::mostrarListaAlumnos($alumnos);

            echo $datos;
            echo count($alumnos);
        }
            
    }
   


  

    


?>

