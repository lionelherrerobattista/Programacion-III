<?php

    InvertirPalabra("CASA");

    function InvertirPalabra($palabra)
    {
        $palabraInvertida = "";

        for($i = strlen($palabra)-1; $i >= 0; $i--)
        {
            $palabraInvertida = $palabraInvertida.$palabra[$i];
        }

        echo $palabraInvertida;
    }
?>