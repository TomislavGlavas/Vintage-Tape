<?php

class Controller
{
    protected $view;

    public function __construct()
    {
        if(!isset($_SESSION["autoriziran"])){
            $this->view->render("login");
            exit;
        }
        $this->view = new View();
    }
}