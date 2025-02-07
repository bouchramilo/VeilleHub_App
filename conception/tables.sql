-- Active: 1733819346903@@127.0.0.1@3306@veillehub_db


CREATE DATABASE IF NOT EXISTS VeilleHub_db;

USE VeilleHub_db;



CREATE TABLE users (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('Enseignant', 'Etudiant') NOT NULL,
    is_Vlalide BOOLEAN DEFAULT 0
);
-- avec un trigger pour le cas de enseignant : 
DELIMITER &&

CREATE TRIGGER set_default_validation
BEFORE INSERT ON users
FOR EACH ROW
BEGIN
    IF NEW.role = 'Enseignant' THEN
        SET NEW.is_Vlalide = 1;
    ELSE
        SET NEW.is_Vlalide = 0;
    END IF;
END;
&&

DELIMITER ;


CREATE TABLE sujets (
    id_sujet INT PRIMARY KEY AUTO_INCREMENT,
    id_etudiant INT NOT NULL,
    titre VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NOT NULL,
    date_proposer DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_enseignant INT DEFAULT NULL,
    status ENUM('Proposé', 'Validé', 'Rejeté') DEFAULT 'Proposé',
    FOREIGN KEY (id_etudiant) REFERENCES users(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_enseignant) REFERENCES users(id_user) ON DELETE SET NULL
);

CREATE TABLE calendriers (
    id_etudiant INT NOT NULL,
    id_presentation INT NOT NULL,
    date_de_presentation DATETIME NOT NULL,
    PRIMARY KEY (id_etudiant, id_presentation),
    FOREIGN KEY (id_etudiant) REFERENCES users(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_presentation) REFERENCES presentations(id_presentation) ON DELETE CASCADE
);

CREATE TABLE presentations (
    id_presentation INT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(255) NOT NULL,
    date_realisation DATETIME DEFAULT NULL,
    lien_presentation VARCHAR(255),
    description VARCHAR(255),
    status ENUM('A venir', 'Passé') DEFAULT 'A venir',
    id_enseignant INT NOT NULL,
    FOREIGN KEY (id_enseignant) REFERENCES users(id_user) ON DELETE CASCADE
);

ALTER TABLE presentations ADD COLUMN description VARCHAR(255);
ALTER TABLE presentations 
MODIFY date_realisation DATETIME DEFAULT NULL;


CREATE TABLE notifications (
    id_notification INT PRIMARY KEY AUTO_INCREMENT,
    date_envoi DATETIME NOT NULL,
    email_destination VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    FOREIGN KEY (email_destination) REFERENCES users(email) ON DELETE CASCADE
);


