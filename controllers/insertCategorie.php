<?php
require_once '../models/CategorieDao.php';

// Créer un objet CategorieDao
$categorieDao = new CategorieDao();

// Créer un objet Categorie
// $categorie = new Categorie(null, "Smartphone");

// liste des categories à inserer
$categories = [
    new Categorie(null, "Livres"),
    new Categorie(null, "Materiel informatique"),
    new Categorie(null, "Tablette"),
   
];

// Inserttion de la categorie
if($categorieDao->ajouterCategorie($categories)) {
    echo "Categorie ajoutée avec succès";
} else {
    echo "Erreur lors de l'ajout de la categorie";
}