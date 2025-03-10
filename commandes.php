<?php
// Connexion à la base de données
require_once 'Database.php';
require_once 'include/header_simple.php';

try {
    // Connexion à la base de données avec PDO
    $db = new Database();
    $conn = $db->getConnection();   

    // Vérifier si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['statut'])) {
        // Mettre à jour le statut pour chaque commande
        foreach ($_POST['statut'] as $commande_id => $statut) {
            // Préparer la requête UPDATE
            $updateQuery = "UPDATE commandes SET statut = :statut WHERE id = :id";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bindParam(':statut', $statut);
            $updateStmt->bindParam(':id', $commande_id);
            $updateStmt->execute();
        }
        // Message de confirmation
        $message = "Les statuts des commandes ont été mis à jour avec succès.";
    }

    // Récupérer toutes les commandes
    $query = "SELECT * FROM commandes";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Affichage du tableau avec Bootstrap
    echo "<div class='container mt-5'>";
    echo "<h2 class='mb-4' id='title_commande'>Gestion des Commandes</h2>";
    echo "<a href='dashbord.php?=' class='btn btn-secondary' id='text-end'>Retourner au dashbord</a>";

    // Si un message de succès est défini, afficher l'alerte
    if (isset($message)) {
        echo "<div id='successMessage' class='alert alert-success mt-3' role='alert'>{$message}</div>";
    }

    echo "<form method='POST' action=''>";
    echo "<table class='table table-bordered table-striped'>
        <thead class='thead-dark'>
            <tr>
                <th>ID Commande</th>
                <th>Date de commande</th>
                <th>Total</th>
                <th>Statut</th>
                <th>Adresse de livraison</th>
                <th>Modifier Statut</th>
            </tr>
        </thead>
        <tbody>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['date_commande'] . "</td>
                <td>" . $row['total'] . " €</td>
                <td>" . $row['statut'] . "</td>
                <td>" . $row['adresse_livraison'] . "</td>
                <td>
                    <select class='form-select' name='statut[" . $row['id'] . "]'>
                        <option value='En attente' " . ($row['statut'] == 'En attente' ? 'selected' : '') . ">En attente</option>
                        <option value='Payée' " . ($row['statut'] == 'Payée' ? 'selected' : '') . ">Payée</option>
                        <option value='Expédiée' " . ($row['statut'] == 'Expédiée' ? 'selected' : '') . ">Expédiée</option>
                        <option value='Livrée' " . ($row['statut'] == 'Livrée' ? 'selected' : '') . ">Livrée</option>
                    </select>
                </td>
            </tr>";
    }

    echo "</tbody></table>";
    echo "<button type='submit' class='btn btn-warning mt-3'>Mettre à jour les statuts</button>";
    echo "</form>";
    echo "</div>";

} catch (PDOException $e) {
    die("Échec de la connexion : " . $e->getMessage());
}
?>

<!-- Script JavaScript pour faire disparaître le message après 5 secondes -->
<script>
    // Si le message de succès existe, le masquer après 5 secondes
    window.onload = function() {
        var successMessage = document.getElementById('successMessage');
        if (successMessage) {
            setTimeout(function() {
                successMessage.style.display = 'none';
            }, 2000); // Masquer après 5 secondes
        }
    };
</script>
