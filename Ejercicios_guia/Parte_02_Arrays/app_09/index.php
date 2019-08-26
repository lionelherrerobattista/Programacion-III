<?php
    
    $numeros;//array de números
    $totalNumeros = 0;
    $promedio;

    for ($i = 0; $i < 5; $i++)
    {
        $numeros[$i] = rand(1, 10);
        $totalNumeros += $numeros[$i];
    }
        
    

    $promedio = $totalNumeros / $i;

    var_dump($numeros);

    if($promedio == 6)
    {
        echo "<br>","El promedio es igual a 6.";
    }
    else if($promedio > 6)
    {
        echo "<br>","El promedio es mayor a 6.";
        
    }
    else
    {
        echo "<br>","El promedio es menor a 6.";
        
    }

    echo "<br>", "Promedio: ", $promedio;


    




?>