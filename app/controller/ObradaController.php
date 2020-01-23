<?php

class ObradaController extends UlogaOperater
{

    private $viewGreska="";
    private $id=0;


    public function index()
    {  
        $this->view->render("privatno/obrade/index",
            ["obrade"=>Obrada::getObrade()]);
    }



    public function pripremaNovi()
    {
        $this->view->render("privatno/obrade/novi",
        ["clanovi"=>Clan::getClanovi(),
        "obrade"=>Obrada::getObrade(),
        "zanrovi"=>Obrada::getZanrovi()
        ]);
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
       "glazbenici"=>Obrada::getGlazbenici(),
       "instrumenti"=>Obrada::getInstrumenti(),
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

        if (trim(App::param('naziv')) === '') {
        
        $this->greska('naziv', 'Naziv obavezan');
        
        return false;
        
        }
        
        if (strlen(App::param('naziv')) > 30) {
        
        $this->greska('naziv', 'Naziv ne smije imati više od 30 znakova (trenutno ima: '.
        
        strlen(App::param('naziv')).')');
        
        return false;
        
        }
        
        if (trim(App::param('izvodac')) === '') {
        
        $this->greska('izvodac', 'Obavezan unos');
        
        return false;
        
        }
        
        if (strlen(App::param('izvodac')) > 30) {
        
        $this->greska('izvodac', 'Izvođač ne smije imati više od 30 znakova (trenutno ima: '.
        
        strlen(App::param('izvodac')).')');
        
        return false;
        
        }
        
        if (trim(App::param('url')) === '') {
        
        $this->greska('url', 'Obavezan unos');
        
        return false;
        
        }
        
        if (strlen(App::param('url')) > 60) {
        
        $this->greska('url', 'Url ne smije imati više od 60 znakova (trenutno ima: '.
        
        strlen(App::param('url')).')');
        
        return false;
        
        }
        
        
        
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