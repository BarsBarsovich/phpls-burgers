create table orders
(
    USER_ID int  null,
    ID      int auto_increment
        primary key,
    ADDRESS text not null,
    COMMENT text not null,
    constraint orders_users_Id_fk
        foreign key (USER_ID) references users (Id)
);

INSERT INTO burgers.orders (USER_ID, ID, ADDRESS, COMMENT) VALUES (8, 1, 'ul Gofmana', 'no comments');
INSERT INTO burgers.orders (USER_ID, ID, ADDRESS, COMMENT) VALUES (8, 2, 'street 12 12 11 113', 'cdfdsfdsfds');
INSERT INTO burgers.orders (USER_ID, ID, ADDRESS, COMMENT) VALUES (8, 3, 'street 12 12 11 113', 'cdfdsfdsfds');
INSERT INTO burgers.orders (USER_ID, ID, ADDRESS, COMMENT) VALUES (8, 4, 'street 12 12 11 113', 'cdfdsfdsfds');
INSERT INTO burgers.orders (USER_ID, ID, ADDRESS, COMMENT) VALUES (8, 5, 'street 12 12 11 113', 'cdfdsfdsfds');
INSERT INTO burgers.orders (USER_ID, ID, ADDRESS, COMMENT) VALUES (8, 6, 'street 12 12 11 113', 'cdfdsfdsfds');
INSERT INTO burgers.orders (USER_ID, ID, ADDRESS, COMMENT) VALUES (8, 7, 'street 12 12 11 113', 'cdfdsfdsfds');
INSERT INTO burgers.orders (USER_ID, ID, ADDRESS, COMMENT) VALUES (9, 8, 'Улица папуасов 12 12 11 113', 'НИчего писать не хочу');
INSERT INTO burgers.orders (USER_ID, ID, ADDRESS, COMMENT) VALUES (10, 9, 'Улица папуасов 12 12 11 113', 'НИчего писать не хочу');
INSERT INTO burgers.orders (USER_ID, ID, ADDRESS, COMMENT) VALUES (11, 10, 'Улица папуасов 12 12 11 113', 'НИчего писать не хочу');