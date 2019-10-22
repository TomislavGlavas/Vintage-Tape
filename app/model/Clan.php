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

        select a.sifra,a.ime,a.prezime,count(b.obrada) as ukupno   
        from glazbenik a   
        inner join glazbenikobradainstrument b
        on a.sifra=b.glazbenik
        where concat(a.ime,a.prezime) like :uvjet
        group by a.sifra,a.ime,a.prezime         
        order by a.ime,a.prezime
        

        " . $limit
        
        );
        $izraz->execute(["uvjet"=>"%" . App::param("uvjet") . "%"]);
        return $izraz->fetchAll();
    }

    public static function getInstrumenti($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select * from grupa where sifra=:grupa
        
        ");
        $izraz->execute(['grupa'=>$id]);
        return $izraz->fetch(PDO::FETCH_ASSOC);

    }




    public static function getTraziCLanovi($uvjet, $grupa)
    {

        
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select distinct a.sifra,a.ime,a.prezime
        from glazbenik a inner join glazbenikobradainstrument b
        on a.sifra=b.glazbenik 

        where concat(a.ime,a.prezime) like :uvjet
        and b.glazbenik not in (select glazbenik from glazbenikobradainstrument where obrada=:obrada)
    
        limit 10
        " 
    
        );
        $izraz->execute(["uvjet"=>"%" . $uvjet . "%","obrada"=>$obrada]);
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
        $izraz->execute([
            'ime'=>$_POST['ime'],
            'prezime'=>$_POST['prezime'],
        ]);
        $veza->commit();
    }

    public static function promjeni($id)
    {   
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        update glazbenik
        set ime=:ime,
            prezime=:prezime,
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
        
        delete glazbenik
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
        
        select count(sifra) from glazbenik
        where concat(ime,prezime) like :uvjet
        
        ");
        $izraz->execute(["uvjet"=>"%" . App::param("uvjet") . "%"]);
        $ukupno = $izraz->fetchColumn();
        return ceil($ukupno/App::config("stavakaPoStranici"));
    }

}