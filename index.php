<?php
// Démarrer la session pour le panier
session_start();
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// Inclusion des fichiers nécessaires
require_once 'models/ProduitDao.php';
require_once 'models/CategorieDao.php';

// Création des objets DAO
$produitDao = new ProduitDao();
$categorieDao = new CategorieDao();

// Récupérer toutes les catégories
$categories = $categorieDao->getCategories();

// Vérifier si une catégorie est sélectionnée et sécuriser l'entrée
$idCategorie = isset($_GET['categorie']) ? intval($_GET['categorie']) : null;

// Récupérer les produits en fonction de la catégorie sélectionnée
$produits = ($idCategorie) ? $produitDao->getProduitsParCategorie($idCategorie) : $produitDao->getProduits();

// Les nouveaux produits
$nouveauxProduits = $produitDao->getNouveauxProduits();
?>

<?php require 'include/header.php'; ?>

<div class="container">
    <div class="row gy-4 gy-md-0 align-items-center py-5">
        <div class="col-12 col-md-6">
            <h1 class="fw-bold">"Le shop malin des étudiants – Trouve tout, paye moins !" 🎓🛒</h1>
            <a href="#produits" type="button" class="btn btn-warning mt-5">Découvrir nos produits</a>
        </div>
        <div class="col">
            <img class="img-fluid w-70 h-20" src="img/accueil_img.jpg" style="object-fit: cover; height: 450px; width: 100%;" alt="image de himza">
        </div>
    </div>
</div>

<!-- Nouveau Produits -->
 <div class="container mt-5">
    <h2 class="text-center fw-bold mb-4">🆕 Nouveaux Produits</h2>
    <div class="row">
        <?php foreach ($nouveauxProduits as $produit) { ?>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <img src="<?= htmlspecialchars($produit['image']); ?>" class="img-fluid" style="object-fit: contain; width: 100%; height: 250px;" alt="<?= htmlspecialchars($produit['nom']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($produit['nom']); ?></h5>
                        <p class="card-text"><strong>Prix :</strong> <?= number_format($produit['prix'], 2); ?> €</p>
                        <div class="d-flex align-items-center">
                            <form method="POST" action="ajouter_au_panier.php" class="mb-2">
                                <input type="hidden" name="id_produit" value="<?= $produit['id']; ?>">
                                <input type="hidden" name="quantite" value="1">
                                <button class="btn btn-warning" type="submit">Ajouter au panier</button>
                            </form>
                            <a href="details.php?id=<?= $produit['id']; ?>" class="btn btn-warning" id="voir_details">Voir les détails</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>



<!-- Contenu principal -->
<div class="container mt-5">
    <h1 id="produits" class="text-center fw-bold mb-4">Nos Produits</h1>

    <!-- Formulaire de filtre par catégorie -->
    <form id="filterForm" class="mb-4">
        <div class="row">
            <div class="col-md-4 shadow-sm">
                <select name="categorie" id="categoryFilter" class="form-select">
                    <option value="">Toutes les catégories</option>
                    <?php foreach ($categories as $categorie) { ?>
                        <option value="<?= $categorie['id']; ?>" <?= ($idCategorie == $categorie['id']) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($categorie['nom']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </form>

    <!-- Conteneur pour l'affichage des produits -->
    <div class="row" id="productList">
        <?php foreach ($produits as $produit) { ?>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <img src="<?= htmlspecialchars($produit['image']); ?>" class="img-fluid" style="object-fit: contain; width: 100%; height: 300px;" alt="<?= htmlspecialchars($produit['nom']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($produit['nom']); ?></h5>
                        <p class="card-text"><?= htmlspecialchars($produit['description']); ?></p>
                        <p class="card-text"><strong>Prix :</strong> <?= number_format($produit['prix'], 2); ?> €</p>
                        <div class="d-flex align-items-center">
                            <form method="POST" action="ajouter_au_panier.php" class="mb-2">
                                <input type="hidden" name="id_produit" value="<?= $produit['id']; ?>">
                                <input type="hidden" name="quantite" value="1" min="1">
                                <button class="btn btn-warning" type="submit">Ajouter au panier</button>
                            </form>
                            <a href="details.php?id=<?= $produit['id']; ?>" class="btn btn-warning" id="voir_details">Voir les détails</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php require 'include/footer.php'; ?>

<!-- Inclusion de jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    function loadProducts(category) {
        $.ajax({
            url: "fetch_products.php", // Fichier qui récupère les produits
            type: "POST",
            data: { categorie: category },
            beforeSend: function () {
                $("#productList").html("<p class='text-center'>Chargement des produits...</p>");
            },
            success: function (response) {
                $("#productList").html(response);
            },
            error: function () {
                alert("Erreur lors du chargement des produits.");
            }
        });
    }

    // Charger les produits au chargement de la page
    loadProducts($("#categoryFilter").val());

    // Filtrer les produits lors du changement de catégorie
    $("#categoryFilter").change(function () {
        var selectedCategory = $(this).val();
        loadProducts(selectedCategory);
    });
});
</script>
