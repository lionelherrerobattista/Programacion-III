<?php

    function ValidarPalabra($palabra, $max)
    {
        $palabrasValidas = array("Recuperatorio", "Parcial", "Programacion");

        if(strlen($palabra) <= $max)
        {
            foreach($palabrasValidas as $valor)
            {
                if($palabra == $valor)
                {
                    return 1;
                }
            }
        }


        return 0;
    }

    $palabraPrueba = "Programacion";

    if(ValidarPalabra($palabraPrueba, strlen($palabraPrueba)))
    {
        echo "validada";

    }   
    else
    {
        echo "inválida";
    } 

?>