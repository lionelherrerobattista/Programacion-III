<?php

$vec1 = array();
$vec2 = array();
$vec3 = array();
$vecCombinados;

array_push($vec1, "Perro", "Gato", "Ratón", "Araña", "Mosca");

array_push($vec2, "1986", "1996", "2015", "78", "86");

array_push($vec3, "php", "mysql", "html5", "typescript", "ajax");

$vecCombinados = array_merge($vec1, $vec2, $vec3);

echo "Arrays combinados:<br>";

foreach($vecCombinados as $valor)
{
    echo $valor, "<br>";
}
