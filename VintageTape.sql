drop database if exists VintageTape;
create database VintageTape character set utf8 collate utf8_general_ci;
# c:\xampp\mysql\bin\mysql -uedunova -pedunova --default_character_set=utf8 < C:\xampp\htdocs\cpanel\VintageTape.sql
use VintageTape;

# za hosting
#alter database cesar_edunovapp19 default character set utf8;

create table operater(
sifra int not null primary key auto_increment,
email varchar(255) not null,
lozinka char(60) not null,
ime varchar(50) not null,
prezime varchar(50) not null,
uloga varchar(20) not null
);

insert into operater values (null,'edunova@edunova.hr',
'$2y$12$VR0bNVQMB05iablvXDUf9eP5rJd8/yeBPot3VTHSMOyuJMcfK7b6C',
'Edunova','Korisnik','admin');

insert into operater values (null,'oper@edunova.hr',
'$2y$12$VR0bNVQMB05iablvXDUf9eP5rJd8/yeBPot3VTHSMOyuJMcfK7b6C',
'Edunova','Korisnik','oper');


create table obrada(
sifra int not null primary key auto_increment,
naziv varchar(55) not null,
izvodac varchar(55) not null,
zanr int not null,
url varchar(255),
datum datetime not null
);

create table zanr(
sifra int not null primary key auto_increment,
naziv varchar(55) not null
);

insert into zanr (naziv) values
('funk'),
('jazz'),
('blues'),
('latino');

insert into obrada (naziv,izvodac,url,zanr,datum) values 
('Zašto praviš slona od mene','Dino Dvornik','https://youtu.be/dQPpOCMnyG8',1,'2018-06-19'),
('Tempera','Gibonni','https://youtu.be/P4Hxn3JTNq8',2,'2018-07-27'),
('Kiss','Prince','https://youtu.be/AkHRS9tnFrA',3,'2018-09-07'),
('Moj lipi anđele','Oliver Dragojević','https://youtu.be/1W0dETyy63w',2,'2018-09-23'),
('Bijeli Božić','Irving Berlin','https://youtu.be/fIRtwnIvlAA',2,'2018-12-06'),
('Na zadnjem sjedištu moga auta','Bijelo Dugme','https://youtu.be/dDGiYZeuIbs',4,'2019-02-03'),
('Kao da me nema tu','Vanna','https://youtu.be/wejcnoa4ce4',1,'2019-03-16'),
('Dok si pored mene','Parni Valjak','https://youtu.be/TdD73qTomU0',4,'2019-04-25'),
('Kolačići','Marina Perazić','https://youtu.be/ZkMs9EFjwos',1,'2019-08-30'); 



create table glazbenik(
sifra int not null primary key auto_increment,
ime varchar(50) not null,
prezime varchar(50) not null
);

insert into glazbenik(ime,prezime) values
('Karlo','Cvetković'),
('Matej','Zeljko'),
('Tomislav','Glavaš'),
('Dino','Raičević'),
('Luka','Kolak'),
('Marijan','Gašparović'),
('Marina','Soldo'),
('Benjamin','Lamza'),
('Ivona','Kir'),
('Petra','Hrženjak'),
('Matej','Fridl'),
('Matija','Šeremet'),
('Dora','Vestić'),
('Nera','Mamić'),
('Martina','Strapač'),
('Gabrijela','Babić'),
('Matej','Podgorščak'),
('Monika','Birger'),
('Tomislav','Kožnjak'),
('Davor','Ilišević');

create table instrument(
sifra int not null primary key auto_increment,
ime varchar(50) not null,
kategorija int not null
);

create table kategorija(
sifra int not null primary key auto_increment,
ime varchar(50) not null
);

insert into kategorija (ime) values 
('vokali'),
('gitare'),
('puhački instrumenti'),
('klavijature'),
('basevi'),
('perkusije');



insert into instrument (ime,kategorija) values
('glavni vokal',1),
('back vokal',1),
('električna gitara',2),
('klasična gitara',2),
('saksofon',3),
('električne klavijature',4),
('klavinova',4),
('bubnjevi',6),
('bas gitara',5),
('kontrabas',5),
('bongosi',6),
('truba',3),
('rog',3);



create table glazbenikobradainstrument(
glazbenik int not null,
obrada int not null,
instrument int not null
);

insert into glazbenikobradainstrument (obrada,glazbenik,instrument) values 
(1,1,1),
(1,2,3),
(1,3,7),
(1,4,9),
(1,5,8),
(1,8,5),
(1,9,2),
(1,10,2),
(2,1,1),
(2,2,3),
(2,2,2),
(2,3,7),
(2,3,2),
(2,4,9),
(2,4,2),
(3,1,1),
(3,2,3),
(3,3,7),
(3,4,9),
(3,5,8),
(3,8,5),
(3,11,13),
(3,12,12),
(3,13,2),
(3,14,2),
(3,15,2),
(4,1,1),
(4,2,3),
(4,3,7),
(4,4,9),
(4,5,8),
(4,8,5),
(4,11,13),
(4,12,12),
(4,13,2),
(4,14,2),
(4,10,2),
(5,1,2),
(5,2,2),
(5,3,7),
(5,4,3),
(5,5,8),
(5,6,10),
(5,17,1),
(5,20,2),
(6,1,1),
(6,2,3),
(6,3,7),
(6,4,4),
(6,5,8),
(6,6,10),
(6,8,5),
(6,9,2),
(6,18,2),
(6,19,11),
(7,2,3),
(7,3,7),
(7,4,3),
(7,5,8),
(7,6,9),
(7,16,1),
(8,1,1),
(8,2,3),
(8,3,7),
(8,4,4),
(8,5,11),
(8,6,10),
(8,15,2),
(8,18,2),
(8,19,8),
(9,2,3),
(9,3,6),
(9,4,3),
(9,5,8),
(9,6,9),
(9,7,1);

alter table glazbenikobradainstrument add foreign key (glazbenik) references glazbenik(sifra);
alter table glazbenikobradainstrument add foreign key (obrada) references obrada(sifra);
alter table glazbenikobradainstrument add foreign key (instrument) references instrument(sifra);
alter table instrument add foreign key (kategorija) references kategorija(sifra);
alter table obrada add foreign key (zanr) references zanr(sifra);


