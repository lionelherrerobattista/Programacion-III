<?php
    interface IApiUsable
    {
        public static function MostrarUno($request, $response, $args);
        public static function MostrarTodos($request, $response, $args);
        public static function GuardarUno($request, $response, $args);
        public static function BorrarUno($request, $response, $args);
        public static function ModificarUno($request, $response, $args);
    }


?>