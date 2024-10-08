CREATE DATABASE IF NOT EXISTS home_cleaning_recipes CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE home_cleaning_recipes;

-- Table des catégories 
CREATE TABLE IF NOT EXISTS categorie (
    categorie_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);

-- Table des recettes
CREATE TABLE IF NOT EXISTS recette (
    recette_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    etapes TEXT NOT NULL,  
    categorie_id INT,
    FOREIGN KEY (categorie_id) REFERENCES categorie(categorie_id) ON DELETE CASCADE
);

-- Table des ingrédients
CREATE TABLE IF NOT EXISTS ingredient (
    ingredient_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT
);

-- Table de relation entre recettes et ingrédients 
CREATE TABLE IF NOT EXISTS recette_ingredient (
    recette_id INT,
    ingredient_id INT,
    quantite DECIMAL(5, 2),
    unite_mesure VARCHAR(50),
    FOREIGN KEY (recette_id) REFERENCES recette(recette_id) ON DELETE CASCADE,
    FOREIGN KEY (ingredient_id) REFERENCES ingredient(ingredient_id) ON DELETE CASCADE
);


INSERT INTO categorie (nom) VALUES ('Cuisine'), ('Salle de bain'), ('WC');

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

