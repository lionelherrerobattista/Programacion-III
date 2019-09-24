<?php


    Potencias();

    function Potencias()
    {
        for($i = 1; $i <= 4; $i++)
        {
            for($j = 1; $j <= 4; $j++)
            {
                echo "<br>", pow($i, $j);
            }
            
        }
    }

?>