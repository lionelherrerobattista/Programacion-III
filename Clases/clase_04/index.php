<?php
    
    require_once "./clases/archivo.php";
    
    $archivo = $_FILES["archivo"]; //nombre del archivo

    $destino = "C:\\xampp\\htdocs\\clase_4";


    Archivo::GuardarArchivoTemporal($archivo, $destino);


?>