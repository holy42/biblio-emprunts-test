-- Schéma de la base (MySQL) de l'application Gestion d'une bibliothèque municipale.
CREATE TABLE livres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(120) NOT NULL,
    reference VARCHAR(40) NOT NULL UNIQUE,
    exemplaires INT NOT NULL DEFAULT 0,
    actif TINYINT(1) NOT NULL DEFAULT 1
);

CREATE TABLE adherents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(120) NOT NULL,
    email VARCHAR(160) NOT NULL UNIQUE,
    role VARCHAR(20) NOT NULL DEFAULT 'lecteur',
    mot_de_passe VARCHAR(255) NOT NULL
);

CREATE TABLE emprunts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    livre_id INT NOT NULL,
    adherent_id INT NOT NULL,
    debut DATE NOT NULL,
    fin DATE NOT NULL,
    retour_le DATE NULL,
    quantite INT NOT NULL DEFAULT 1,
    statut VARCHAR(20) NOT NULL DEFAULT 'actif',
    FOREIGN KEY (livre_id) REFERENCES livres(id),
    FOREIGN KEY (adherent_id) REFERENCES adherents(id)
);
