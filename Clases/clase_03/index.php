<?php
    require_once "funciones.php";

    if(isset($_GET["nombre"]))
    {
        $objeto = array("nombre" => $_GET["nombre"]);

        Guardar("objetos.json", $objeto);
    }


    $datos = Leer("objetos.json");

    var_dump($datos);

    // foreach($datos as $clave=>$valor)
    // {
    //     echo $clave . ": " . $valor;
    // }

    
    

    // // fwrite($ar, "Hola" . PHP_EOL); //constante PHP_EOL

    // // copy("archivo.txt", "archivoCopia.txt"); //Copia archivo

    // // unlink("archivoCopia.txt"); //borra archivo


?>