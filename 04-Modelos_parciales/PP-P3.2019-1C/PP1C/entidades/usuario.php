<?php

class Usuario
{
    public $legajo;
    public $email;
    public $nombre;
    public $clave;
    public $fotoUno;
    public $fotoDos;

    public function __construct($legajo, $email, $nombre, $clave, $fotoUno, $fotoDos)
    {
        $this->legajo = $legajo;
        $this->email = $email;
        $this->nombre = $nombre;
        $this->clave = $clave;

        $this->fotoUno = Archivo::GuardarArchivoTemporal($fotoUno, "./img/fotos/fotoUno", $legajo);
        $this->fotoDos = Archivo::GuardarArchivoTemporal($fotoDos, "./img/fotos/fotoDos", $legajo);
    }

    public static function GuardarUsuario($usuario)
    {
        $ruta = "./usuarios.txt";
               
        Archivo::GuardarUno($ruta, $usuario);
  
    }

    public static function TraerUsuarios()
    {
        $ruta = "./usuarios.txt";
        
        $listaUsuarios = Archivo::LeerArchivo($ruta);
        
        return $listaUsuarios;
    }

    public static function ModificarUsuario($elementoModificado)
    {
        $ruta = "./usuarios.txt";

        $listaUsuarios = Usuario::TraerUsuarios();

        for($i= 0 ; $i < count($listaUsuarios); $i++)
        {
            $auxUsuario = $listaUsuarios[$i];

            //Modifico
            if($auxUsuario->legajo == $elementoModificado->legajo)
            {
                Archivo::HacerBackup($ruta, $auxUsuario);

                //reemplazo
                $listaUsuarios[$i] = $elementoModificado;

                Archivo::GuardarTodos($ruta, $listaUsuarios);
                
                break;
            }
        }
    }

    //true si es válido
    public static function ValidarLegajo($legajo)
    {
        $legajoValido = true;
        $listaUsuarios = Usuario::TraerUsuarios();
        
        foreach($listaUsuarios as $auxUsuario)
        {
            
            if(strcasecmp($auxUsuario->legajo, $legajo) == 0)
            {
                $legajoValido = false;
                break;
            }
        }
        return $legajoValido;
    }
    
}

?>