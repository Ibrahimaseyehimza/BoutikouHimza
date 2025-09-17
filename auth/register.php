<?php
session_start();
require_once  '../include/header.php';
require_once '../Database.php';
require_once '../models/UtilisateursDao.php';

// Initialisation de la connection à la base de données
// $pdo = (new Database())->getConnection();
$database = new Database();
$pdo = $database->getConnection();

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $mot_de_passeConfirm = $_POST['mot_de_passeConfirm'];

    // Vérification que tous les champs sont remplis
    if (!empty($prenom) && !empty($email) && !empty($mot_de_passe) && !empty($mot_de_passeConfirm)) {
        if ($mot_de_passe !== $mot_de_passeConfirm) {
            $erreur = "Les mots de passe ne correspondent pas";
        } else {
            try {
                // Utiliser la méthode inscription de UtilisateurDao
                $utilisateurDao = new UtilisateurDao($pdo);
                $inscription = $utilisateurDao->inscription($prenom, $email, $mot_de_passe, $mot_de_passeConfirm);
    
                if ($inscription) {
                    // Rediriger vers la page de connexion
                    $_SESSION['message'] = "Inscription réussie !";
                    header('Location: ../index.php');
                    exit();
                } else {
                    $erreur = "Erreur lors de l'inscription";
                }
            } catch (Exception $e) {
                $erreur = "Erreur : " . $e->getMessage();        
            }
        }
       
    } else {
        $erreur = "Veuillez remplir tous les champs";
    }
}







// $erreur = "Veuillez remplir tous les champs";
?>



<?php if (isset($erreur)): ?>
    <div class="alert alert-danger"><?= $erreur ?></div>
<?php endif; ?>

<div class="container pt-5">
    <form action="" method="POST">
        <div class="form-group">
            <label for="">Prenom</label>
            <input type="text" name="prenom" class="form-control" require>
        </div>
        <div class="form-group">
            <label for="">Email</label>
            <input type="email" name="email" class="form-control" >
        </div>
        <div class="form-group">
            <label for="">Mot de passe</label>
            <input type="password" name="mot_de_passe" class="form-control" >
        </div>
        <div class="form-group">
            <label for="">Confirmer votre mot de passe</label>
            <input type="password" name="mot_de_passeConfirm" class="form-control" >
        </div>
        <button type="submit" class="btn btn-primary mt-3" name="s_inscrire"> M'inscrire</button>
        <div class="mt-3">
            <p> <a href="login.php">Se connecte</a></p>
        </div>
    </form>
</div>


<?php require_once '../include/footer.php'; ?>
