<?php

    class Archivo
    {

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
      
        public static function GuardarArchivoTemporal($archivo, $destino, $legajo)
        {
            $origen = $archivo->getClientFileName();
            
            $fecha = new DateTime();
            $fecha = $fecha->setTimezone(new DateTimeZone('America/Argentina/Buenos_Aires'));
            $fecha = $fecha->format("d-m-Y-His");

            $extension = pathinfo($archivo->getClientFileName(), PATHINFO_EXTENSION);

            $destino = "$destino-$legajo-$fecha.$extension";

            $archivo->moveTo($destino);

            return $destino;
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

        public static function HacerBackup($ruta, $elementoAModificar)
        {
      
            $fecha = new DateTime();//timestamp para no repetir nombre
            $fecha = $fecha->setTimezone(new DateTimeZone('America/Argentina/Buenos_Aires'));
            $fecha = $fecha->format("d-m-Y-Hi");
            
            $extension = pathinfo($elementoAModificar->fotoUno, PATHINFO_EXTENSION);

            $nombreBackupUno = "./img/backup/backupImgUno$elementoAModificar->legajo-$fecha.$extension";
            $nombreBackupDos = "./img/backup/backupImgDos$elementoAModificar->legajo-$fecha.$extension";

            //guardo la foto en la carpeta de backup:
            copy($elementoAModificar->fotoUno, $nombreBackupUno);
            copy($elementoAModificar->fotoDos, $nombreBackupDos);

            unlink($elementoAModificar->fotoUno);
            unlink($elementoAModificar->fotoDos);

        }
    
    }
?>
