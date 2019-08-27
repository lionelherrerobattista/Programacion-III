<?php
    require "./FiguraGeometrica.php";

    class Rectangulo extends FiguraGeometrica
    {
        private $_ladoUno;
        private $_ladoDos;

        public function __construct($l1, $l2)
        {
            parent::calcularDatos();
        }

        public function dibujar()
        {

        }

        public function toSting()
        {
            $datos = parent::toString() . "Lado 1: " . $this->l1;
            $datos = $datos . "Lado 2: " . $this->l2;

            return $datos;

        }
    }

?>