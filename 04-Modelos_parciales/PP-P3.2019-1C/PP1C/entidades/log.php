<?php

class Log
    {
        public $caso;
        public $hora;
        public $ip;

        public function __construct($caso, $ip)
        {
            $hora = new DateTime();
            $hora = $hora->setTimezone(new DateTimeZone('America/Argentina/Buenos_Aires'));
            $hora = $hora->format("H:i:s");

            $this->caso = $caso;
            $this->hora = $hora;
            $this->ip = $ip;           

        }


        public static function GuardarLog($log)
        {
            $ruta = "./info.log";
            
            Archivo::GuardarUno($ruta, $log);

            if(file_exists($ruta))
            {
                $guardo = true;
            }

            return $guardo;
        }

        public static function TraerLogs()
        {
            $ruta = "./info.log";
            
            $listaLogs = Archivo::LeerArchivo($ruta);
            
            return $listaLogs;
        }
    }

?>