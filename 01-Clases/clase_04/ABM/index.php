<?php
    require_once "./clases/archivo.php";
    require_once "./clases/alumno.php";

    
    $ruta = "objetos.json";//donde guardo el json
    $destino = "./archivos/";//de los archivos

    if(isset($_FILES["archivo"]))
    {
        $archivo = $_FILES["archivo"];    
    }
    

    if(isset($_POST["opcion"]))
    {
        $opcion = $_POST["opcion"];

        switch($opcion)
        {
            case "guardar"://Guardar alumno y archivo temporal foto
            if(isset($_POST["nombre"], $_POST["apellido"], $_POST["legajo"], $_FILES["archivo"]))
            { 

                $rutaFoto = Archivo::GuardarArchivoTemporal($archivo, $destino);

                $objeto = new Alumno($_POST["nombre"],$_POST["apellido"], $_POST["legajo"], $rutaFoto);

                Archivo::GuardarPersona($ruta, $objeto);

            }
            break;

            case "borrar"://borrar alumno
            if(isset($_POST["legajo"]))
            {
                $legajo = $_POST["legajo"];

                Archivo::BorrarPersona($ruta, $legajo);

            }
            break;

            case "modificar"://Modificar alumno
            if(isset($_POST["nombre"], $_POST["apellido"], $_POST["legajo"], $_FILES["archivo"]))
            {

                $rutaFoto = Archivo::GuardarArchivoTemporal($archivo, $destino);
                
                $objetoModificado = new Alumno($_POST["nombre"],$_POST["apellido"], $_POST["legajo"], $rutaFoto);

                Archivo::ModificarPersona($ruta, $objetoModificado);

            }
            break;
            
            default:
            echo "Opción no disponible<br>";
            break;


        }
    }
    else if(isset($_GET["opcion"]))
    {
        $opcion = $_GET["opcion"];

        switch($opcion)
        {
            case "mostrar"://Mostrar
            echo Archivo::MostrarPersonas($ruta);
            break;
            
            default:
            echo "Opción no disponible<br>";
            break;

        }
    }
    else
    {
        echo "Opción no disponible<br>";
    }

    //Para ver en Chrome:
    // echo Archivo::MostrarPersonas($ruta);
    
?>
