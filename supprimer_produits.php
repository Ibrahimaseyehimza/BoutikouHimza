<?php
require_once 'Database.php';

// Vérifier si l'ID du produit est passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_produit = $_GET['id'];

    // Connexion à la base de données
    $db = new Database();
    $conn = $db->getConnection();

    // Vérifier si le produit existe dans la base de données
    $sql = "SELECT * FROM produits WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_produit]);
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si le produit n'existe pas, afficher un message d'erreur
    if (!$produit) {
        die("Produit non trouvé.");
    }

    // Supprimer le produit de la base de données
    $sql = "DELETE FROM produits WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute([$id_produit])) {
        // Rediriger vers la page de liste des produits avec un message de succès
        header("Location: page_produits.php");
        exit();
    } else {
        die("Erreur lors de la suppression du produit.");
    }
} else {
    // Si l'ID est manquant, afficher un message d'erreur
    die("ID de produit manquant.");
}
?>
