<?php
    require_once "./clases/archivo.php";
    require_once "./clases/alumno.php";

    $opcion = $_POST["opcion"];
    $ruta = "objetos.json";
    $destino = "./archivos/";
    $archivo = $_FILES["archivo"];

    switch($opcion)
    {
        case "guardar"://Guardar en archivo
        if(isset($_POST["nombre"], $_POST["legajo"], $_FILES["archivo"]))
        {
            $rutaFoto = Archivo::GuardarArchivoTemporal($archivo, $destino);

            $objeto = array("nombre" => $_POST["nombre"], "legajo" => $_POST["legajo"], "rutaFoto" => $rutaFoto);

            Archivo::Guardar($ruta, $objeto);

            Archivo::Mostrar($ruta);
        }
        break;

        case "borrar"://borrar
        if(isset($_POST["legajo"]))
        {
          $legajo = $_POST["legajo"];

          Archivo::Borrar($ruta, $legajo);

          Archivo::Mostrar($ruta);

        }
        break;

        case "modificar"://Modificar
        if(isset($_POST["nombre"], $_POST["legajo"]))
        {
          $objetoModificado = array("nombre" => $_POST["nombre"], "legajo" => $_POST["legajo"]);

          Archivo::Modificar($ruta, $objetoModificado);

          Archivo::Mostrar($ruta);

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






    // $datos = Leer("objetos.json");

    // Mostrar($datos);

    // // fwrite($ar, "Hola" . PHP_EOL); //constante PHP_EOL

    // // copy("archivo.txt", "archivoCopia.txt"); //Copia archivo

    // // unlink("archivoCopia.txt"); //borra archivo


?>
