<?php
require_once 'Database.php';
require_once 'Produit.php';
// require_once 'include/header.php';

$db = new Database();
$conn = $db->getConnection();

// Vérifier si l'ID du produit est passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_produit = $_GET['id'];

    // Récupérer les détails du produit à partir de l'ID
    $sql = "SELECT * FROM produits WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_produit]);
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si le produit n'est pas trouvé, afficher un message d'erreur
    if (!$produit) {
        die("Produit non trouvé.");
    }

    // Récupérer les catégories pour le menu déroulant
    $sql = "SELECT * FROM categories";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Traitement du formulaire de modification
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nom = trim($_POST['nom']);
        $prix = trim($_POST['prix']);
        $description = trim($_POST['description']);
        $id_categorie = $_POST['id_categorie'];

        if (!empty($nom) && !empty($prix) && !empty($description) && !empty($id_categorie)) {
            // Mettre à jour les informations du produit
            $sql = "UPDATE produits SET nom = ?, prix = ?, description = ?, id_categorie = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$nom, $prix, $description, $id_categorie, $id_produit]);

            // Redirection après la mise à jour
            header("Location: page_produits.php");
            exit();
        } else {
            $erreur = "Veuillez remplir tous les champs.";
        }
    }
} else {
    die("ID de produit manquant.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    


    
<!-- Bouton Ajouter une Produits -->
 <div class="content py-5 ">
    <div class="container">
        
<!-- Formulaire pour modifier le produit -->
    <h2 class="text-center fw-bold">Modifier le Produit</h2>

    <?php if (isset($erreur)) : ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erreur); ?></div>
    <?php endif; ?>

    <form method="POST" class="p-4 border rounded shadow-sm bg-light">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom du Produit :</label>
            <input type="text" id="nom" name="nom" class="form-control" value="<?= htmlspecialchars($produit['nom']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="prix" class="form-label">Prix :</label>
            <input type="number" id="prix" name="prix" class="form-control" value="<?= htmlspecialchars($produit['prix']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description :</label>
            <textarea id="description" name="description" class="form-control" required><?= htmlspecialchars($produit['description']); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="id_categorie" class="form-label">Catégorie :</label>
            <select id="id_categorie" name="id_categorie" class="form-select" required>
                <?php foreach ($categories as $categorie) : ?>
                    <option value="<?= $categorie['id']; ?>" <?= $categorie['id'] == $produit['id_categorie'] ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($categorie['nom']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success">Modifier</button>
            <a href="page_produits.php?=" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
    </div>
</div>
