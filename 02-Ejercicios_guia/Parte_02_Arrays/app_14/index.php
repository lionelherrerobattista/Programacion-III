<?php

$vec1 = array();
$vec2 = array();
$vec3 = array();
$vecCombinados;
$arrayAsociativo;
$arrayIndexado;


array_push($vec1, "Perro", "Gato", "Ratón", "Araña", "Mosca");

array_push($vec2, "1986", "1996", "2015", "78", "86");

array_push($vec3, "php", "mysql", "html5", "typescript", "ajax");

$arrayAsociativo = array("vec1"=>$vec1, "vec2"=>$vec2, "vec3"=>$vec3);

foreach($arrayAsociativo as $k=>$valor)
{
    print("$k:<br>");
    var_dump($valor);
    echo "<br>";
}

$arrayIndexado = array($vec1, $vec2, $vec3);

foreach($arrayAsociativo as $valor)
{
    
    var_dump($valor);
    echo "<br>";
}






?>