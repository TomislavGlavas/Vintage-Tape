<?php

class DB extends PDO
{

    private static $instance;

    public function __construct($db)
    {

        $dsn = 'mysql:host='.$db['server'] .
        ';dbname='.$db['baza'].';charset=utf8';

        parent::__construct($dsn,$db['korisnik'],$db['lozinka']);

        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);


    }



    public static function getInstance()
    {
        if(is_null(self::$instance)) {
            //moram napraviti novu instancu
            self::$instance = new self(App::config("db"));
        }

        return self::$instance;
    }

}