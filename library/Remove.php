<?php namespace Tools;


class Remove {
    static function eliminarDir($carpeta)
    {
        foreach(glob($carpeta . "/*") as $archivos_carpeta)
        {

            if (is_dir($archivos_carpeta))
            {
                \Tools\Remove::eliminarDir($archivos_carpeta);
            }
            else
            {
                unlink($archivos_carpeta);
            }
        }

        rmdir($carpeta);
    }
}