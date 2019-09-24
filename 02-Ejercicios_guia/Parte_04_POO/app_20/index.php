<?php

    require_once "./clases/rectangulo.php";
    
    $v1 = new Punto(1, 1);
    $v3 = new Punto(7, 5);

    $rectangulo = new Rectangulo($v1, $v3);

    echo $rectangulo->Dibujar();


?>