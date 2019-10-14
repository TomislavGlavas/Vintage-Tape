drop database if exists VintageTape;
create database VintageTape character set utf8 collate utf8_general_ci;
# c:\xampp\mysql\bin\mysql -uedunova -pedunova --default_character_set=utf8 < c:\VintageTape.sql
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


create table pjesma(
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

insert into pjesma (naziv,izvodac,url,zanr,datum) values 
('Zašto praviš slona od mene','Dino Dvornik','https://youtu.be/dQPpOCMnyG8',1,'2018-06-19'),
('Tempera','Gibonni','https://youtu.be/P4Hxn3JTNq8',2,'2018-07-27'),
('Kiss','Prince','https://youtu.be/AkHRS9tnFrA',3,'2018-09-07'),
('Moj lipi anđele','Oliver Dragojević','https://youtu.be/1W0dETyy63w',2,'2018-09-23'),
('Bijeli Božić','Irving Berlin','https://youtu.be/fIRtwnIvlAA',2,'2018-12-06'),
('Na zadnjem sjedištu moga auta','Bijelo Dugme','https://youtu.be/dDGiYZeuIbs',4,'2019-02-03'),
('Kao da me nema tu','Vanna','https://youtu.be/wejcnoa4ce4',1,'2019-03-16'),
('Dok si pored mene','Parni Valjak','https://youtu.be/TdD73qTomU0',4,'2019-04-25'),
('Kolačići','Marina Perazić','https://youtu.be/ZkMs9EFjwos',1,'2019-08-30'); 



create table osoba(
sifra int not null primary key auto_increment,
ime varchar(50) not null,
prezime varchar(50) not null,
spol varchar(1) not null
);

insert into osoba(ime,prezime,spol) values
('Karlo','Cvetković','m'),
('Matej','Zeljko','m'),
('Tomislav','Glavaš','m'),
('Dino','Raičević','m'),
('Luka','Kolak','m'),
('Marijan','Gašparović','m'),
('Marina','Soldo','ž'),
('Benjamin','Lamza','m'),
('Ivona','Kir','ž'),
('Petra','Hrženjak','ž'),
('Matej','Fridl','m'),
('Matija','Šeremet','m'),
('Dora','Vestić','ž'),
('Nera','Mamić','ž'),
('Martina','Strapač','ž'),
('Gabrijela','Babić','ž'),
('Matej','Podgorščak','m'),
('Monika','Birger','ž'),
('Tomislav','Kožnjak','m'),
('Davor','Ilišević','m');

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
('perkusije'),
('klavijature'),
('basevi');

insert into instrument (ime,kategorija) values
('glavni vokal',1),
('back vokal',1),
('električna gitara',2),
('klasična gitara',2),
('saksofon',3),
('električne klavijature',5),
('klavinova',5),
('bubnjevi',4),
('bas gitara',6),
('kontrabas',6),
('bongosi',4),
('truba',3),
('rog',3);



create table osobainstrument(
osoba int not null,
instrument int not null
);

insert into osobainstrument (osoba,instrument) values
(1,1),
(1,2),
(2,2),
(2,3),
(2,4),
(3,2),
(3,6),
(3,7),
(5,8),
(5,11),
(4,2),
(4,3),
(4,4),
(6,9),
(6,10),
(7,1),
(7,2),
(8,5),
(9,2),
(10,2),
(11,13),
(12,12),
(13,1),
(13,2),
(14,1),
(14,2),
(15,2),
(16,1),
(17,1),
(18,2),
(19,8),
(19,11),
(20,2);


create table osobapjesma(
osoba int not null,
pjesma int not null
);

insert into osobapjesma (pjesma,osoba) values 
(1,1),
(1,2),
(1,3),
(1,4),
(1,5),
(1,8),
(1,9),
(1,10),
(2,1),
(2,2),
(2,3),
(2,4),
(3,1),
(3,2),
(3,3),
(3,4),
(3,5),
(3,8),
(3,11),
(3,12),
(3,13),
(3,14),
(3,15),
(4,1),
(4,2),
(4,3),
(4,4),
(4,5),
(4,8),
(4,11),
(4,12),
(4,13),
(4,14),
(4,10),
(5,1),
(5,2),
(5,3),
(5,4),
(5,5),
(5,6),
(5,17),
(5,20),
(6,1),
(6,2),
(6,3),
(6,4),
(6,5),
(6,6),
(6,8),
(6,9),
(6,18),
(6,19),
(7,2),
(7,3),
(7,4),
(7,5),
(7,6),
(7,16),
(8,1),
(8,2),
(8,3),
(8,4),
(8,5),
(8,6),
(8,15),
(8,18),
(8,19),
(9,2),
(9,3),
(9,4),
(9,5),
(9,6),
(9,7);

alter table osobainstrument add foreign key (osoba) references osoba(sifra);
alter table osobainstrument add foreign key (instrument) references instrument(sifra);
alter table osobapjesma add foreign key (osoba) references osoba(sifra);
alter table osobapjesma add foreign key (pjesma) references pjesma(sifra);
alter table instrument add foreign key (kategorija) references kategorija(sifra);
alter table pjesma add foreign key (zanr) references zanr(sifra);


