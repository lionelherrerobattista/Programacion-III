<?php
    
    require_once "FiguraGeometrica.php";

    class Triangulo extends FiguraGeometrica
    {
        
        private $_altura;
        private $_base;

        public function __construct($b, $h)
        {
            $this->_base = $b;
            $this->_altura = $h;

            $this->calcularDatos();
        }

        protected function calcularDatos()
        {
            $this->_perimetro = 3 * $this->_base;
            $this->_superficie = (float)($this->_base * $this->_altura) / 2;

        }

        public function dibujar()
        {
            $puntoMedio = (int)($this->_base / 2);
            $contadorAsterisco = 1;
            

            for($i = $this->_altura; $i > 0; $i--)
            {
                for($j = $i - 1; $j >= 0; $j--)
                {
                    echo ".";
                }

                for($k = $contadorAsterisco; $k > 0; $k--)
                {
                    echo "*";
                }

                
                echo "<br>";

                $contadorAsterisco++;
         
            }

        }

        public function toString()
        {
            $datos = "Base: " . $this->_base;
            $datos = $datos . "<br>Altura: " . $this->_altura;
            $datos = $datos . "<br>". parent::toString();


            return $datos;

        }
    }
    



?>