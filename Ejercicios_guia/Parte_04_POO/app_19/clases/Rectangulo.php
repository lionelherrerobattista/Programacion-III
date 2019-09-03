<?php
    require_once "FiguraGeometrica.php";

    class Rectangulo extends FiguraGeometrica
    {
        private $_ladoUno;
        private $_ladoDos;

        public function __construct($l1, $l2)
        {
            $this->_ladoUno = $l1;
            $this->_ladoDos = $l2;
            $this->calcularDatos();
        }

        protected function calcularDatos()
        {
            $this->_perimetro = 2 * $this->_ladoUno + 2 * $this->_ladoDos;
            $this->_superficie = $this->_ladoUno * $this->_ladoDos;
        }

        public function dibujar()
        {

            for($i = 1; $i <= $this->_ladoUno; $i++)
            {
                for($j = 1; $j <= $this->_ladoDos; $j++)
                {
                    echo "*";
                }

                echo "<br>";
            }
        }

        public function toString()
        {
            $datos = "Lado 1: " . $this->_ladoUno;
            $datos = $datos . "<br>Lado 2: " . $this->_ladoDos;
            $datos = $datos . "<br>". parent::toString();


            return $datos;

        }
    }

?>