<?php
session_start();
require_once '../include/header.php';
require_once '../Database.php';
require_once '../models/UtilisateursDao.php';

// Initialisation de la connexion à la base de données
$database = new Database();
$pdo = $database->getConnection();

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['utilisateur_id'])) {
    header('Location: ../dashbord.php?=');
    exit();
}

// Traitement de la connexion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Vérification que tous les champs sont remplis
    if (!empty($email) && !empty($mot_de_passe)) {
        try {
            // Utiliser la méthode connexion de UtilisateurDao
            $utilisateurDao = new UtilisateurDao($pdo);
            $utilisateur = $utilisateurDao->connexion($email, $mot_de_passe);

            if ($utilisateur) {
                // Connexion réussie
                $_SESSION['utilisateur_id'] = $utilisateur['id'];
                $_SESSION['utilisateur_prenom'] = $utilisateur['prenom'];
                $_SESSION['message'] = "Connexion réussie !";
                
                // Rediriger vers le tableau de bord ou la page d'accueil
                header('Location: ../dashbord.php?=');
                exit();
            } else {
                $erreur = "Email ou mot de passe incorrect";
            }
        } catch (Exception $e) {
            $erreur = "Erreur : " . $e->getMessage();
        }
    } else {
        $erreur = "Veuillez remplir tous les champs";
    }
}
?>

<?php if (isset($erreur)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
<?php endif; ?>

<div class="container pt-5">
    <h2 class="mb-4">Connexion</h2>
    <form action="" method="POST">
        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required 
                   value="<?= isset($email) ? htmlspecialchars($email) : '' ?>">
        </div>
        <div class="form-group mb-3">
            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" name="mot_de_passe" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
        <div class="mt-3">
            <p>Pas de compte ? <a href="register.php">Inscrivez-vous</a></p>
        </div>
    </form>
</div>

<?php require_once '../include/footer.php'; ?>