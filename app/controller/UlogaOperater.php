<?php

class UlogaOperater extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if($_SESSION["autoriziran"]->uloga!="oper"){
            $this->view->render("login");
            exit;
        }
    }
}