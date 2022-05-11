CREATE TABLE books
(
    id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(50),
    detail TEXT,
    author VARCHAR(50),
    class VARCHAR(20),
    genre VARCHAR(20),
    price FLOAT,
    img VARCHAR(150),
    PRIMARY KEY (id)
);

CREATE TABLE users
(
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(30),
    phone VARCHAR(30),
    email VARCHAR(30),
    password TEXT,
    admin CHAR(1) DEFAULT 'N' CHECK (admin IN ('Y', 'N')),
    PRIMARY KEY (id)
);

CREATE TABLE orders
(
    id INT NOT NULL AUTO_INCREMENT,
    bookid INT NOT NULL,
    userid INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (bookid) REFERENCES books(id) ON DELETE CASCADE,
    FOREIGN KEY (userid) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO books (title, detail, author, class, genre, price, img)
VALUES ("Harry Potter and the Sorcerers Stone",
"Harry Potter, a young wizard who travels to Hogwarts to learn about Witchcraft and Wizardry.",
"J. K. Rowling",
"fiction",
"prize",
10.99,
"https://images-na.ssl-images-amazon.com/images/I/81iqZ2HHD-L.jpg"),
("Introductory Statistics",
"Covering basics to complicated statistical analysis.",
"Robert Gould",
"school",
"math",
35.45,
"https://images-na.ssl-images-amazon.com/images/I/91WU1DwWflL.jpg"),
("A Book of Middle English",
"The fourth edition of this essential Middle English textbook introduces students to the wide range of literature written in England between 1150 and 1400.",
"Thorlac Turville-Petre",
"school",
"english",
23.89,
"https://images-na.ssl-images-amazon.com/images/I/71N1Bjgp1tL.jpg"),
("I Explore: A Science Textbook 6",
"The 6th book in a series aiming to hone and develop scientific skills and 21st century skills at the beginning of the primary level.",
"Shobhita Johari",
"school",
"math",
35.45,
"https://images-na.ssl-images-amazon.com/images/I/71kQwd3qysL.jpg"),
("Infinite Jest",
"An adventure story with interwoven narratives united by the goal of searching for the Infinite Jest.",
"David Foster Wallace",
"fiction",
"arrivals",
5.95,
"https://images-na.ssl-images-amazon.com/images/I/71t9YpiAduL.jpg"),
("The Underground Railroad",
"Award winning book that tells the story of Cora and her quest for freedom.",
"David Foster Wallace",
"fiction",
"prize",
15.00,
"https://images-na.ssl-images-amazon.com/images/I/A1Cu4ywUeyL.jpg");