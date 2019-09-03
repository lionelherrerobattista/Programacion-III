<?php

    function Guardar($ruta, $dato)
    {
        $ar = fopen($ruta, "w");

        fwrite($ar, json_encode($dato));

        fclose($ar);

    }

    function Leer($ruta)
    {

        $ar = fopen($ruta, "r");

        $dato = fread($ar, filesize($ruta));

        fclose($ar);

        return $dato;
    }


?>