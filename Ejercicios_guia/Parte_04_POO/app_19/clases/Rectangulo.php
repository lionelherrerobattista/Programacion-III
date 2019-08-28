<?php
    require "./FiguraGeometrica.php";

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

            for($i = 0; $i <= $this->_ladoUno; $i++)
            {
                for($j = 0; $j <= $this->_ladoDos; $j++)
                {

                }
            }
        }

        public function toSting()
        {
            $datos = parent::toString() . "Lado 1: " . $this->_ladoUno;
            $datos = $datos . "Lado 2: " . $this->_ladoDos;

            return $datos;

        }
    }

?>