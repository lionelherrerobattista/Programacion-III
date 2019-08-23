<?php

    $numerosImpares;//primeros 10 impares
    $numero = 1;
    $i = 0;

    do
    {
        if($numero % 2 != 0)
        {
            $numerosImpares[$i] = $numero;
            $i++;
        }
        
        $numero++;
        

    }while(sizeof($numerosImpares) < 10);

    var_dump($numerosImpares);
    echo "<br><br>", "Estructura for: ", "<br>";

    for($i = 0; $i < count($numerosImpares); $i++)
    {
        echo $numerosImpares[$i], "<br>";
    }

    echo "<br>", "Estructura while: ", "<br>";

    $i = 0;

    while($i < 10)
    {
        echo $numerosImpares[$i], "<br>";
        $i++;
    }

    echo "<br>", "Estructura foreach: ", "<br>";
    foreach( $numerosImpares as $numero)
    {
        echo $numero, "<br>";
    }
?>