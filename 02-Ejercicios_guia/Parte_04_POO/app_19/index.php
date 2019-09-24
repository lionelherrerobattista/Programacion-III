<?php
    require_once "./clases/Rectangulo.php";
    require_once "./clases/Triangulo.php";

    $rectangulo = new Rectangulo(5, 5);
    $rectangulo->setColor("Rojo");

    $triangulo = new Triangulo(6, 6);

    $datos = $rectangulo->toString();

    echo $datos;
    echo "<br><br>";
    $rectangulo->dibujar();

    $datos = $triangulo->toString();

    echo $datos;
    echo "<br><br>";
    $triangulo->dibujar();





?>