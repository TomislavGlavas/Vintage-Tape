<?php 

class Obrada
{
    public static function getObrade()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select 
        a.sifra,
        a.naziv as obrada, 
        a.izvodac,
        a.url,
        a.datum, 
        b.naziv as zanr,
        count(c.glazbenik) as ukupno  
        from 
        obrada a inner join zanr b 
        on a.zanr=b.sifra
        left join glazbenikobradainstrument c
        on a.sifra=c.obrada
        group by a.naziv
        order by a.datum desc
        
        ");
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function read($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select d.ime as instrument,
        concat(c.ime,' ',c.prezime) as glazbenik
        from glazbenikobradainstrument a
        right join obrada b
        on a.obrada=b.sifra
        right join glazbenik c 
        on a.glazbenik=c.sifra
        right join instrument d
        on a.instrument=d.sifra
        where b.sifra=:obrada
        order by d.kategorija,d.sifra,c.ime,c.prezime
        
        ");
        $izraz->execute(['obrada'=>$id]);
        return $izraz->fetch(PDO::FETCH_ASSOC);

    }

    public static function getZanrovi()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select * from zanr
        
        ");
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function getGlazbenici()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select * from glazbenik
        
        ");
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function getInstrumenti()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select * from instrument
        
        ");
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function getGOI()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select * from zanr
        
        ");
        $izraz->execute();
        return $izraz->fetchAll();
    }


    public static function novi()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        insert into obrada values
        (null,:naziv,:izvodac,:zanr,:url,:datum)
        
        ");
        $izraz->execute($_POST);
        return $veza->lastInsertId();
    }

    public static function promjeni($id)
    {   
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        update obrada set
        naziv=:naziv,
        izvodac=:izvodac,
        zanr=:zanr,
        url=:url,
        datum=:datum
        where sifra=:sifra
        
        ");
        $_POST['sifra']=$id;
        $izraz->execute($_POST);
    }

    public static function brisi($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        delete from obrada where sifra=:sifra
        
        ");
        $izraz->execute(['sifra'=>$id]);
    }

    public static function dodajGOI()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        insert into glazbenikobradainstrument values
        (:glazbenik,:obrada,:instrument)
        
        ");
        $izraz->execute($_GET);
    }

    public static function obrisiGOI()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        delete from glazbenikobradainstrument where glazbenik = :glazbenik
        and obrada=:obrada and instrument=:instrument
                
        ");
        $izraz->execute($_GET);
    }

    public static function isDeletable($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select count(glazbenik) from glazbenikobradainstrument where obrada=:obrada
        
        ");
        $izraz->execute(['obrada'=>$id]);
        $ukupno = $izraz->fetchColumn();
        return $ukupno==0;

    }


}