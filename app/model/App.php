<?php

class App
{
    public static function start()
    {
    
        $pathInfo = Request::pathinfo();


        $pathParts = explode("/",$pathInfo);


        if(!isset($pathParts[1]) || empty($pathParts[1])){
            $controller = "Index";
        }else{
            $controller=ucfirst(strtolower($pathParts[1]));
        }

        $controller .= "Controller";


        if(!isset($pathParts[2])|| empty($pathParts[2])){
            $function = "index";
        }else{
            $function = strtolower($pathParts[2]);
        }

        if(!isset($pathParts[3])|| empty($pathParts[3])){
            $id = 0;
        }else{
            $id = (int)$pathParts[3];
        }


        if(class_exists($controller) && method_exists($controller,$function)){
            $instanca = new $controller();
            if($id>0){
                $instanca->$function($id);
            }else{
                $instanca->$function();
            }
            
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

    public static function param($key,$value='')
    {
        if($value!==''){
            $postavljen=false;
            if(isset($_REQUEST[$key])){
                $_REQUEST[$key]=$value;
                $postavljen=true;
               }
               if(isset($_GET[$key])){
                $_GET[$key]=$value;
                $postavljen=true;
               }
               if(isset($_POST[$key])){
                 $_POST[$key]=$value;
                 $postavljen=true;
               }
               if(!$postavljen){
                $_REQUEST[$key]=$value;
                $_POST[$key]=$value;
               }
               return;
        }
       if(isset($_REQUEST[$key])){
        return $_REQUEST[$key]; 
       }
       if(isset($_GET[$key])){
        return $_GET[$key];
       }
       if(isset($_POST[$key])){
        return $_POST[$key];
       }

       return "";
    }

    public static function setParams($parametri){
        foreach ($parametri as $key => $value) {
            App::param($key,$value);
        }
    }

}