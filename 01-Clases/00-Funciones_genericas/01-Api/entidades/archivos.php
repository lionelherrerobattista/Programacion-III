<?php
    class Archivos
    {

        //atributos con ruta de archivos y backups?

        public static function GuardarArchivoTemporal($archivo, $destino)
        {
            
            $origen = $archivo["tmp_name"];
            $fecha = new DateTime();

            $extension = pathinfo($archivo["name"], PATHINFO_EXTENSION);

            $destino = $destino . "archivo" . $fecha->getTimeStamp() . "." . $extension;

            move_uploaded_file($origen, $destino);

            return $destino;
        }


        public static function BorrarElemento($ruta, $identificador)
        {
            $mensaje = "Registro no encontrado <br>";
            
            if(file_exists($ruta))
            {
                $lista = Archivo::LeerArchivo($ruta);

                if(count($lista) > 1)
                {
                    for($i = 0; $i < count($lista); $i++)
                    {
                        $objeto = $lista[$i];

                        if($objeto->identificador == $identificador)
                        {
                            unlink($lista[$i]->rutaFoto);//elimino el archivo linkeado

                            unset($lista[$i]);//elimino elemento de la lista

                            array_values($lista); //mantengo indices correlativos

                            break;
                        }

                    }

                    //guardo los datos de nuevo en el archivo
                    
                    unlink($ruta);//borro el archivo anterior

                    foreach($lista as $objeto)
                    {

                        Archivo::GuardarElemento($ruta, $objeto);
                    }

                    $mensaje = "Registro eliminado <br>";

                }
                else if($lista[0]->identificador == $identificador)
                {
                    unlink($lista[$i]->rutaFoto);

                    unlink($ruta);

                    $mensaje = "Registro eliminado <br>";
                    
                }

            }
            
            
            return $mensaje;
            
        }

        public static function ModificarElemento($ruta, $elementoModificado)
        {
            $mensaje = "Error al modificar elemento<br>";

            if(file_exists($ruta))
            {
                $lista = Archivo::LeerArchivo($ruta);

                $fecha = new DateTime();//timestamp para no repetir nombre

                for($i = 0; $i < count($lista); $i++)
                {
                    $objeto = $lista[$i];

                    if($objeto->identificador == $elementoModificado["identificador"])
                    {
                        $extension = pathinfo($objeto->rutaFoto, PATHINFO_EXTENSION);

                        $nombreBackup = "./backupFotos/backup" . $fecha->getTimeStamp() . "." . $extension;
    
                        //guardo la foto en la carpeta de backup:
                        copy($objeto->rutaFoto, $nombreBackup);
    
                        unlink($objeto->rutaFoto);//borro foto anterior

                        $lista[$i] = $elementoModificado;//guardo el elemento

                        break;
                    }
                }

                unlink($ruta);

                //hacer funcion GuardarLista
                //guardo los datos de nuevo en el archivo
                for($i= 0 ; $i < count($lista); $i++)
                {
                    $objeto = $lista[$i];

                    Archivo::GuardarElemento($ruta, $objeto);
                }

                $mensaje = "Elemento modificado<br>";
            }
            
            return $mensaje;

        }

        public static function GuardarElemento($ruta, $dato)
        {
            
            $archivo = fopen($ruta, "a");

            fwrite($archivo, json_encode($dato) . PHP_EOL);

            fclose($archivo);
        
            

        }

        public static function LeerArchivo($ruta)
        {

            $lista;

            if(file_exists($ruta))
            {
                $lista = array();
                
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

        public static function MostrarTodos($ruta)
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
            else
            {
                $datos = "Error al leer archivo";
            }

            return $datos;
         

        }

    }





?>
