create table crashdata(
   id int primary key auto_increment,
   day varchar(20),
   map int not null,
   mapnavi int not null,
   rate double not null,
   sv varchar(20),
   os varchar(20)
);