CREATE TABLE Product (
    id SERIAL PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    description TEXT NOT NULL,
    price FLOAT(2) NOT NULL
);