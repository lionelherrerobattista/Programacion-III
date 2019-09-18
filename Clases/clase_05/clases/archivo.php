<?php
    class Archivo
    {
        public static function GuardarArchivoTemporal($archivo, $destino)
        {
            
            $origen = $archivo["tmp_name"];
            $fecha = new DateTime();

            $extension = pathinfo($_FILES["archivo"]["name"], PATHINFO_EXTENSION);

            $destino = $destino . "archivo" . $fecha->getTimeStamp() . "." . $extension;

            move_uploaded_file($origen, $destino);

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
                            // unlink($lista[$i]->rutaFoto);

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
                    // unlink($lista[$i]->rutaFoto);

                    unlink($ruta);
                    
                }

            }
            else
            {
                echo "Archivo no encontrado <br>";
            }          
            
        }

        public static function ModificarAlumno($ruta, $elementoModificado)
        {
            if(file_exists($ruta))
            {
                $lista = Archivo::LeerArchivo($ruta);

                // $fecha = new DateTime();//timestamp para no repetir nombre

                for($i = 0; $i < count($lista); $i++)
                {
                    $objeto = $lista[$i];

                    if($objeto->legajo == $elementoModificado->legajo)
                    {
                        // $extension = pathinfo($objeto->rutaFoto, PATHINFO_EXTENSION);

                        // $nombreBackup = "./backupFotos/backup" . $fecha->getTimeStamp() . "." . $extension;
    
                        //guardo la foto en la carpeta de backup:
                        // copy($objeto->rutaFoto, $nombreBackup);
    
                        // unlink($objeto->rutaFoto);

                        $lista[$i] = $elementoModificado;

                        

                        break;
                    }
                }

                unlink($ruta);

                //guardo los datos de nuevo en el archivo
                for($i= 0 ; $i < count($lista); $i++)
                {
                    $objeto = $lista[$i];

                    Archivo::GuardarPersona($ruta, $objeto);
                }
            }
            
        }

        public static function GuardarPersona($ruta, $dato)
        {
            
            $archivo = fopen($ruta, "a");

            fwrite($archivo, json_encode($dato) . PHP_EOL);

            fclose($archivo);
        
            

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
