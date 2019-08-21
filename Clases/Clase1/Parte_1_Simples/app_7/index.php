<?php
    $mes = (int)date("m");

    echo "Fecha de hoy: ", date("d/m/Y");
    echo "<br>";
    echo "Estación: ";

    switch($mes)
    {
        case $mes >= 1 && $mes <= 3://verano
            if($mes == 3 && (int)date("d") >= 21)
            {
                echo "Otoño";
            }
            else
            {
                echo "Verano";
            }
            
            break;
        case $mes >= 4 && $mes <= 6://otoño
            if($mes == 6 && (int)date("d") >= 21)
            {
                echo "Invierno";
            }
            else
            {
                echo "Otoño";
            }
            
            break;
        case $mes >= 7 && $mes <= 9://invierno
            if($mes == 9 && (int)date("d") >= 21)
            {
                echo "Primavera";
            }
            else
            {
                echo "Invierno";
            }
            break;
        case $mes >= 10 && $mes <= 12://primavera
            if($mes == 12 && (int)date("d") >= 21)
            {
                echo "Verano";
            }
            else
            {
                echo "Primavera";
            }
            break;
    }
?>