<?php
    class Archivo
    {
        public static function GuardarArchivoTemporal($archivo, $destino)
        {
            
            $origen = $archivo["tmp_name"];//ubicación temporal
            $fecha = new DateTime();//timestamp para no repetir nombre
            


            //otro metodo: $_FILES["archivo"]["tmp_name"];

            //busco la extensión del archivo:
            $extension = pathinfo($_FILES["archivo"]["name"], PATHINFO_EXTENSION);

            $destino = $destino . "archivo" . $fecha->getTimeStamp() . "." . $extension;

            //lo saco de la carpeta temporal:
            move_uploaded_file($origen, $destino);

            return $destino;
        }



        public static function Borrar($ruta, $nroLegajo)
        {
            $datos = Archivo::Leer($ruta);

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

                unlink("objetos.json");//borro el archivo anterior

                Archivo::Guardar($ruta, $objeto);
            }
        }

        public static function Modificar($ruta, $elementoModificado)
        {
            $datos = Archivo::Leer($ruta);

            for($i = 0; $i < count($datos); $i++)
            {
                $objeto = $datos[$i];

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

                Archivo::Guardar($ruta, $objeto);
            }
        }

        public static function Guardar($ruta, $dato)
        {
            $ar = fopen($ruta, "a");

            fwrite($ar, json_encode($dato) . PHP_EOL);

            fclose($ar);

        }

        public static function Leer($ruta)
        {

            $ar = fopen($ruta, "r");
            $datos = array();//array donde voy a guardar los objetos



            while(!feof($ar))
            {
                $objeto = json_decode(fgets($ar));//Se guarda como un objeto

                if($objeto != null)
                {
                    array_push($datos, $objeto);
                }


            }

            fclose($ar);

            return $datos;
        }

        public static function Mostrar($ruta)
        {
          //mostrar

          $datos = Archivo::Leer($ruta);


          for($i = 0; $i < count($datos); $i++)
          {
              echo "Persona " . ($i+1) . "<br>";

              $objeto = $datos[$i];

              echo "Nombre: " . ucwords($objeto->nombre) . "<br>";
              echo "Legajo: "  . $objeto->legajo  . "<br><br>";
              echo "<img src='" . $objeto->rutaFoto . "'/>";

              //También:
              // foreach($datos[$i] as $clave=>$valor)
              // {
              //      echo $clave . ": " . $valor . "<br>";
              // }

          }

        }

    }





?>
