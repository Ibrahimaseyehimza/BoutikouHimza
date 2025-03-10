<?php
require_once 'Database.php';

$db = new Database();
$conn = $db->getConnection();

// Vérifier si un ID est fourni
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de catégorie manquant.");
}

$id = $_GET['id'];

// Vérifier si la catégorie existe
$sql = "SELECT * FROM categories WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$categorie = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$categorie) {
    die("Catégorie introuvable.");
}

// Supprimer la catégorie
$sql = "DELETE FROM categories WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);

// Rediriger vers la liste des catégories après suppression
header("Location: categories.php");
exit();
?>
