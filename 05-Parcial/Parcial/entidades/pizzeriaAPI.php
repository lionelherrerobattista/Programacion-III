<?php


    require_once "./entidades/pizza.php";
    require_once "./entidades/ventas.php";

    class PizzeriaApi
    {
        public function __construct()
        {

        }

        public static function cargarPizza($request, $response)
        {
            $args = $request->getParsedBody();
            $archivoFoto = $request->getUploadedFiles();  
            $guardo = false;

            

            if(strcasecmp($args["tipo"], "molde") == 0 || strcasecmp($args["tipo"], "piedra") == 0 &&
                strcasecmp($args["sabor"], "especial") == 0 || strcasecmp($args["sabor"], "muzza") == 0 || strcasecmp($args["sabor"], "jamon") == 0)
            {
                
                //Creo el objeto
                $ruta = "./Pizza.txt";
            
                $listaPizzas = Archivo::LeerArchivo($ruta);

                if($listaPizzas != null)
                {
                    $id = count($listaPizzas);
                }
                else
                {
                    $id = 0;
                }

                $pizza = new Pizza($id, $args["precio"], $args["tipo"], $args["cantidad"],$args["sabor"], $archivoFoto["imagenUno"], $archivoFoto["imagenDos"]);

                $guardo = true;
                

            }

            if($guardo == true)
            {
                
                Pizza::Guardarpizza($pizza);
                
                    $listapizzas = Pizza::Traerpizzas();

                    $newResponse = $response->withJson($listapizzas, 200);
                
            }
            else
            {
                $newResponse = $response->withJson("Pizza invalida", 404);
            }
            
                      
            return $newResponse;
        }

        public static function consultarPizza($request, $response, $args)
        {
            $muestroPizza = false;
            $encontro = false;
            $tipo = $args["tipo"];
            $sabor = $args["sabor"];
            $datos = array();

            $listaPizzas = Pizza::TraerPizzas();
          

            
            foreach($listaPizzas as $auxPizza)
            {
                if(strcasecmp($auxPizza->tipo, $tipo) == 0 && strcasecmp($auxPizza->sabor, $sabor) == 0)
                {
                    $muestroPizza = true;
                }

                if($muestroPizza == true)
                {     
                    $datos = "Cantidad:" . $auxPizza->cantidad;
                }
            }

            if($muestroPizza == false)
            {
                $datos = "No existe $tipo-$sabor";
            }

            $newResponse = $response->withJson($datos, 200); //codigo de respuesta
            
        
            return $newResponse; //devolver siempre Json
        }

        public static function cargarVentas($request, $response)
        {
            $args = $request->getParsedBody();

            $listaVentas = Venta::TraerVentas();

            if($listaVentas != null)
            {
                $id = count($listaVentas);
            }
            else
            {
                $id = 0;
            }

            $venta = new Venta($args["email"], $args["sabor"], $args["tipo"], $args["canitdad"], $id, 0);

            $respuesta = Venta::GuardarVenta($venta);

            return $respuesta;

        }


    }


?>