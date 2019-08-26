<?php
    function EsPar($numero)
    {
        if($numero % 2 == 0 && $numero != 0)
        {
            return true;
        }
        else
        {
            return false;

        }
    }

    //Funcion EsImpar, reutilizo código
    function EsImpar($numero)
    {
        return !(EsPar($numero));
    }

    if(EsPar(15))
    {
        echo "Es par";
    }
    else
    {
        echo "No es par";
    }

    echo "<br>";

    if(EsImpar(15))
    {
        echo "Es impar";
    }
    else
    {
        echo "No es impar";
    }
    
?>