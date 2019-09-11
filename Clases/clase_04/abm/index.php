<?php
    require_once "./clases/archivo.php";
    require_once "./clases/alumno.php";

    $opcion = $_POST["opcion"];
    $ruta = "objetos.json";//donde guardo el json
    $destino = "./archivos/";//de los archivos
    $archivo = $_FILES["archivo"];

    switch($opcion)
    {
        case "guardar"://Guardar archivo temporal
        if(isset($_POST["nombre"], $_POST["apellido"], $_POST["legajo"], $_FILES["archivo"]))
        {
            $rutaFoto = Archivo::GuardarArchivoTemporal($archivo, $destino);

            $objeto = array("nombre" => $_POST["nombre"], "apellido" => $_POST["apellido"],
                 "legajo" => $_POST["legajo"], "rutaFoto" => $rutaFoto);

            Archivo::Guardar($ruta, $objeto);

        }
        break;

        case "borrar"://borrar
        if(isset($_POST["legajo"]))
        {
          $legajo = $_POST["legajo"];

          Archivo::BorrarPersona($ruta, $legajo);

        }
        break;

        case "modificar"://Modificar
        if(isset($_POST["nombre"], $_POST["legajo"]))
        {

            $rutaFoto = Archivo::GuardarArchivoTemporal($archivo, $destino);
            
            $objetoModificado = array("nombre" => $_POST["nombre"],"apellido" => $_POST["apellido"],
            "legajo" => $_POST["legajo"], "rutaFoto" => $rutaFoto);

            Archivo::ModificarPersona($ruta, $objetoModificado);

        }
        break;

        case "mostrar"://Mostrar
        Archivo::Mostrar($ruta);
        break;

        // case "guardarDesdeArchivo":
        // $destino = Archivo::GuardarArchivoTemporal($archivo, $destino);

        // Archivo::Mostrar($destino);
        // break;

    }

    //Para ver en Chrome:
    echo Archivo::Mostrar($ruta);

?>
