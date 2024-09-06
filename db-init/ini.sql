-- Créer la base de données si elle n'existe pas
CREATE DATABASE IF NOT EXISTS home_cleaning_recipes CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE home_cleaning_recipes;

-- Table des recettes
CREATE TABLE IF NOT EXISTS recette (
    recette_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    categorie VARCHAR(255),
    image_path VARCHAR(255)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Table des ingrédients
CREATE TABLE IF NOT EXISTS ingredient (
    ingredient_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    unite_mesure VARCHAR(50) NOT NULL
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Table des étapes
CREATE TABLE IF NOT EXISTS etape (
    etape_id INT AUTO_INCREMENT PRIMARY KEY,
    recette_id INT,
    description TEXT NOT NULL,
    ordre INT NOT NULL,
    FOREIGN KEY (recette_id) REFERENCES recette(recette_id) ON DELETE CASCADE
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Table de relation entre recettes et ingrédients (quantités)
CREATE TABLE IF NOT EXISTS recette_ingredient (
    recette_id INT,
    ingredient_id INT,
    quantite DECIMAL(5, 2),
    FOREIGN KEY (recette_id) REFERENCES recette(recette_id) ON DELETE CASCADE,
    FOREIGN KEY (ingredient_id) REFERENCES ingredient(ingredient_id) ON DELETE CASCADE
);

-- Exemple de données initiales pour les recettes
INSERT INTO recette (nom, description, categorie, image_path) VALUES
('Nettoyant multi-usages', 'Un nettoyant maison à base de vinaigre blanc et bicarbonate.', 'Nettoyant', 'images/nettoyant.png'),
('Lessive maison', 'Lessive écologique faite maison.', 'Lessive', 'images/lessive.png');

-- Exemple d'ingrédients
INSERT INTO ingredient (nom, unite_mesure) VALUES
('Vinaigre blanc', 'ml'),
('Bicarbonate de soude', 'g'),
('Savon de Marseille', 'g');

-- Associer des ingrédients à une recette
INSERT INTO recette_ingredient (recette_id, ingredient_id, quantite) VALUES
(1, 1, 500.00), -- Nettoyant multi-usages: 500 ml de vinaigre
(1, 2, 50.00),  -- Nettoyant multi-usages: 50 g de bicarbonate
(2, 3, 100.00); -- Lessive maison: 100 g de savon de Marseille

-- Ajouter des étapes pour les recettes
INSERT INTO etape (recette_id, description, ordre) VALUES
(1, 'Mélanger le vinaigre et le bicarbonate.', 1),
(1, 'Secouer vigoureusement.', 2),
(2, 'Râper le savon de Marseille.', 1),
(2, 'Ajouter de l\'eau chaude et mélanger.', 2);
