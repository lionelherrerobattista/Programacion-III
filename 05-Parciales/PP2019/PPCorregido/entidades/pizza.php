<?php

class Pizza
{
    public $id;
    public $precio;
    public $tipo;
    public $cantidad;
    public $sabor;
    public $imagenUno;
    public $imagenDos;

    public function __construct($precio, $tipo, $cantidad, $sabor, $imagenes)
    {
        $this->id = Pizza::CrearIdAutoincremental();
        $this->precio = $precio;
        $this->tipo = $tipo;
        $this->cantidad = $cantidad;
        $this->sabor = $sabor;

        $this->imagenUno = Archivo::GuardarArchivoTemporal($imagenes["imagenUno"], "./images/pizzas/foto1", $tipo, $sabor);
        $this->imagenDos = Archivo::GuardarArchivoTemporal($imagenes["imagenDos"], "./images/pizzas/foto2", $tipo, $sabor);

    }

    public static function CrearIdAutoincremental()
    {
        $listaPizzas = Pizza::TraerPizzas();

        if($listaPizzas != null)
        {
            $id = count($listaPizzas) + 1;
        }
        else
        {
            $id = 1;
        }

        return $id;
    }

    public static function GuardarPizza($pizza)
    {
        $ruta = "./Pizza.txt";
        $pizzaGuardada = false;       


        Archivo::GuardarUno($ruta, $pizza);

        $guardo = true;
        
          
        return $guardo;
    }
    
    public static function ModificarPizza($elementoModificado)
    {
        $ruta = "./Pizza.txt";

        $listaPizzas = Pizza::TraerPizzas();

        for($i= 0 ; $i < count($listaPizzas); $i++)
        {
            $pizzaAux = $listaPizzas[$i];

            //Modifico
            if($pizzaAux->id == $elementoModificado->id)
            {
                
                $listaPizzas[$i] = $elementoModificado;

                Archivo::GuardarTodos($ruta, $listaPizzas);

                break;
            }
        }
    }

    public static function ModificarPizzaConFoto($elementoModificado)
    {
        $ruta = "./Pizza.txt";

        $listaPizzas = Pizza::TraerPizzas();

        for($i= 0 ; $i < count($listaPizzas); $i++)
        {
            $pizzaAux = $listaPizzas[$i];
            //Modifico
            if($pizzaAux->id == $elementoModificado->id)
            {
                Archivo::HacerBackup($ruta, $pizzaAux);

                //reemplazo
                $listaPizzas[$i] = $elementoModificado;

                Archivo::GuardarTodos($ruta, $listaPizzas);
                
                break;
            }
        }
    }

    public static function BorrarPizza($id)
    {
        $ruta = "./Pizza.txt";

        $listaPizzas = Pizza::TraerPizzas();
        
        if($listaPizzas != null)
        {
            if(count($listaPizzas) > 1)
            {
                for($i = 0; $i < count($listaPizzas); $i++)
                {
                    $pizzaAux = $listaPizzas[$i];

                    if($pizzaAux->id == $id)
                    {

                        Archivo::HacerBackup($ruta, $pizzaAux);
                       
                        unset($listaPizzas[$i]);//elimino elemento de la listaPizzas

                        array_values($listaPizzas); //indices correlativos

                        break;
                    }
                }
                
                Archivo::GuardarTodos($ruta, $listaPizzas);
            }
            else if($listaPizzas[0]->id == $id)
            {
                Archivo::HacerBackup($ruta, $listaPizzas[0]);

                unlink($ruta);
                
            }
        }
    }


    public static function TraerPizzas()
    {
        $ruta = "./Pizza.txt";
        
        $listaPizzas = Archivo::LeerArchivo($ruta);
        
        return $listaPizzas;
    }

}


?>