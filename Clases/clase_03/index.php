<?php
    require_once "archivo.php";

    $opcion = $_POST["opcion"];

    switch($opcion)
    {
        case "guardar"://Guardar en archivo
        if(isset($_POST["nombre"], $_POST["legajo"]))
        {
            $objeto = array("nombre" => $_POST["nombre"], "legajo" => $_POST["legajo"]);

            Guardar("objetos.json", $objeto);
        }
        break;

        case 2:
        break;

        case 3:
        break;

        case 4:
        break;

    }



    


    $datos = Leer("objetos.json");

    Mostrar($datos);

    // // fwrite($ar, "Hola" . PHP_EOL); //constante PHP_EOL

    // // copy("archivo.txt", "archivoCopia.txt"); //Copia archivo

    // // unlink("archivoCopia.txt"); //borra archivo


?>