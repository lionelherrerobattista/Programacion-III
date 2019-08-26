<?php
    $operador = "/";
    $op1 = 2;
    $op2 = 1;

    switch($operador)
    {
        case "-":
            echo $op1 - $op2;
            break;

        case "*":
            echo $op1 * $op2;
            break;

        case "/":
            if($op2 != 0)
                echo $op1 / $op2;
            break;

        default:
            echo $op1 + $op2;
            break;
    }




?>