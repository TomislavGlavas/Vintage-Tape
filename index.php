<?php

session_start();

// definiram basepath - apsolutnu putanju mog direktorija
define("BP",__DIR__ . DIRECTORY_SEPARATOR );

//echo BP;

error_reporting(E_ALL);
ini_set("display_errors",1);

//navodim direktorije u kojima ću autoload datoteke
$t = implode(PATH_SEPARATOR,
            [
                BP . "app" . DIRECTORY_SEPARATOR . "model",
                BP . "app" . DIRECTORY_SEPARATOR . "controller"
            ]
            );

//var_dump($t);

set_include_path($t);
spl_autoload_register(function($klasa)
{
    $putanja = strtr($klasa,"\\",DIRECTORY_SEPARATOR) . ".php";
    return include $putanja;
});
App::start();