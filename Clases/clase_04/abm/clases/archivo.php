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
            $datos = Archivo::Leer($ruta);
            
            if(count($datos) > 1)
            {
                for($i = 0; $i < count($datos); $i++)
                {
                    $objeto = $datos[$i];

                    if($objeto->legajo == $nroLegajo)
                    {
                        unset($datos[$i]);
                        array_values($datos); //indices correlativos
                        break;
                    }

                }

                //guardo los datos de nuevo en el archivo
                foreach($datos as $objeto)
                {
                    // $objeto = $datos[$i];

                    unlink($ruta);//borro el archivo anterior

                    Archivo::GuardarPersona($ruta, $objeto);
                }

            }
            else
            {
                unlink($ruta);
                
            }



            
        }

        public static function ModificarPersona($ruta, $elementoModificado)
        {
            $datos = Archivo::Leer($ruta);

            $fecha = new DateTime();//timestamp para no repetir nombre

            for($i = 0; $i < count($datos); $i++)
            {
                $objeto = $datos[$i];

                $extension = pathinfo($objeto->rutaFoto, PATHINFO_EXTENSION);

                $nombreBackup = "./backupFotos/backup" . $fecha->getTimeStamp() . "." . $extension;

                //guardo la foto en la carpeta de backup:
                copy($objeto->rutaFoto, $nombreBackup);

                unlink($objeto->rutaFoto);

                if($objeto->legajo == $elementoModificado["legajo"])
                {
                    $datos[$i] = $elementoModificado;
                }
            }

            //guardo los datos de nuevo en el archivo
            for($i= 0 ; $i < count($datos); $i++)
            {
                $objeto = $datos[$i];

                unlink("objetos.json");

                Archivo::GuardarPersona($ruta, $objeto);
            }
        }

        public static function GuardarPersona($ruta, $dato)
        {
            if(file_exists($ruta))
            {
                $ar = fopen($ruta, "a");

                fwrite($ar, json_encode($dato) . PHP_EOL);

                fclose($ar);
            }
            

        }

        public static function Leer($ruta)
        {

            if(file_exists($ruta))
            {
                if($archivo != false)
                {

                    $archivo = fopen($ruta, "r");
                    
                    $datos = array();

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
