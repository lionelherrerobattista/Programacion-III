<?php

    require_once "./clases/alumno.php";
    require_once "./clases/IApiUsable.php";

    class AlumnoApi extends Alumno implements IApiUsable
    {
        public function __construct()
        {

        }

        public static function MostrarUno($request, $response, $args)
        {

        }

        public static function MostrarTodos($request, $response, $args)
        {
            //para separar la clase que maneja los verbos HTTP de la fuente de datos:
            $datos = Alumno::TraerAlumnos();
        
            return $response->getBody()->write($datos);

        }

        public static function GuardarUno($request, $response, $args)
        {
            $ruta = "./objetos.json";
            $destino = "./imagenes/";
            $mensaje = "Error";

            //le paso el archivo
            $archivo = $request->getUploadedFiles();

            $rutaFoto = Archivo::GuardarArchivoTemporal($archivo, $destino);

            $alumno = new Alumno($args["nombre"], $args["apellido"], $args["legajo"], $rutaFoto);

            switch($args["opcion"])
            {
                case "agregar":
                Archivo::GuardarPersona($ruta, $alumno);
                $mensaje = "Alumno guardado";
                break;

                case "modificar":
                Archivo::ModificarAlumno($ruta, $alumno);
                $mensaje = "Alumno modificado";
                break;

                default:
                $mensaje = "Error";
                break;
            }

            return $response->getBody()->write($mensaje);
        }

        public static function BorrarUno($request, $response, $args)
        {
            
            $ruta = "./objetos.json";

            Archivo::BorrarPersona($ruta, $args["legajo"]);

            return $response->getBody()->write('Alumno Borrado');

        }

        public static function ModificarUno($request, $response, $args)
        {    
            $ruta = "./objetos.json";
            $destino = "./imagenes/";

            //le paso el archivo
            $archivo = $request->getUploadedFiles();

            $rutaFoto = Archivo::GuardarArchivoTemporal($archivo, $destino);

            $alumnoModificado = new Alumno($args["nombre"], $args["apellido"], $args["legajo"], $rutaFoto);

            Archivo::ModificarAlumno($ruta, $alumnoModificado);

            return $response->getBody()->write('Alumno Modificado');
        }

    }

?>