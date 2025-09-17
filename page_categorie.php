<?php
// Inclure la connexion à la base de données
require_once 'Database.php';
require_once 'include/header_simple.php';

$db = new Database();
$conn = $db->getConnection();

// Récupérer toutes les catégories
$sql = "SELECT * FROM categories";
$stmt = $conn->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>



    <div class="container">
    <div class=" mt-5">
        <h2 class="text-center mb-4 fw-bold">Gestion des Catégories</h2>

        <!-- Bouton Ajouter une Catégorie -->
        <div class="mb-3 d-flex justify-content-between align-items-end">
            <a href="ajouter_categorie.php" class="btn btn-success" name="add_categorie">+ Ajouter une Catégorie</a>
            <a href="dashbord.php?=" class="btn btn-secondary" name="return">Retourner au dashbord</a>
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
                            <a href="modifier_categorie.php?id=<?= $categorie['id']; ?>" class="btn btn-warning btn-sm" name="modifier">Modifier</a>
                            <a href="supprimer_categorie.php?id=<?= $categorie['id']; ?>" class="btn btn-danger btn-sm" name="supprimer" onclick="return confirm('Voulez-vous vraiment supprimer cette catégorie ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    </div>
    
