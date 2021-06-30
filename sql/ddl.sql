create table Product (
    id serial primary key,
    name varchar(30) not null,
    description text not null,
    price float(2) not null
);