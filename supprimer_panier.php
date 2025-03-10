<?php
session_start();

// Vérifier si l'ID du produit est présent dans l'URL
if (isset($_GET['id'])) {
    $id_produit = $_GET['id'];

    // Vérifier si le produit existe dans le panier et le supprimer
    if (isset($_SESSION['panier'][$id_produit])) {
        unset($_SESSION['panier'][$id_produit]);
        
        // Recalculer le total du panier
        $_SESSION['panier_total'] = array_sum($_SESSION['panier']);

        // Rediriger vers le panier
        header("Location: panier.php");
        exit();
    } else {
        echo "Produit introuvable dans le panier.";
    }
} else {
    echo "Aucun produit sélectionné pour la suppression.";
}
?>
