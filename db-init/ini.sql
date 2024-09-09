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
    image_path VARCHAR(255),
    categorie_id INT,
    FOREIGN KEY (categorie_id) REFERENCES categorie(categorie_id) ON DELETE CASCADE
);

-- Table des ingrédients
CREATE TABLE IF NOT EXISTS ingredient (
    ingredient_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT
);

-- Table de relation entre recettes et ingrédients (quantités)
CREATE TABLE IF NOT EXISTS recette_ingredient (
    recette_id INT,
    ingredient_id INT,
    quantite DECIMAL(5, 2),
    unite_mesure VARCHAR(50),
    FOREIGN KEY (recette_id) REFERENCES recette(recette_id) ON DELETE CASCADE,
    FOREIGN KEY (ingredient_id) REFERENCES ingredient(ingredient_id) ON DELETE CASCADE
);

-- Ajouter des catégories de test
INSERT INTO categorie (nom) VALUES ('Cuisine'), ('Salle de bain'), ('WC');

-- Ajouter des ingrédients de test
INSERT INTO ingredient (nom, description) VALUES 
('Vinaigre blanc', 'Un excellent nettoyant naturel.'),
('Bicarbonate de soude', 'Utilisé pour dégraisser et désodoriser.');

-- Ajouter une recette de test
INSERT INTO recette (nom, description, image_path, categorie_id) VALUES 
('Nettoyant multi-usages', 'Un nettoyant maison à base de vinaigre et bicarbonate.', 'images/nettoyant.png', 1);

-- Associer les ingrédients à la recette
INSERT INTO recette_ingredient (recette_id, ingredient_id, quantite, unite_mesure) VALUES 
(1, 1, 40, 'ml'),  -- 500ml de vinaigre blanc
(1, 2, 50, 'g');     -- 50g de bicarbonate de soude
