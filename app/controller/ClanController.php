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
            ["polaznici"=>Clan::getCLanovi($stranica),
            "prethodnaStranica"=>$prethodnaStranica,
            "stranica"=>$stranica,
            "sljedecaStranica"=>$sljedecaStranica,
            "ukupnoStranica"=>$ukupnoStranica,
            "cssFile"=>'<link rel="stylesheet" href="' . App::config("url") . 'public/css/cropper.css">',
            "jsLib"=>'<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
            <script src="https://fengyuanchen.github.io/js/common.js"></script>
            <script src="' . App::config("url") . 'public/js/cropper.js"></script>
            <script>var putanja="' . App::config("url") .  '";</script>
           <script src="' . App::config("url") . 'public/js/clanovi/index.js"></script>']);
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
        //nema (još) kontrola
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

    public function trazipolaznik()
    {
        header('Content-Type: application/json');
        echo json_encode(Clan::getTraziClanovi(App::param("uvjet"),App::param("obrada")));

    }




}