<?php

class ClanController extends UlogaOperater
{

    private $viewGreska="";
    private $id=0;


    public function index($stranica=1)
    {  
        if(isset($_GET["trazi"])){
            $stranica=1;
        }

        if($stranica==1){
            $prethodnaStranica=1;
        }else{
            $prethodnaStranica=$stranica-1;
        }

       


        $ukupnoStranica = Clan::ukupnoStranica();

        if($stranica>=$ukupnoStranica){
            $sljedecaStranica=$ukupnoStranica;
        }else{
            $sljedecaStranica=$stranica+1;
        }

        $this->view->render("privatno/clanovi/index",
            [
            "clanovi"=>Clan::getCLanovi($stranica),
            "prethodnaStranica"=>$prethodnaStranica,
            "stranica"=>$stranica,
            "sljedecaStranica"=>$sljedecaStranica,
            "ukupnoStranica"=>$ukupnoStranica]);
    }
            

    function spremiSliku($id){


        error_reporting(0);

        $img = App::param("slika"); // Your data 'data:image/png;base64,AAAFBfj42Pj4';
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);

        $data = base64_decode($img);

        file_put_contents(App::config("path") . "public/img/clanovi/" . $id . ".png",$data);

        echo "OK";
    }



    public function pripremaNovi()
    {
        $this->view->render("privatno/clanovi/novi");
    }




    public function novi()
    {  
       $this->viewGreska="privatno/clanovi/novi";

      if(!$this->kontrole()){
          return;
      }

       Clan::novi();
       $this->index();
    }



    public function pripremaPromjeni($id)
    {
      App::setParams(Clan::read($id));
      $this->view->render("privatno/clanovi/promjeni", ['id'=>$id]);
    }


    public function promjeni($id)
    {
        $this->viewGreska="privatno/clanovi/promjeni";
        $this->id=$id;

        if(!$this->kontrole()){
            return;
        }
  
         Clan::promjeni($id);
         $this->index();
    }


    public function brisanje($id)
    {  

        if(!Clan::isDeletable($id)){
            $this->index();
            return;
        }

       Clan::brisi($id);
       $this->index();
    }


    private function kontrole()
    {
        if (trim(App::param('ime')) === '') {
        
            $this->greska('ime', 'Obavezan unos');
            
            return false;
            
            }

            if (strlen(App::param('ime')) > 30) {
        
                $this->greska('ime', 'Ime ne smije imati više od 30 znakova (trenutno ima: '.
                
                strlen(App::param('ime')).')');
                
                return false;
                
                }
        
    return true;
    }


    //nju za sada nitko ne poziva 
    private function greska($polje,$poruka)
    {
        $this->view->render($this->viewGreska,
            ['greska'=>
                ['polje'=>$polje,
                 'poruka'=>$poruka],
             'id'=>$this->id
            ]);
    }

    public function traziclan()
    {
        header('Content-Type: application/json');
        echo json_encode(Clan::getTraziClanovi(App::param("uvjet")));

    }




}