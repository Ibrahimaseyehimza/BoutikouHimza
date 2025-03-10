-- Table des catégories
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE
);

-- Table des produits
CREATE TABLE produits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255),
    id_categorie INT NOT NULL,
    FOREIGN KEY (id_categorie) REFERENCES categories(id) ON DELETE CASCADE
);

CREATE TABLE utilisateurs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    prenom VARCHAR(100),
    email VARCHAR(50) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(60) NOT NULL,
    mot_de_passeConfirm VARCHAR(60) NOT NULL
); 

CREATE TABLE details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_produit INT NOT NULL,
    details TEXT,
    FOREIGN KEY (id_produit) REFERENCES produits(id) ON DELETE CASCADE
);

CREATE TABLE commandes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    date_commande DATETIME DEFAULT CURRENT_TIMESTAMP,
    statut ENUM('En attente', 'Payée', 'Expédiée', 'Livrée') DEFAULT 'En attente',
    adresse_livraison TEXT NOT NULL
);
CREATE TABLE details_commandes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    commande_id INT NOT NULL,
    produit_id INT NOT NULL,
    quantite INT NOT NULL,
    prix_unitaire DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (commande_id) REFERENCES commandes(id),
    FOREIGN KEY (produit_id) REFERENCES produits(id)
);



ALTER TABLE produits ADD COLUMN date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

