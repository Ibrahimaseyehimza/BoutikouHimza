<?php
require_once 'Database.php';
require_once 'include/header_simple.php';

$db = new Database();
$conn = $db->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST['nom']);

    if (!empty($nom)) {
        // Insérer la nouvelle catégorie dans la base de données
        $sql = "INSERT INTO categories (nom) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nom]);

        // Rediriger vers la liste des catégories après ajout
        header("Location: page_categorie.php");
        exit();
    } else {
        $error = "Le champ ne peut pas être vide.";
    }
}
?>


<body>
    <div class="container mt-5">
        <h2 class="text-center">Ajouter une Nouvelle Catégorie</h2>

        <?php if (isset($error)) : ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" class="p-4 border rounded shadow-sm bg-light">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom de la Catégorie :</label>
                <input type="text" id="nom" name="nom" class="form-control" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success" name="ajouter">Ajouter</button>
                <a href="categories.php" class="btn btn-secondary" name="annuler">Annuler</a>
            </div>
        </form>
    </div>

