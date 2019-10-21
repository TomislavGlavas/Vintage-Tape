<?php

class UlogaAdmin extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if($_SESSION["autoriziran"]->uloga!="admin"){
            $this->view->render("login");
            exit;
        }
    }
}