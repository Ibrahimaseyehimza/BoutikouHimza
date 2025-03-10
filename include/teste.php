<?php
require_once '../Database.php';
require_once '../models/ProduitDao.php';
require_once '../models/CategorieDao.php';

// Créer des objets DAO
$produitDao = new ProduitDao();
$categorieDao = new CategorieDao();

// Récupérer toutes les catégories
$categories = $categorieDao->getCategories();

// Vérifier si une catégorie est sélectionnée
$idCategorie = isset($_GET['categorie']) ? $_GET['categorie'] : null;

// Récupérer les produits en fonction de la catégorie sélectionnée
$produits = ($idCategorie) ? $produitDao->getProduitsParCategorie($idCategorie) : $produitDao->getProduits();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini E-commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Barre de navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Mini E-commerce</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?= !$idCategorie ? 'active' : ''; ?>" href="index.php">Tous les produits</a>
                </li>
                <?php foreach ($categories as $categorie) { ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($idCategorie == $categorie['id']) ? 'active' : ''; ?>" href="index.php?categorie=<?= $categorie['id']; ?>">
                            <?= htmlspecialchars($categorie['nom']); ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Contenu principal -->
<div class="container mt-5">
    <h1 class="text-center mb-4">Nos Produits</h1>

    <!-- Affichage des produits -->
    <div class="row">
        <?php if (count($produits) > 0) { ?>
            <?php foreach ($produits as $produit) { ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img src="<?= htmlspecialchars($produit['image']); ?>" class="card-img-top" alt="<?= htmlspecialchars($produit['nom']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($produit['nom']); ?></h5>
                            <p class="card-text"><?= htmlspecialchars($produit['description']); ?></p>
                            <p class="card-text"><strong>Prix : </strong><?= number_format($produit['prix'], 2); ?> €</p>
                            <a href="#" class="btn btn-primary">Acheter</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p class="text-center">Aucun produit trouvé dans cette catégorie.</p>
        <?php } ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
