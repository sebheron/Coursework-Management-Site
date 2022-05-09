CREATE TABLE books
(
    id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR2(50),
    detail TEXT,
    author VARCHAR2(50),
    class VARCHAR2(20),
    genre VARCHAR2(20),
    price FLOAT,
    PRIMARY KEY (id)
);

CREATE TABLE users
(
    id NUMBER NOT NULL AUTO_INCREMENT,
    username VARCHAR2(15),
    password VARCHAR2(15),
    PRIMARY KEY (id)
);

CREATE TABLE orders
(
    id NUMBER NOT NULL AUTO_INCREMENT,
    bookid NUMBER NOT NULL,
    userid NUMBER NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (bookid) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (userid) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO books (title, detail, author, class, genre, price)
VALUES ("Harry Potter and the Sorcerers Stone",
"Harry Potter, a young wizard who travels to Hogwarts to learn about Witchcraft and Wizardry.",
"J. K. Rowling",
"fiction",
"prize",
10.99);