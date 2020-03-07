create table users
(
    Email varchar(30) not null,
    Phone varchar(12) not null,
    Name  varchar(10) not null,
    Id    int auto_increment
        primary key
);

INSERT INTO burgers.users (Email, Phone, Name, Id) VALUES ('lol@lol.lol', '02', 'Vasya', 1);
INSERT INTO burgers.users (Email, Phone, Name, Id) VALUES ('kek@kek.kek', '456', 'Boris', 2);
INSERT INTO burgers.users (Email, Phone, Name, Id) VALUES ('b@b.b', '0230', 'Gosha', 3);
INSERT INTO burgers.users (Email, Phone, Name, Id) VALUES ('m@m.ru', '+7 (02_) _', 'Gofman', 4);
INSERT INTO burgers.users (Email, Phone, Name, Id) VALUES ('l@l.ru', '009434', 'Ia', 5);
INSERT INTO burgers.users (Email, Phone, Name, Id) VALUES ('l1@l1.ru', '00w9434', 'Ia', 6);
INSERT INTO burgers.users (Email, Phone, Name, Id) VALUES ('pm@m.ru', '+7 (02_) _', 'Gofman', 7);
INSERT INTO burgers.users (Email, Phone, Name, Id) VALUES ('pm@mp.ru', '+7 (02_) _', 'Gofman', 8);
INSERT INTO burgers.users (Email, Phone, Name, Id) VALUES ('s@s.ru', '+7 (097) _', 'Сергулик', 9);
INSERT INTO burgers.users (Email, Phone, Name, Id) VALUES ('s1@s.ru', '+7 (097) _', 'Сергулик', 10);
INSERT INTO burgers.users (Email, Phone, Name, Id) VALUES ('www@www.www', '+7 (097) _', 'Вильгельм', 11);