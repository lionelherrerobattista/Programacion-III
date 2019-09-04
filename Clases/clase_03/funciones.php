<?php
 
    function Borrar($ruta, $nroLegajo)
    {
        $datos = Leer($ruta);
        
        foreach($datos as $clave=>$valor)
        {
            if($clave == "legajo" && $nroLegajo == $valor)
            {
                
            }

        }

        

    }

    function Guardar($ruta, $dato)
    {
        $ar = fopen($ruta, "a");

        fwrite($ar, json_encode($dato) . PHP_EOL);

        fclose($ar);

    }

    function Leer($ruta)
    {

        $ar = fopen($ruta, "r");
        $datos = array();

        while(!feof($ar))
        {
            
                $otroDato = array(json_decode(fgets($ar)));

                array_push($datos, $otroDato);
       
        }

        fclose($ar);

        return $datos;
    }


?>