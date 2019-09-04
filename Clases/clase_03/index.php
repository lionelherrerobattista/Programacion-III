<?php
    require_once "funciones.php";


    if(isset($_POST["nombre"], $_POST["legajo"]))
    {
        $objeto = array("nombre" => $_POST["nombre"], "legajo" => $_POST["legajo"]);

        Guardar("objetos.json", $objeto);
    }


    $datos = Leer("objetos.json");

    Mostrar($datos);

    // // fwrite($ar, "Hola" . PHP_EOL); //constante PHP_EOL

    // // copy("archivo.txt", "archivoCopia.txt"); //Copia archivo

    // // unlink("archivoCopia.txt"); //borra archivo


?>