<?php
 class Punto
 {
    private $_x;
    private $_y;

    public function __construct($x, $y)
    {
        $this->_x = $x;
        $this->_y = $y;
    }

    public function GetX()
    {
        return $this->_x;
    }

    public function GetY()
    {
        return $this->_y;
    }
    

 }

?>