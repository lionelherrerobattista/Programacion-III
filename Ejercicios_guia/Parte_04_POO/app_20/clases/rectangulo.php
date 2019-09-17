<?php
    require_once "./clases/punto.php";
    

    class Rectangulo
    {
        private $_vertice1;
        private $_vertice2;
        private $_vertice3;
        private $_vertice4;
        public $area;
        public $ladoDos;
        public $ladoUno;
        public $perimetro;

        public function __construct($v1, $v3)
        {
            $this->_vertice1 = $v1;
            $this->_vertice3 = $v3;

            $this->_vertice2 = new Punto($v1->GetX(), $v3->GetY());
            $this->_vertice4 = new Punto($v3->GetX(), $v1->GetY());

            $this->ladoUno = $this->_vertice4->GetX() - $this->_vertice1->GetX();
            $this->ladoDos = $this->_vertice2->GetY() - $this->_vertice1->GetY();

            $this->area = $this->ladoUno * $this->ladoDos;
            $this->perimetro = 2 * $this->ladoUno + 2 * $this->ladoDos;

        }

        public function Dibujar()
        {
            $datos = "";

            for($i = 0; $i < $this->ladoDos; $i++)
            {
                for($j = 0; $j < $this->ladoUno; $j++)
                {
                    $datos .= "*";
                }

                $datos .= "<br>";

                
            }

            $datos .= "Perímetro: " . $this->perimetro . "<br>";
            $datos .= "Área: " . $this->area;
            
            return $datos;

        }


    }

?>