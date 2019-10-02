<?php
    class Venta
    {
        public $usuario;
        public $sabor;
        public $tipo;
        public $cantidad;
        public $precio;
        public $id;

        public function __construct($usuario, $sabor, $tipo, $cantidad, $id, $precio)
        { 
          
            $this->usuario = $usuario;
            $this->sabor = $sabor;
            $this->tipo = $tipo;
            $this->cantidad = $cantidad;
            $this->id = $id;
            $this->precio = $precio;

        }

        public static function GuardarVenta($venta)
        {
            $ruta = "./Ventas.txt";
            $combinacionRepetida = false;
            $guardo = false;

            $listaVentas = Venta::TraerVentas();
            $listaPizzas = Pizza::TraerPizzas();

            foreach($listaPizzas as $auxPizza)
            {
                if(strcasecmp($auxPizza->tipo, $venta->tipo) == 0 && strcasecmp($auxPizza->sabor, $venta->sabor) == 0)
                {
                    if(($auxPizza->cantidad - $venta->cantidad) > 0)
                    {
                        $guardo = true;
                    }
                    
                }
            }

            if($guardo == true)
            {
                Archivo::GuardarUno($ruta, $venta);
                
                $newResponse = $response->withJson($venta, 200);
            }
            else
            {
                $newResponse = $response->withJson("No se pudo vender", 200);
            }


            return $newResponse;
        } 

        public static function TraerVentas()
        {
            $ruta = "./Ventas.txt";
            
            $listaVentas = Archivo::LeerArchivo($ruta);

            if($listaVentas == null)
            {
                $listaVentas = "Error al traer los datos";
            }

            return $listaVentas;
        }
    }


?>