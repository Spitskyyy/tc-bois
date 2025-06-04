-- Création de la base de données
CREATE DATABASE IF NOT EXISTS tc_bois;
USE tc_bois;

-- Table des utilisateurs
CREATE TABLE IF NOT EXISTS tbl_user (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nom_user VARCHAR(100) NOT NULL,
    prenom_user VARCHAR(100) NOT NULL,
    mail_user VARCHAR(255) UNIQUE NOT NULL,
    phone_user VARCHAR(20) NOT NULL,
    password_user VARCHAR(255) NOT NULL
);

-- Table des rôles
CREATE TABLE IF NOT EXISTS tbl_role (
    id_r INT AUTO_INCREMENT PRIMARY KEY,
    name_r VARCHAR(50) NOT NULL
);

-- Table de liaison user-role
CREATE TABLE IF NOT EXISTS tbl_user_role (
    id_user_role INT AUTO_INCREMENT PRIMARY KEY,
    id_user_user INT NOT NULL,
    id_r_role INT NOT NULL,
    FOREIGN KEY (id_user_user) REFERENCES tbl_user(id_user),
    FOREIGN KEY (id_r_role) REFERENCES tbl_role(id_r)
);

-- Table des produits
CREATE TABLE IF NOT EXISTS tbl_product (
    id_product INT AUTO_INCREMENT PRIMARY KEY,
    name_product VARCHAR(255) NOT NULL,
    essence_product VARCHAR(100),
    description_product TEXT,
    quantity_product INT,
    image_path_product VARCHAR(255)
);

-- Table des dimensions
CREATE TABLE IF NOT EXISTS tbl_dimension (
    id_dimension INT AUTO_INCREMENT PRIMARY KEY,
    length_dimension DECIMAL(10,2),
    width_dimension DECIMAL(10,2),
    thickness_dimension DECIMAL(10,2)
);

-- Table de liaison produit-dimension
CREATE TABLE IF NOT EXISTS tbl_product_dimension (
    id_product_dimension INT AUTO_INCREMENT PRIMARY KEY,
    id_product_product INT NOT NULL,
    id_dimension_dimension INT NOT NULL,
    FOREIGN KEY (id_product_product) REFERENCES tbl_product(id_product),
    FOREIGN KEY (id_dimension_dimension) REFERENCES tbl_dimension(id_dimension)
);

-- Table des types de produits
CREATE TABLE IF NOT EXISTS tbl_type_of_product (
    id_type_of_product INT AUTO_INCREMENT PRIMARY KEY,
    libelle_type_of_product VARCHAR(50) NOT NULL
);

-- Table de liaison produit-type
CREATE TABLE IF NOT EXISTS tbl_product_type_of_product (
    id_product_type INT AUTO_INCREMENT PRIMARY KEY,
    id_product_product INT NOT NULL,
    id_type_of_product_type_of_product INT NOT NULL,
    FOREIGN KEY (id_product_product) REFERENCES tbl_product(id_product),
    FOREIGN KEY (id_type_of_product_type_of_product) REFERENCES tbl_type_of_product(id_type_of_product)
);

-- Table des activités
CREATE TABLE IF NOT EXISTS tbl_activity (
    id_activity INT AUTO_INCREMENT PRIMARY KEY,
    name_activity VARCHAR(255) NOT NULL,
    detail_activity TEXT,
    image_path_product VARCHAR(255)
);

-- Insertion des types de produits
INSERT INTO tbl_type_of_product (libelle_type_of_product) VALUES
('bardage'),
('terrasse'),
('charpente'),
('cloture'),
('osb'),
('quincaillerie');

-- Insertion des rôles
INSERT INTO tbl_role (name_r) VALUES
('USER'),
('PRO'); 

-- Table des styles
CREATE TABLE IF NOT EXISTS tbl_style (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name_style VARCHAR(100) NOT NULL
);

-- Table de liaison produit-style
CREATE TABLE IF NOT EXISTS tbl_style_product (
    id_style_product INT AUTO_INCREMENT PRIMARY KEY,
    id_product_product INT NOT NULL,
    id_style_style INT NOT NULL,
    FOREIGN KEY (id_product_product) REFERENCES tbl_product(id_product),
    FOREIGN KEY (id_style_style) REFERENCES tbl_style(id)
);


-- Index pour optimiser les recherches
CREATE INDEX idx_product_name ON tbl_product(name_product);
CREATE INDEX idx_product_type ON tbl_type_of_product(libelle_type_of_product);
CREATE INDEX idx_user_email ON tbl_user(mail_user);