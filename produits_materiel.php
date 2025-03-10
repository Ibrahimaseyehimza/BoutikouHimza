<?php
// Inclure la connexion à la base de données
require_once 'Database.php';
require_once 'include/header.php';

$db = new Database();
$conn = $db->getConnection();

// ID de la catégorie (tu pourrais le récupérer depuis l'URL, par exemple)
$id_categorie = 3; // Exemple avec la catégorie avec ID = 1

// Préparation de la requête
$query = "
    SELECT p.id, p.nom, p.prix, p.description, p.image
    FROM produits p
    JOIN categories c ON p.id_categorie = c.id
    WHERE c.id = :id_categorie;
";

// Exécution de la requête
$stmt = $conn->prepare($query);
$stmt->bindParam(':id_categorie', $id_categorie, PDO::PARAM_INT);
$stmt->execute();

// Récupérer les résultats
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

// On récupére le nom du catégorie dans l'url
// Vérifier si le paramètre 'categorie' existe dans l'URL
if (isset($_GET['categorie'])) {
    $categorie = $_GET['categorie'];  // Récupérer le nom de la catégorie
} else {
    $categorie = 'Aucune catégorie sélectionnée';  // Valeur par défaut si la catégorie n'est pas passée
}





// Afficher les produits

?>
<div class="container py-5">
<h2>Produits - <?= htmlspecialchars($categorie ?? "Tous") ?></h2>
    <div class="row pt-5" id="productList">
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
</div>