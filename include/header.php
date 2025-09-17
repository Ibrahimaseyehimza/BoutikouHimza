<?php
// Obtenir le chemin de la page actuelle
$current_page = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutikou Himza</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Personnalisation des couleurs */
        .navbar {
            background-color: #1E2A38 !important; 
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }
        .nav-link:hover, .nav-link.active {
            color: #FF9800 !important; 
        }
        .btn-login {
            background-color: #FF9800;
            border: none;
        }
        .btn-login:hover {
            background-color: #1E2A38; 
            color: #1E2A38;
        }

        #voir_details {
            margin-left: 20px;
            position: relative;
            bottom: 4px;
            left: 50px;
        }

        .btn-panier {
            background-color: #f39c12;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }

        .btn-panier:hover {
            background-color: #e67e22;
        }

        .btn-panier:active {
            background-color: #d35400;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="index.php">Boutikou Himza</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'index.php') ? 'active' : ''; ?>" href="index.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'produits_livres.php') ? 'active' : ''; ?>" href="produits_livres.php?categorie=Livres">Livre</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'produits_categories.php') ? 'active' : ''; ?>" href="produits_categories.php?categorie=Accessoire">Accessoire</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'produits_materiel .php') ? 'active' : ''; ?>" href="produits_materiel.php?categorie=Materiel informatique">Matériel informatique</a>
                </li>
            </ul>
            <a href="auth/login.php" type="button" class="btn btn-outline-warning me-2" name="se_connecter" >Se connecter</a>
            <a  href="auth/register.php" class="btn btn-login text-white  me-2" name="inscription">Inscription</a>
            <a href="panier.php" class="btn-panier">
            🛒<i class="bi bi-cart4"></i> (<?php echo isset($_SESSION['panier_total']) ? $_SESSION['panier_total'] : 0; ?> €)
            </a>

        


        </div>
        
    </div>
</nav>






