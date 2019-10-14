<?php

    

    class Archivo
    {
        public static function GuardarArchivoTemporal($archivo, $destino, $nombre)
        {
            
            $origen = $archivo->getClientFileName();

            $fecha = new DateTime();

            $extension = pathinfo($archivo->getClientFileName(), PATHINFO_EXTENSION);

            $destino = $destino . $nombre  . "." . $extension;

            $archivo->moveTo($destino);

            return $destino;
        }

        public static function HacerBackup($ruta, $elementoAModificar)
        {
      
            $fecha = new DateTime();//timestamp para no repetir nombre
    
            $extension = pathinfo($elementoAModificar->rutaFoto, PATHINFO_EXTENSION);

            $nombreBackup = "./backupFotos/backup" . $elementoAModificar->patente . "-" . $fecha->format("d-m-Y-Hi") . "." . $extension;

            //guardo la foto en la carpeta de backup:
            copy($elementoAModificar->rutaFoto, $nombreBackup);

            unlink($elementoAModificar->rutaFoto);

        }

        public static function CrearLog($caso, $ip)
        {
            $ruta = "./info.log";
            $fecha = new DateTime();

            $guardo = false;
            
            $log = new Log($caso, $fecha->format("d-m-Y-H:i:s"), $ip);

            $archivo = fopen($ruta, "a");

            fwrite($archivo, json_encode($log) . PHP_EOL);

            fclose($archivo);

            if(file_exists($ruta))
            {
                $guardo = true;
            }

            return $guardo;
        }

        public static function GuardarTodos($ruta, $lista)
        {
            $guardo = false;
            
            $archivo = fopen($ruta, "w");

            foreach($lista as $objeto)
            {
                fwrite($archivo, json_encode($objeto) . PHP_EOL);
            }

            fclose($archivo);

            if(file_exists($ruta))
            {
                $guardo = true;
            }

            return $guardo;
        }

        public static function GuardarUno($ruta, $dato)
        {
            $guardo = false;
            
            $archivo = fopen($ruta, "a");

            fwrite($archivo, json_encode($dato) . PHP_EOL);

            fclose($archivo);

            if(file_exists($ruta))
            {
                $guardo = true;
            }

            return $guardo;
        
        }

        public static function LeerArchivo($ruta)
        {
            $lista = array();

            if(file_exists($ruta))
            {             
                $archivo = fopen($ruta, "r");           

                while(!feof($archivo))
                {
                    $objeto = json_decode(fgets($archivo));

                    if($objeto != null)
                    {
                        array_push($lista, $objeto);
                    }
                }
                fclose($archivo);        
            }

            return $lista;
        }
    }
?>
