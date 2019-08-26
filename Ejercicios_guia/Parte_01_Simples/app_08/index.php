<?php
    $num = 60;
    $decenas;
    $unidades;

    if($num > 20 && $num < 60)
    {
        $decenas = (int)($num / 10);

        switch($decenas)
        {
            case 2:
                echo "veinti";
                break;
            case 3:
                echo "treinta";
                break;
            case 4:
                echo "cuarenta";
                break;
            case 5:
                echo "cincuenta";
                break;
        }

        

        $unidades = $num - ($decenas * 10);
        
        if(($num >= 30 && $num <= 60) && $unidades != 0)
        {
            echo " y ";
        }

        switch($unidades)
        {
            case 1:
            echo "uno";
            break;

            case 2:
            echo "dos";
            break;

            case 3:
            echo "tres";
            break;

            case 4:
            echo "cuatro";
            break;

            case 5:
            echo "cinco";
            break;

            case 6:
            echo "seis";
            break;

            case 7:
            echo "siete";
            break;

            case 8:
            echo "ocho";
            break;

            case 9:
            echo "nueve";
            break;




        }
    }
    else if($num == 20)
    {
        echo "veinte";
    }
    else if($num == 60)
    {
        echo "sesenta";
    }

?>