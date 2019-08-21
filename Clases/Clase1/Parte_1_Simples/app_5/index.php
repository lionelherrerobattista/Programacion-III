<?php
    $a = 5;
    $b = 1;
    $c = 5;

    if(($a > $b && $a < $c) || ($a < $b && $a > $c ) )//si a está en el medio
    {
        echo $a;
    }
    else if(($b > $a && $b < $c) || ($b < $a && $b > $c))//b está en el medio
    {
        echo $b;        
    }
    else if(($c > $a && $c < $b) || ($c < $a && $c > $b))//si c está en el medio
    {
        echo $c;
    }
    else
    {
        echo "No hay valor en el medio";
    }
?>