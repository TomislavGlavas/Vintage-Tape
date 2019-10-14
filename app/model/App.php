<?php

class App
{
    public static function start()
    {
        //echo "Hello world";

        $pathInfo = Request::pathinfo();

        //echo $pathInfo;

        $pathParts = explode("/",$pathInfo);

       // echo "<pre>";
       // var_dump($pathParts);
       // echo "</pre>";

        if(!isset($pathParts[1]) || empty($pathParts[1])){
            $controller = "Index";
        }else{
            $controller=ucfirst(strtolower($pathParts[1]));
        }

        $controller .= "Controller";

        //echo $controller . "-&gt;";


        if(!isset($pathParts[2])|| empty($pathParts[2])){
            $function = "index";
        }else{
            $function = strtolower($pathParts[2]);
        }

        //echo $function;

        if(class_exists($controller) && method_exists($controller,$function)){
            $instanca = new $controller();
            $instanca->$function();
        }else{
            if(App::config("dev")){
                echo $controller . "->" . $function . " funkcija ne postoji";
            }else{
                header("HTTP/1.0 404 Not Found");
            }
            
        }



    }


    public static function config($key)
    {
        $config = include BP . "app/config.php";

        return $config[$key];
    }

    public static function param($key)
    {
       if(isset($_REQUEST[$key])){
        return $_REQUEST[$key]; //short cuircuiting
       }
       if(isset($_GET[$key])){
        return $_GET[$key];
       }
       if(isset($_POST[$key])){
        return $_POST[$key];
       }

       return "";
    }
}