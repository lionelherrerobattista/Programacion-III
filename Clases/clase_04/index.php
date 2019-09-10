<?php
    // var_dump($_FILES); //array de array, adentro está el archivo
    // var_dump($_POST); //devuelve array vacío

    $archivo = $_FILES["archivo"];//nombre del archivo
    $origen = $archivo["tmp_name"];//ubicación temporal
    $fecha = new DateTime();//timestamp para no repetir nombre
    


    //otro metodo: $_FILES["archivo"]["tmp_name"];

    //busco la extensión del archivo:
    $extension = pathinfo($_FILES["archivo"]["name"], PATHINFO_EXTENSION);

    echo $extension;

    $destino = "C:\\xampp\\htdocs\\clase_4\\archivo" . $fecha->getTimeStamp() . "." . $extension;

    //lo saco de la carpeta temporal:
    move_uploaded_file($origen, $destino);

?>