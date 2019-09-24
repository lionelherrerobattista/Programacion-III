<?php
    require_once "archivo.php";

    $opcion = $_POST["opcion"];
    $ruta = "objetos.json";

    switch($opcion)
    {
        case "guardar"://Guardar en archivo
        if(isset($_POST["nombre"], $_POST["legajo"]))
        {
            $objeto = array("nombre" => $_POST["nombre"], "legajo" => $_POST["legajo"]);

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

    }






    $datos = Leer("objetos.json");

    Mostrar($datos);

    // // fwrite($ar, "Hola" . PHP_EOL); //constante PHP_EOL

    // // copy("archivo.txt", "archivoCopia.txt"); //Copia archivo

    // // unlink("archivoCopia.txt"); //borra archivo


?>
