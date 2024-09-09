-- Créer la base de données si elle n'existe pas
CREATE DATABASE IF NOT EXISTS home_cleaning_recipes CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS recette (
    recette_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image_path VARCHAR(255),
    categorie_id INT,
    FOREIGN KEY (categorie_id) REFERENCES categorie(categorie_id) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS ingredient (
    ingredient_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT
);
CREATE TABLE IF NOT EXISTS recette_ingredient (
    recette_id INT,
    ingredient_id INT,
    quantite DECIMAL(5, 2),
    unite_mesure VARCHAR(50),
    FOREIGN KEY (recette_id) REFERENCES recette(recette_id) ON DELETE CASCADE,
    FOREIGN KEY (ingredient_id) REFERENCES ingredient(ingredient_id) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS categorie (
    categorie_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);
