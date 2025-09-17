<?php
// Inclure la connexion à la base de données
require_once 'Database.php';
require_once 'include/header_simple.php';

$db = new Database();
$conn = $db->getConnection();


// Récupérer tous les produits
$sql = "SELECT * FROM produits";
$stmt = $conn->prepare($sql);
$stmt->execute();
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


    


    
<!-- Bouton Ajouter une Produits -->
 <div class="content py-5 ">
 

    <div class="container">
    <h2 class="text-center fw-bold">Liste des Produits</h2>

<?php if (isset($_GET['message'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_GET['message']); ?></div>
<?php endif; ?>
        <div class="mb-3 d-flex justify-content-between align-items-end">
                <a href="ajouter_produit.php?=" class="btn btn-success" name="add_produit">+ Ajouter un Produit</a>
                <a href="dashbord.php?=" class="btn btn-secondary" name="return">Retourner au dashbord</a>
        </div>
        <div class="">
                
        </div>
    <table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prix</th>
            <th>Description</th>
            <th>Image</th>
            <th>Catégorie</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($produits as $produit): ?>
            <tr>
                <td><?= htmlspecialchars($produit['id']); ?></td>
                <td><?= htmlspecialchars($produit['nom']); ?></td>
                <td><?= htmlspecialchars($produit['prix']); ?> €</td>
                <td><?= htmlspecialchars($produit['description']); ?></td>
                <td><img src="<?= htmlspecialchars($produit['image']); ?>" alt="Image du produit" width="100"></td>
                <td>
                    <?php
                    // Récupérer la catégorie à partir de l'ID de catégorie
                    $sql_cat = "SELECT nom FROM categories WHERE id = ?";
                    $stmt_cat = $conn->prepare($sql_cat);
                    $stmt_cat->execute([$produit['id_categorie']]);
                    $categorie = $stmt_cat->fetch(PDO::FETCH_ASSOC);
                    echo htmlspecialchars($categorie['nom']);
                    ?>
                </td>
                <td>
                    <!-- Bouton modifier -->
                    <a href="modifier_produits.php?id=<?= $produit['id']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                    
                    <!-- Bouton supprimer -->
                    <a href="supprimer_produits.php?id=<?= $produit['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
        
    </div>

</body>
</html>
