<?php

    
    class Pizza
    {
       
        public $idPizza;
        public $precio;
        public $tipo;
        public $cantidad;
        public $sabor;
        public $rutaImagenUno;
        public $rutaImagenDos;      

        public function __construct($id, $precio, $tipo, $cantidad, $sabor, $imagenUno, $imagenDos)
        { 
          
            $this->idPizza = $id;
            $this->precio = $precio;
            $this->tipo = $tipo;
            $this->cantidad = $cantidad;
            $this->sabor = $sabor;
            
            $rutaFotoUno = Archivo::GuardarArchivoTemporal($imagenUno, "./images/pizzas/", "$tipo-$sabor"."1");

            $this->rutaImagenUno = $rutaFotoUno;

            $rutaFotoDos = Archivo::GuardarArchivoTemporal($imagenDos, "./images/pizzas/", "$tipo-$sabor"."2");

            $this->rutaImagenDos = $rutaFotoDos;
        }

        public static function TraerPizzas()
        {
            $ruta = "./Pizza.txt";
            
            $listaPizzas = Archivo::LeerArchivo($ruta);

            if($listaPizzas == null)
            {
                $listaPizzas = "Error al traer los datos";
            }

            return $listaPizzas;
        }


        public static function GuardarPizza($pizza)
        {
            $ruta = "./Pizza.txt";
            $combinacionRepetida = false;
            $guardo = false;

            $listaPizzas = Pizza::TraerPizzas();

            //Verif si está repetida
            if(count($listaPizzas) > 0)
            {
                $listaPizzas = Pizza::TraerPizzas();
                
                foreach($listaPizzas as $auxPizza)
                {
                    if(strcasecmp($auxPizza->tipo, $pizza->tipo) == 0 &&
                         strcasecmp($auxPizza->sabor, $pizza->sabor) == 0)
                    {
                        $combinacionRepetida = true;
                        break;
                    }
                }
            }
                 
            //guardo
            if($combinacionRepetida == false)
            {
                Archivo::GuardarUno($ruta, $pizza);
                $guardo = true;
            }
            
            return $guardo;
        } 
    }


?>