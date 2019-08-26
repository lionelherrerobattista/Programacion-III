<?php
    
    $lapicera1 = array("Color"=>"Rojo","Marca"=>"A","Trazo"=>"2A","Precio"=>20);
    $lapicera2 = array("Color"=>"Azul","Marca"=>"B","Trazo"=>"4B","Precio"=>30);
    $lapicera3 = array("Color"=>"Amarillo","Marca"=>"C","Trazo"=>"6B","Precio"=>40);

    echo "Lapicera 1:<br>";
    foreach($lapicera1 as $k=>$valor)
    {
        print("$k: $valor<br>");
    }

    echo "<br>Lapicera 2:<br>";

    foreach($lapicera2 as $k=>$valor)
    {
        print("$k: $valor<br>");
    }

    echo "<br>Lapicera 3:<br>";

    foreach($lapicera3 as $k=>$valor)
    {
        print("$k: $valor<br>");
    }


?>