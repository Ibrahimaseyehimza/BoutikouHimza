<?php
require_once 'models/ProduitDao.php';
require_once 'models/CategorieDao.php';

// Vérifier si un ID de produit est passé
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$produitDao = new ProduitDao();
$categorieDao = new CategorieDao();

// Récupérer les détails du produit
$produit = $produitDao->getProduitParId($_GET['id']);

// Si le produit n'existe pas, rediriger
if (!$produit) {
    header('Location: index.php');
    exit();
}

// Récupérer la catégorie du produit
$categorie = $categorieDao->getCategorieParId($produit['id_categorie']);
?>

<?php require 'include/header.php'; ?>

    <!-- Contenu principal -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <img src="<?= htmlspecialchars($produit['image']); ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($produit['nom']); ?>">
            </div>
            <div class="col-md-6">
                <h1><?= htmlspecialchars($produit['nom']); ?></h1>
                <p class="text-muted">Catégorie : <?= htmlspecialchars($categorie['nom']); ?></p>
                
                <h3 class="text-primary"><?= number_format($produit['prix'], 2); ?> €</h3>
                
                <div class="mt-4">
                    <h4>Description</h4>
                    <p><?= htmlspecialchars($produit['description']); ?></p>
                </div>
                
               
                
                <div class="mt-4">
                    <button class="btn btn-primary btn-lg">Ajouter au panier</button>
                    <a href="index.php" class="btn btn-secondary btn-lg ms-2">Retour aux produits</a>
                </div>
            </div>
        </div>

        <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">Informations complémentaires</h3>
            <div class="card">
                <div class="card-body">
                    <p class="text-justify">
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                         Soluta iste quos debitis velit, rerum suscipit fuga fugiat,
                          quasi maiores doloremque voluptatibus assumenda tempore,
                           natus libero? Omnis possimus exercitationem vitae sequi?
                    </p>
                    <h2>Garentie</h2>
                    <p class="text-justify">
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                         Soluta iste quos debitis velit, rerum suscipit fuga fugiat,
                          quasi maiores doloremque voluptatibus assumenda tempore,
                           natus libero? Omnis possimus exercitationem vitae sequi?
                    </p>
                    <p class="text-justify">
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                         Soluta iste quos debitis velit, rerum suscipit fuga fugiat,
                          quasi maiores doloremque voluptatibus assumenda tempore,
                           natus libero? Omnis possimus exercitationem vitae sequi?
                    </p>
                </div>
            </div>
        </div>
    </div>
    </div>

<?php require 'include/footer.php'; ?>