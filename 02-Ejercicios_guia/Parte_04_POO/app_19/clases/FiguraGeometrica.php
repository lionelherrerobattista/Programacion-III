<?php

    abstract class FiguraGeometrica
    {
        protected $_color;
        protected $_perimetro;
        protected $_superficie;

        public function __construct()
        {

        }

        protected function calcularDatos()
        {

        }

        abstract function dibujar();

        public function getColor()
        {
            return $this->_color;
        }

        public function setColor($color)
        {
            $this->_color = $color;

        }

        public function toString()
        {
            $datos = "Color: ". $this->getColor();
            $datos = $datos . "<br>Perímetro: ". $this->_perimetro;
            $datos = $datos . "<br>Superficie: ". $this->_superficie;

            return $datos;
        }
    }

?>