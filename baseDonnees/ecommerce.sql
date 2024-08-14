CREATE DATABASE ecommerce1;
USE ecommerce1;


CREATE TABLE categories (
    id INT(11) NOT NULL AUTO_INCREMENT,
    libelle VARCHAR(255) NOT NULL,
    description TEXT NULL,
    icone VARCHAR(255) NULL,
    date_creation TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);


INSERT INTO categories (libelle, description, icone, date_creation) VALUES
('Catégorie 1', 'Description de la catégorie 1', 'icone1.png', NOW()),
('Catégorie 2', 'Description de la catégorie 2', 'icone2.png', NOW());


CREATE TABLE commande (
    id INT(11) NOT NULL AUTO_INCREMENT,
    id_client INT(11) NOT NULL,
    total DECIMAL(10, 0) NOT NULL,
    valide INT(11) NOT NULL DEFAULT 0,
    date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50) NOT NULL DEFAULT 'en attente',
    PRIMARY KEY (id)
);

INSERT INTO commande (id_client, total, valide, date_creation, status) VALUES
(1, 150, 1, NOW(), 'validée'),
(2, 300, 0, NOW(), 'en attente');


CREATE TABLE produit (
    id INT(11) NOT NULL AUTO_INCREMENT,
    libelle VARCHAR(100) NOT NULL,
    prix DECIMAL(10, 0) NOT NULL,
    discount INT(11) NULL,
    id_categorie INT(11) NOT NULL,
    date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    description TEXT NULL,
    image VARCHAR(255) NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_categorie) REFERENCES categories(id)
);


INSERT INTO produit (libelle, prix, discount, id_categorie, date_creation, description, image) VALUES
('Produit 1', 100, 10, 1, NOW(), 'Description du produit 1', 'image1.png'),
('Produit 2', 200, 20, 2, NOW(), 'Description du produit 2', 'image2.png');


CREATE TABLE ligne_commande (
    id INT(11) NOT NULL AUTO_INCREMENT,
    id_produit INT(11) NOT NULL,
    id_commande INT(11) NOT NULL,
    prix DECIMAL(10, 0) NOT NULL,
    quantite INT(11) NOT NULL,
    total DECIMAL(10, 0) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_produit) REFERENCES produit(id),
    FOREIGN KEY (id_commande) REFERENCES commande(id)
);

CREATE TABLE cartes_credit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_commande INT NOT NULL,
    numero_carte VARCHAR(16) NOT NULL,
    date_expiration VARCHAR(5) NOT NULL,
    cvc VARCHAR(3) NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_commande) REFERENCES commande(id)
);



INSERT INTO ligne_commande (id_produit, id_commande, prix, quantite, total) VALUES
(1, 1, 90, 2, 180),
(2, 2, 180, 1, 180);


CREATE TABLE utilisateur (
    id INT(11) NOT NULL AUTO_INCREMENT,
    login VARCHAR(100) NOT NULL,
    password VARCHAR(150) NOT NULL,
    date_creation DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    PRIMARY KEY (id)
);


INSERT INTO utilisateur (login, password, date_creation, date, role) VALUES
('simo', '123456', '2022-10-30', NOW(), 'user'),
('admin', '123456789', '2022-10-30', NOW(), 'admin'),
('mjamaoui', 'mjamaoui', '2022-11-02', NOW(), 'user'),
('ayoub', '123', '0000-00-00', NOW(), 'user');