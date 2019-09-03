<?php
    require_once "funciones.php";

    $objeto = array("nombre" => $_GET["nombre"]);

    Guardar("archivo.txt", $objeto);

    $datos= Leer("archivo.txt");

    echo $datos;
    



    // $ar = fopen("archivo.txt", "r");
    

    // // fwrite($ar, "Hola");;
    // // fwrite($ar, "Hola" . PHP_EOL);
    // // fwrite($ar, "Hola" . PHP_EOL);
    // // fwrite($ar, "Hola" . PHP_EOL);

    // // copy("archivo.txt", "archivoCopia.txt");

    // // echo $datos;

    // // unlink("archivoCopia.txt");

    // // fclose($ar);

    // $datos = fread($ar, filesize("archivo.txt"));

    // echo $datos;


    // fclose($ar);

?>