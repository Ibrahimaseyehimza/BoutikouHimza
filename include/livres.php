<?php
// Inclure la connexion à la base de données
require_once '../Database.php';


$db = new Database();
$conn = $db->getConnection();

// Récupérer toutes les catégories
$sql = "SELECT * FROM categories where id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>