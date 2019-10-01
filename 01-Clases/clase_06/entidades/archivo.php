<?php
    class Archivo
    {
        public static function GuardarArchivoTemporal($archivo, $destino, $patente)
        {
            
            $origen = $archivo["archivo"]->getClientFileName();

            $fecha = new DateTime();

            $extension = pathinfo($archivo["archivo"]->getClientFileName(), PATHINFO_EXTENSION);

            $destino = $destino . $patente . "-" . $fecha->format("d-m-Y-Hi") . "." . $extension;

            $archivo["archivo"]->moveTo($destino);

            return $destino;
        }


        public static function BorrarPersona($ruta, $nroLegajo)
        {
            
            
            if(file_exists($ruta))
            {
                $lista = Archivo::LeerArchivo($ruta);

                if(count($lista) > 1)
                {
                    for($i = 0; $i < count($lista); $i++)
                    {
                        $objeto = $lista[$i];

                        if($objeto->legajo == $nroLegajo)
                        {
                            unlink($lista[$i]->rutaFoto);

                            unset($lista[$i]);//elimino elemento de la lista

                            array_values($lista); //indices correlativos

                            break;
                        }

                    }

                    //guardo los datos de nuevo en el archivo
                    
                    unlink($ruta);//borro el archivo anterior

                    foreach($lista as $objeto)
                    {

                        Archivo::GuardarPersona($ruta, $objeto);
                    }

                }
                else if($lista[0]->legajo == $nroLegajo)
                {
                    unlink($lista[$i]->rutaFoto);

                    unlink($ruta);
                    
                }

            }
            else
            {
                echo "Archivo no encontrado <br>";
            }          
            
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

        public static function MostrarPersonas($ruta)
        {

            $datos = "";
            $lista = Archivo::LeerArchivo($ruta);

            if($lista != null)
            {
                for($i = 0; $i < count($lista); $i++)
                {
                    $datos = $datos . "Persona " . ($i+1) . "<br>";

                    $objeto = $lista[$i];

                    $datos = $datos . Alumno::MostrarAlumno($objeto);


                }
            }

            return $datos;
         

        }

    }





?>
