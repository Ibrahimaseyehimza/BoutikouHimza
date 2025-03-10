<?php
session_start();
require_once 'Database.php';

if (!isset($_SESSION['user_id'])) {
    die("Vous devez être connecté.");
}

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare("SELECT * FROM commandes WHERE user_id = ? ORDER BY date_commande DESC");
$stmt->execute([$_SESSION['user_id']]);
$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Mes Commandes</h2>
<table class="table table-striped">
    <tr>
        <th>ID</th>
        <th>Date</th>
        <th>Total</th>
        <th>Statut</th>
    </tr>
    <?php foreach ($commandes as $commande) { ?>
    <tr>
        <td><?= $commande['id']; ?></td>
        <td><?= $commande['date_commande']; ?></td>
        <td><?= number_format($commande['total'], 2); ?> €</td>
        <td><?= $commande['statut']; ?></td>
    </tr>
    <?php } ?>
</table>
