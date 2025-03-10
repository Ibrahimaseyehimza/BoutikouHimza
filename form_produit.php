<?php
// Inclure la connexion à la base de données
require_once 'Database.php';
require_once 'include/header.php';

$db = new Database();
$conn = $db->getConnection();

// Récupérer toutes les catégories
$sql = "SELECT * FROM categories";
$stmt = $conn->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Gestion des Catégories</h2>

        <!-- Bouton Ajouter une Catégorie -->
        <div class="mb-3">
            <a href="ajouter_categorie.php" class="btn btn-success">+ Ajouter une Catégorie</a>
        </div>

        <!-- Tableau des Catégories -->
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $categorie): ?>
                    <tr>
                        <td><?= htmlspecialchars($categorie['id']); ?></td>
                        <td><?= htmlspecialchars($categorie['nom']); ?></td>
                        <td>
                            <a href="modifier_categorie.php?id=<?= $categorie['id']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <a href="supprimer_categorie.php?id=<?= $categorie['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer cette catégorie ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
