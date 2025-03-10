<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
require_once 'Database.php';
require 'vendor/autoload.php'; // Inclure PHPMailer
require 'include/header.php';

$db = new Database();
$conn = $db->getConnection();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_SESSION['panier'])) {
        die("Votre panier est vide.");
    }

    $nom_client = $_POST['nom_client'];
    $email_client = $_POST['email_client'];
    $adresse_livraison = $_POST['adresse'];
    $methode_paiement = $_POST['methode_paiement']; // Nouvelle méthode de paiement
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $total = 0;

    try {
        $conn->beginTransaction();

        foreach ($_SESSION['panier'] as $id_produit => $quantite) {
            $stmt = $conn->prepare("SELECT prix FROM produits WHERE id = ?");
            $stmt->execute([$id_produit]);
            $produit = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($produit) {
                $prix_unitaire = $produit['prix'];
                $total += $prix_unitaire * $quantite;
            }
        }

        $stmt = $conn->prepare("INSERT INTO commandes (user_id, nom_client, email_client, total, adresse_livraison, methode_paiement) 
                                VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $nom_client, $email_client, $total, $adresse_livraison, $methode_paiement]);
        $commande_id = $conn->lastInsertId();

        foreach ($_SESSION['panier'] as $id_produit => $quantite) {
            $stmt = $conn->prepare("SELECT prix FROM produits WHERE id = ?");
            $stmt->execute([$id_produit]);
            $produit = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($produit) {
                $prix_unitaire = $produit['prix'];

                $stmt = $conn->prepare("INSERT INTO details_commandes (commande_id, produit_id, quantite, prix_unitaire) 
                                        VALUES (?, ?, ?, ?)");
                $stmt->execute([$commande_id, $id_produit, $quantite, $prix_unitaire]);
            }
        }

        $conn->commit();
        unset($_SESSION['panier']);
        $_SESSION['panier_total'] = 0;

        // **🔹 ENVOI D'EMAIL DE CONFIRMATION**
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Remplace par ton SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'seyeibrahia@gmail.com'; 
            $mail->Password = 'sifi upsc yxgl scwb'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('seyeibrahia@gmail.com', 'Boutikou Himza');
            $mail->addAddress($email_client);

            $mail->isHTML(true);
            $mail->Subject = "Confirmation de votre commande #$commande_id";
            $mail->Body = "<h2>Merci pour votre commande, $nom_client !</h2>
                            <p>Votre commande d'un montant de <strong>$total €</strong> a bien été enregistrée.</p>
                            <p>Méthode de paiement : <strong>$methode_paiement</strong></p>
                            <p>Adresse de livraison : <strong>$adresse_livraison</strong></p>
                            <p>Nous vous contacterons bientôt pour la livraison.</p>";

            $mail->send();
            echo "<div class='alert alert-success'>Commande passée avec succès ! Un e-mail de confirmation a été envoyé.</div>";
        } catch (Exception $e) {
            echo "<div class='alert alert-warning'>Commande passée, mais e-mail non envoyé : {$mail->ErrorInfo}</div>";
        }
    } catch (Exception $e) {
        $conn->rollBack();
        echo "<div class='alert alert-danger'>Erreur lors de la commande : " . $e->getMessage() . "</div>";
    }
}
?>


<!-- Formulaire de commande -->
<div class="container py-5">
<form action="passer_commande.php" method="POST">
    <div class="mb-3">
        <label class="form-label">Nom :</label>
        <input type="text" name="nom_client" required class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Email :</label>
        <input type="email" name="email_client" required class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Adresse de livraison :</label>
        <textarea name="adresse" required class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Méthode de paiement :</label>
        <select name="methode_paiement" required class="form-control">
            <option value="carte">Carte bancaire</option>
            <option value="paypal">PayPal</option>
            <option value="espece">Espèces à la livraison</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Confirmer la commande</button>
</form>

</div>
