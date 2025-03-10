<?php
require_once 'models/ProduitDao.php';

$produitDao = new ProduitDao();
$idCategorie = isset($_POST['categorie']) ? intval($_POST['categorie']) : null;

$produits = ($idCategorie) ? $produitDao->getProduitsParCategorie($idCategorie) : $produitDao->getProduits();

if (count($produits) > 0) { ?>
    <div class="row"> <!-- ✅ Ajout de la classe row -->
        <?php foreach ($produits as $produit) { ?>
            <div class="col-md-4"> <!-- ✅ Chaque produit prend 1/3 de la largeur -->
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
    </div> <!-- ✅ Fermeture de la row -->
<?php } else {
    echo "<p class='text-center'>Aucun produit trouvé dans cette catégorie.</p>";
}
?>




