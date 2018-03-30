<?php namespace Tools;
use Symfony\Component\Yaml\Yaml;

class Server
{
    static function config(){
        $data = Yaml::parse(file_get_contents('../config/server.yml'));
        define("DEBUG",$data['debug']);
        if(DEBUG) {
            ini_set('display_errors', true);
            error_reporting(E_ALL);
        }
    }
}