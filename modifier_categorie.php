<?php
require_once 'Database.php';
require_once 'include/header.php';

$db = new Database();
$conn = $db->getConnection();

// Vérifier si un ID est fourni dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de catégorie manquant.");
}

$id = $_GET['id'];

// Récupérer les infos de la catégorie
$sql = "SELECT * FROM categories WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$categorie = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier si la catégorie existe
if (!$categorie) {
    die("Catégorie introuvable.");
}

// Traitement du formulaire de modification
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];

    if (!empty($nom)) {
        $sql = "UPDATE categories SET nom = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nom, $id]);
        header("Location: categories.php"); // Redirection après modification
        exit();
    } else {
        echo "<p class='text-danger'>Veuillez remplir le champ.</p>";
    }
}
?>


    <div class="container mt-5">
        <h2 class="text-center">Modifier la Catégorie</h2>
        
        <form method="POST" class="p-4 border rounded shadow-sm bg-light">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom de la Catégorie :</label>
                <input type="text" id="nom" name="nom" class="form-control" value="<?= htmlspecialchars($categorie['nom']); ?>" required>
            </div>

            <div class="text-center">
                <a href="page_categorie.php?id=<?= $categorie['id']; ?>" type="submit" class="btn btn-primary" name="modifier_categorie">Modifier</a>
                <a href="page_categorie.php?=" class="btn btn-secondary" name="annuler_categorie">Annuler</a>
            </div>
        </form>
    </div>

