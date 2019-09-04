<?php
    require_once "funciones.php";

    

    if(isset($_POST["nombre"], $_POST["legajo"]))
    {
        $objeto = array("nombre" => $_POST["nombre"], "legajo" => $_POST["legajo"]);

        Guardar("objetos.json", $objeto);
    }


    $datos = Leer("objetos.json");

    
    var_dump($datos);

     for($i = 0; $i < count($datos); $i++)
     {
        echo "Persona " . ($i+1) . "<br>";

        foreach($datos[$i] as $clave=>$valor)
        {
             echo $clave . ": " . $valor . "<br>";
        }

         echo "<br>";
         
         $i++;
     }

         

     

    // foreach($datos as $clave=>$valor)
    // {
    //     echo $clave . ": " . $valor;
    // }

    
    

    // // fwrite($ar, "Hola" . PHP_EOL); //constante PHP_EOL

    // // copy("archivo.txt", "archivoCopia.txt"); //Copia archivo

    // // unlink("archivoCopia.txt"); //borra archivo


?>