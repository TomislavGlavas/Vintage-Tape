<?php

class ObradaController extends UlogaOperater
{

    private $viewGreska="";
    private $id=0;


    public function index()
    {  
        $this->view->render("privatno/obrade/index",
            ["grupe"=>Obrada::getObrade()]);
    }



    public function pripremaNovi()
    {
        $this->view->render("privatno/obrade/novi",
        ["smjerovi"=>Clan::getClanovi()]);
    }




    public function novi()
    {  
       $this->viewGreska="privatno/obrade/novi";

      if(!$this->kontrole()){
          return;
      }
      //var_dump($_REQUEST);

       
       $this->pripremaPromjeni(Obrada::novi());
    }



    public function pripremaPromjeni($id)
    {
        $obrada = Obrada::read($id); 
    
        App::setParams($obrada);

       $this->view->render("privatno/obrade/promjeni", 
       ['id'=>$id,
       "clanovi"=>Clan::getClanovi(),
       "cssFile"=>'<link rel="stylesheet" href="' . App::config("url") . 'public/css/jquery-ui.css">',
       "jsLib"=>'<script src="' . App::config("url") . 'public/js/vendor/jquery-ui.js"></script>',
       "javascript"=>'
       <script>var grupa=' . $id . ';</script>
       <script src="' . App::config("url") . 'public/js/obrade/skripta.js"></script>']);
    }


    public function promjeni($id)
    {
        $this->viewGreska="privatno/obrade/promjeni";
        $this->id=$id;

        if(!$this->kontrole()){
            return;
        }
  
         Obrada::promjeni($id);
         $this->index();
    }


    public function brisanje($id)
    {  

        if(!Obrada::isDeletable($id)){
            $this->index();
            return;
        }

       Obrada::brisi($id);
       $this->index();
    }

    public function dodajclan(){
        Obrada::dodajClana();
        echo "OK";
    }

    public function obrisiclan(){
        Obrada::obrisiClana();
        echo "OK";
    }


    private function kontrole()
    {
        return true;
    }

    private function greska($polje,$poruka)
    {
        $this->view->render($this->viewGreska,
            ['greska'=>
                ['polje'=>$polje,
                 'poruka'=>$poruka],
             'id'=>$this->id
            ]);
    }


}