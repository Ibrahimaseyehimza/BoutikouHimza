<?php
session_start();
// require_once 'Database.php'; // Si tu en as besoin pour récupérer des informations produits
// require_once 'includes/header_dashbord.php'; // Si tu en as besoin

// Vérification si l'ID produit et la quantité sont envoyés via POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_produit']) && isset($_POST['quantite'])) {
    $id_produit = $_POST['id_produit'];
    $quantite = $_POST['quantite'];

    // Valider la quantité (doit être un entier positif)
    if ($quantite > 0 && filter_var($id_produit, FILTER_VALIDATE_INT)) {
        // Vérifier si le produit est déjà dans le panier
        if (isset($_SESSION['panier'][$id_produit])) {
            $_SESSION['panier'][$id_produit] += $quantite; // Ajouter à la quantité existante
        } else {
            $_SESSION['panier'][$id_produit] = $quantite; // Ajouter le produit avec la quantité
        }

        // Recalculer le total du panier
        $_SESSION['panier_total'] = array_sum($_SESSION['panier']);

        // Redirection vers le panier
        header("Location: index.php");
        exit();
    } else {
        // Gérer l'erreur si la quantité ou l'ID produit est invalide
        echo "Erreur : quantité invalide ou produit introuvable.";
    }
} else {
    echo "Erreur : données manquantes.";
}
?>

<?php require_once 'include/footer.php'; ?>
