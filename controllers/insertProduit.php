<?php
require_once '../models/ProduitDao.php';

// require_once  '../Database.php';
// require_once '../Produit.php';
// require_once '../ProduitDao.php';

// Créer un objet ProduitDao
$produitDao = new ProduitDao();

// Liste des produits à insérer
$produits = [
    new Produit(null, "PHP MYSQL", 250, "Créer des application web avec php et mysql", "img/php_mysql.jpeg", 1),
    new Produit(null, "Livre PYTHON", 250, "Appprendre à programmer en python", "img/python.jpeg", 1),
    new Produit(null, "Algorithme", 250, "Les concepts fondamentaux d'algorithme", "img/algorithme.jpeg", 1),
    new Produit(null, "Colier chaine", 25, "Colier pour homme 100% chic ", "img/accesoir14jpg.jpg", 2),
    new Produit(null, "Cassie Ring", 30, "Cassi pour femme 100% OG ", "img/accesoir1.jpg", 2),
    new Produit(null, "Bracelets", 30, "Trio de bracelet en pierre naturel ensemble ", "img/accesoir13jpg.jpg", 2),
    new Produit(null, "Colliets", 30, "Colliet Blanc pour homme/femme ", "img/accesoir12jpg.jpg", 2),
    new Produit(null, "Ordinateur", 250, "Ordinateur de himza", "img/image_dev2.webp", 3),
    new Produit(null, "Ordinateur", 75, "Hp helitebook i5 16go ", "img/ordinateur.jpg", 3),
    new Produit(null, "Souri", 5, "Souri perment en OG ", "img/souris.jpg", 3),
    new Produit(null, "Clavier", 10, "Clavier azerty ", "img/clavier.jpg", 3),
    new Produit(null, "Imprimente", 15, "Imprimente ultra rapide  ", "img/imprimente.jpg", 3),
];

// Insertion des produits
$produitsAjoutes = 0;

foreach ($produits as $produit) {
    if (!$produitDao->produitExiste($produit->getNom())) {
        if ($produitDao->ajouterProduit($produit)) {
            echo "Produit '{$produit->getNom()}' ajouté avec succès.<br>";
            $produitsAjoutes++;
        } else {
            echo "Erreur lors de l'ajout du produit '{$produit->getNom()}'.<br>";
        }
    } else {
        echo "Le produit '{$produit->getNom()}' existe déjà.<br>";
    }
}

if ($produitsAjoutes > 0) {
    echo "<br>Insertion terminée : {$produitsAjoutes} produit(s) ajouté(s).";
} else {
    echo "<br>Aucun produit ajouté car tous existent déjà.";
}
