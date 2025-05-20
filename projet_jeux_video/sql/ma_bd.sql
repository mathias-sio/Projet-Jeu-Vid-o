-- Crée la base de données
CREATE DATABASE IF NOT EXISTS ma_bd DEFAULT CHARACTER SET utf8mb4;

-- Utilise la base
USE ma_bd;

-- -- Crée l'utilisateur s'il n'existe pas
-- CREATE USER IF NOT EXISTS 'Assane'@'localhost' IDENTIFIED BY 'btsinfo';
-- GRANT ALL PRIVILEGES ON ma_bd.* TO 'Assane'@'localhost';
-- FLUSH PRIVILEGES;
CREATE TABLE IF NOT EXISTS assistance (
    idOS INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(100) NOT NULL,
    probléme_technique VARCHAR(255),                      
    probléme_de_connexion VARCHAR(255), 
    description TEXT NOT NULL,
    nom_service VARCHAR(255)

);
--ALTER TABLE assistance MODIFY COLUMN description TEXT DEFAULT '';
--ALTER TABLE assistance MODIFY COLUMN description TEXT NULL;
--INSERT INTO assistance (nom_service, type) VALUES ('Problème de connexion', 'technique');
--INSERT INTO assistance (nom_service, type) VALUES ('Problème de mot de passe', 'technique');
-- Crée la table des tickets
CREATE TABLE IF NOT EXISTS tickets (
    idT INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    email VARCHAR(255) NOT NULL,
    categorie VARCHAR(255) NOT NULL,
    date_demande VARCHAR(100) NOT NULL,
    idOS INT NOT NULL,
    statut ENUM('ouvert', 'fermé', 'en cours') DEFAULT 'ouvert',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idOS) REFERENCES assistance(idOS)
);

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,       
    mot_de_passe VARCHAR(255) NOT NULL,
    nom VARCHAR(255),                     
    email VARCHAR(255),                     
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  
);




