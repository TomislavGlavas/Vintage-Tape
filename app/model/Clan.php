<?php

class Clan
{
    public static function getClanovi($stranica=0)
    {   
        if($stranica>0){
            $sps = App::config("stavakaPoStranici");
            $odKuda=($stranica -1) * $sps;
            $limit = "limit " . $odKuda . ", " . $sps;
        }else{
            $limit="";
        }
        $veza = DB::getInstance();
        $izraz = $veza->prepare("

        select  a.sifra,a.ime,a.prezime,count(b.obrada) as ukupno,group_concat(distinct c.ime order by c.sifra separator ', ' ) as instrument
        from glazbenik a
        left join glazbenikobradainstrument b
        on a.sifra=b.glazbenik
        left join instrument c
        on c.sifra=b.instrument
        where concat(a.ime,a.prezime) like :uvjet
        group by a.ime, a.prezime, a.sifra
        order by a.ime, a.prezime
        

        " . $limit
        
        );
        $izraz->execute(["uvjet"=>"%" . App::param("uvjet") . "%"]);
        return $izraz->fetchAll();
    }

    public static function getInstrumentiNaCLanu($clan)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select distinct a.ime
        from instrument a
        inner join glazbenikobradainstrument b
        on a.sifra=b.instrument 
        where b.glazbenik=:clan
        order by a.kategorija
        
        ");
        $izraz->execute(['clan'=>$id]);
        return $izraz->fetchAll();

    }

    public static function traziclan()
    {
        header('Content-Type: application/json');
        echo json_encode(Clan::getTraziClanovi(App::param("uvjet")));
    }


    public static function getTraziClanovi($uvjet)
    {

        
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select distinct * from glazbenik
        where concat(ime,prezime) like :uvjet
    
        limit 10
        " 
    
        );
        $izraz->execute(["uvjet"=>"%" . $uvjet . "%"]);
        return $izraz->fetchAll();
    }

    public static function getGlazbeniciNaObradi($obrada)
    {
       
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select a.sifra,a.ime,a.prezime
        from glazbenik a inner join glazbenikobradainstrument b
        on a.sifra=b.glazbenik
        where b.obrada=:obrada
        order by a.ime,a.prezime

        ");
        $izraz->execute(["obrada"=>$obrada]);
        return $izraz->fetchAll();
    }

    public static function read($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select *
        from glazbenik a 
        where sifra=:glazbenik
        
        ");
        $izraz->execute(['glazbenik'=>$id]);
        return $izraz->fetch(PDO::FETCH_ASSOC);

    }

    public static function novi()
    {
        $veza = DB::getInstance();
        $veza->beginTransaction();

        $izraz = $veza->prepare("
        
        insert into glazbenik values
        (null,:ime,:prezime)
        
        ");
        $izraz->execute(
        ['ime'=>$_POST['ime'],
        'prezime'=>$_POST['prezime']]    
        );
        $veza->commit();
    }

    public static function promjeni($id)
    {   
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        update glazbenik
        set ime=:ime,
            prezime=:prezime
        where
            sifra = :sifra
        
        ");
        $_POST['sifra']=$id;
        $izraz->execute($_POST);
    }

    public static function brisi($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        delete from glazbenik
        where sifra=:sifra
        
        ");
        $izraz->execute(['sifra'=>$id]);
    }

    public static function isDeletable($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select count(obrada) from glazbenikobradainstrument where glazbenik=:glazbenik
        
        ");
        $izraz->execute(['glazbenik'=>$id]);
        $ukupno = $izraz->fetchColumn();
        return $ukupno==0;

    }

    public static function ukupnoStranica()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select count(a.sifra) from glazbenik a 
        where concat(a.ime,a.prezime) like :uvjet
        
        ");
        $izraz->execute(["uvjet"=>"%" . App::param("uvjet") . "%"]);
        $ukupno = $izraz->fetchColumn();
        return ceil($ukupno/App::config("stavakaPoStranici"));
    }

}