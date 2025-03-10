<?php
session_start();
require_once 'Database.php';
require 'include/header.php'; 

$db = new Database();
$conn = $db->getConnection();
$total = 0;
?>

<div class="container mt-5">
    <h2 class="mb-4">Votre Panier</h2>
    
    <?php if (!empty($_SESSION['panier'])) { ?>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix Unitaire</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['panier'] as $id_produit => $quantite) {
                    if (filter_var($id_produit, FILTER_VALIDATE_INT)) {
                        $stmt = $conn->prepare("SELECT nom, prix FROM produits WHERE id = ?");
                        $stmt->execute([$id_produit]);
                        $produit = $stmt->fetch(PDO::FETCH_ASSOC);
                        
                        if ($produit) {
                            $total_produit = $produit['prix'] * $quantite;
                            $total += $total_produit;
                ?>
                <tr>
                    <td><?= htmlspecialchars($produit['nom']); ?></td>
                    <td><?= htmlspecialchars($quantite); ?></td>
                    <td><?= number_format($produit['prix'], 2); ?> €</td>
                    <td><?= number_format($total_produit, 2); ?> €</td>
                    <td>
                        <a href="supprimer_panier.php?id=<?= $id_produit; ?>" class="btn btn-danger btn-sm">Supprimer</a>
                    </td>
                </tr>
                <?php } } } ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center">
            <h3>Total : <?= number_format($total, 2); ?> €</h3>
            <a href="passer_commande.php" class="btn btn-success">Passer la commande</a>
        </div>
    <?php 
        $_SESSION['panier_total'] = $total;  // Mettre à jour le total dans la session
    } else { ?>
        <div class="alert alert-warning" role="alert">Votre panier est vide.</div>
    <?php } ?>
</div>
