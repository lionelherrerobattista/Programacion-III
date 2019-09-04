<?php

    function Guardar($ruta, $dato)
    {
        $ar = fopen($ruta, "a");

        fwrite($ar, json_encode($dato) . PHP_EOL);

        fclose($ar);

    }

    function Leer($ruta)
    {

        $ar = fopen($ruta, "r");
        $primeraLectura = true;

        while(!feof($ar))
        {
            if($primeraLectura)
            {
                $datos = array(fgets($ar));

                $primeraLectura = false;
            }
            else
            {
                $otroDato = array(fgets($ar));

                array_push($datos, $otroDato);
            }
       
        }

        fclose($ar);

        return $datos;
    }


?>