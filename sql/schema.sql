-- Suppression et création de la base de données
DROP DATABASE Supercar;
CREATE DATABASE SuperCar;
USE SuperCar;

-- Table des marques de voitures
CREATE TABLE marques(
   id_marque INT AUTO_INCREMENT,
   nom_marque VARCHAR(200) NOT NULL,
   PRIMARY KEY(id_marque)
);

-- Table des voitures disponibles
CREATE TABLE voiture(
   idvoiture INT AUTO_INCREMENT PRIMARY KEY,
   modele VARCHAR(100) NOT NULL,
   prix DECIMAL(15, 2) NOT NULL CHECK (prix >= 0),
   datesortie DATE NOT NULL,
   kilometrage INT NOT NULL,
   disponibilite BOOLEAN NOT NULL,
   boite_de_vitesse VARCHAR(50) NOT NULL,
   carburant VARCHAR(50) NOT NULL,
   puissance INT,
   couleur VARCHAR(100),
   provenance VARCHAR(100),
   details TEXT,
   id_marque INT NOT NULL,
   FOREIGN KEY(id_marque) REFERENCES marques(id_marque)
);

-- Table des images associées aux voitures
CREATE TABLE image(
   id_image INT AUTO_INCREMENT PRIMARY KEY,
   url_image VARCHAR(255) NOT NULL,
   idvoiture INT NOT NULL,
   priorite TINYINT(1),
   FOREIGN KEY(idvoiture) REFERENCES voiture(idvoiture) ON DELETE CASCADE
);

-- Table des clients
CREATE TABLE client(
   id_client INT AUTO_INCREMENT PRIMARY KEY,
   nom VARCHAR(100) NOT NULL,
   prenom VARCHAR(100) NOT NULL,
   mail VARCHAR(150) NOT NULL UNIQUE,
   telephone VARCHAR(50),
   adresse VARCHAR(255)
);

-- Table des informations de connexion des clients
CREATE TABLE login(
   id_login INT AUTO_INCREMENT PRIMARY KEY,
   id_client INT NOT NULL,
   mot_de_passe VARCHAR(255) NOT NULL,
   role VARCHAR(50) DEFAULT 'user',
   date_inscription DATE ,
   FOREIGN KEY(id_client) REFERENCES client(id_client) ON DELETE CASCADE
);

-- Table des administrateurs
CREATE TABLE admin(
   id_admin INT AUTO_INCREMENT PRIMARY KEY,
   nom VARCHAR(100) NOT NULL,
   prenom VARCHAR(100) NOT NULL,
   mail VARCHAR(150) NOT NULL UNIQUE,
   mot_de_passe VARCHAR(255) NOT NULL
);

-- Table des services proposés
CREATE TABLE service(
   id_service INT AUTO_INCREMENT PRIMARY KEY,
   nom_service VARCHAR(60) NOT NULL,
   titre_service VARCHAR(100) NOT NULL,
   description_service TEXT,
   prix_service DECIMAL(15, 2) NOT NULL CHECK (prix_service >= 0),
   image_service VARCHAR(255)
);

-- Table des demandes d'essai de voitures
CREATE TABLE demande_essai(
   id_demande INT AUTO_INCREMENT PRIMARY KEY,
   date_essai DATE NOT NULL,
   statut ENUM('en_cours', 'valide', 'annule') NOT NULL,
   idvoiture INT NOT NULL,
   id_client INT NOT NULL,
   date_demande DATE NOT NULL CURRENT_TIMESTAMP,
   FOREIGN KEY(idvoiture) REFERENCES voiture(idvoiture),
   FOREIGN KEY(id_client) REFERENCES client(id_client)
);

-- Table du contenu dynamique du site (pages, textes)
CREATE TABLE contenu(
   id_contenu INT AUTO_INCREMENT PRIMARY KEY,
   lignecontenu INT,
   titre VARCHAR(200) NOT NULL,
   texte TEXT,
   page VARCHAR(100)
);

-- Table des messages envoyés (contact)
CREATE TABLE message(
   id_message INT AUTO_INCREMENT PRIMARY KEY,
   nom VARCHAR(100),
   prenom VARCHAR(100),
   email VARCHAR(150),
   telephone VARCHAR(50),
   message TEXT NOT NULL,
   date_envoi DATETIME DEFAULT CURRENT_TIMESTAMP,
   id_client INT,
   FOREIGN KEY(id_client) REFERENCES client(id_client) ON DELETE CASCADE
);

-- Table de liaison entre voitures et services (relation plusieurs-à-plusieurs)
CREATE TABLE approprier(
   idvoiture INT,
   id_service INT,
   PRIMARY KEY(idvoiture, id_service),
   FOREIGN KEY(idvoiture) REFERENCES voiture(idvoiture) ON DELETE CASCADE,
   FOREIGN KEY(id_service) REFERENCES service(id_service) ON DELETE CASCADE
);