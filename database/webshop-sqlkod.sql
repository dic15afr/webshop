drop table if exists users;
drop table if exists shopping_cart;
drop table if exists products;
drop table if exists feedback;
drop table if exists blacklist;

create table users(
Username varchar (20) not null,
Password varchar (30) not null,
Address varchar (100) not null,
Zip varchar (10) not null,
City varchar (30) not null,
Locked int (10) default(0),
Attempts int (1) default(0),
primary key (Username)
);

create table shopping_cart(
Product varchar (50) not null,
Price int (5) not null,
User varchar (20) not null,
Quantity int (4),
primary key(Product, User)
);

create table products(
Name varchar (50) not null,
Description text not null,
Pic blob, 
Price int (5) not null
);

create table feedback(
Feedback varchar (300) not null
);

create table blacklist(
password varchar (30)
);

INSERT INTO products(Name,Description,Pic,Price)
VALUES('Plumbus', 'Every home needs one!', readfile('plumbus.jpg'), 1000),
('Meeseeks box', 'For your every day needs!', readfile('meBox.jpg'), 10000),
('Thing', 'No one is really sure what this is even on our end. Isn''t it exiting!?', readfile('thing.jpg'), 10),
('Windex', 'A popular budget alternative to our best selling Meeseeks box!', readfile('windex.jpg'), 50),
('Duck', 'All our ducks are of the highest quality and fully organic!', readfile('duck.jpg'), 300);

INSERT INTO users(Username,Password,Address,Zip,City) 
VALUES('Albin', '98acf1f893abcda1a909af3a0a2dad3f37c98558a2fff0e8cc912065462ebf82', "test", "123", "Lund"),
("Ahmed", "05caef8f1ac640091f3721a85462db801ab3c1151e2a4b916fcb73c523e7b856", "a", "1", "a");

INSERT INTO blacklist(password)
VALUES('123456'),
('123456789'),
('qwerty'),
('12345678'),
('111111'),
('1234567890'),
('password'),
('google'),
('dragon'),
('baseball'),
('football'),
('letmein'),
('monkey');