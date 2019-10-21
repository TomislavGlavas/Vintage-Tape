<?php

class OperaterController extends UlogaAdmin
{

    private $viewGreska="";
    private $id=0;

    public function __construct()
    {
        parent::__construct();
        if($_SESSION["autoriziran"]->uloga!="admin"){
            $this->view->render("login");
            exit;
        }
    }


    public function index()
    {  
        $this->view->render("privatno/operateri/index");
    }


}