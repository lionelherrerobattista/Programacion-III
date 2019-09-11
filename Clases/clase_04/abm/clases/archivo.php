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
                $datos = Archivo::Leer($ruta);

                if(count($datos) > 1)
                {
                    for($i = 0; $i < count($datos); $i++)
                    {
                        $objeto = $datos[$i];

                        if($objeto->legajo == $nroLegajo)
                        {
                            unlink($datos[$i]->rutaFoto);
                            unset($datos[$i]);
                            array_values($datos); //indices correlativos
                            break;
                        }

                    }

                    //guardo los datos de nuevo en el archivo
                    
                    unlink($ruta);//borro el archivo anterior

                    foreach($datos as $objeto)
                    {

                        Archivo::GuardarPersona($ruta, $objeto);
                    }

                }
                else if($datos[0]->legajo == $nroLegajo)
                {
                    unlink($datos[$i]->rutaFoto);
                    
                    unlink($ruta);
                    
                }

            }
            else
            {
                echo "Archivo no encontrado <br>";
            }          
            
        }

        public static function ModificarPersona($ruta, $elementoModificado)
        {
            if(file_exists($ruta))
            {
                $datos = Archivo::Leer($ruta);

                

                $fecha = new DateTime();//timestamp para no repetir nombre

                for($i = 0; $i < count($datos); $i++)
                {
                    $objeto = $datos[$i];

                    if($objeto->legajo == $elementoModificado["legajo"])
                    {
                        $extension = pathinfo($objeto->rutaFoto, PATHINFO_EXTENSION);

                        $nombreBackup = "./backupFotos/backup" . $fecha->getTimeStamp() . "." . $extension;
    
                        //guardo la foto en la carpeta de backup:
                        copy($objeto->rutaFoto, $nombreBackup);
    
                        unlink($objeto->rutaFoto);

                        $datos[$i] = $elementoModificado;

                        var_dump($datos[$i]);

                        break;
                    }
                }

                unlink("objetos.json");

                //guardo los datos de nuevo en el archivo
                for($i= 0 ; $i < count($datos); $i++)
                {
                    $objeto = $datos[$i];

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

        public static function Leer($ruta)
        {

            $datos = array();

            if(file_exists($ruta))
            {
                
                $archivo = fopen($ruta, "r");
                
                

                while(!feof($archivo))
                {
                    $objeto = json_decode(fgets($archivo));

                    if($objeto != null)
                    {
                        array_push($datos, $objeto);
                    }


                }

                fclose($archivo);
            
            }

            return $datos;
        }

        public static function MostrarPersonas($ruta)
        {

          $datos = Archivo::Leer($ruta);

          if($datos != null)
          {
            for($i = 0; $i < count($datos); $i++)
            {
                echo "Persona " . ($i+1) . "<br>";
  
                $objeto = $datos[$i];
  
                echo "Nombre: " . ucwords($objeto->nombre) . "<br>";
                echo "Apellido: " . ucwords($objeto->apellido) . "<br>";
                echo "Legajo: "  . $objeto->legajo  . "<br><br>";
                echo "<img src='" . $objeto->rutaFoto . "'/><br>";
  
  
            }
          }
         

        }

    }





?>
