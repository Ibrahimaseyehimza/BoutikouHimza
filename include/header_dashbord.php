<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            display: flex;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #343a40;
            padding-top: 20px;
            position: fixed;
            color: white;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            display: flex;
            align-items: center;
        }
        .sidebar a:hover {
            background-color: #007BFF;
        }
        .content {
            margin-left: 100px;
            width: 100%;
            padding: 20px;
        }
        .card-custom {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #card{
           height: 200px;
        }
        #card2{
           position: relative;
           top: 40px;
           padding: 10px;
        }
        #card_position{
            position: relative;
            top: 70px;
        }
        #card_position1{
            position: relative;
            top: 50px;
        }


    </style>
</head>
<body>

    
    <div class="sidebar">
        <li class="nav-item">
            <a class="nav-link" href="index.php" target="_blank">
                <i class="fas fa-eye" name="view_home"></i> Voir le site
            </a>
        </li>

        <h4 class="text-center">Page Admin</h4>
        <a href="dashbord.php"><i class="fas fa-chart-line me-2" name="dashboard"></i> Dashboard</a>
        <a href="page_categorie.php?="><i class="fas fa-list me-2" name="categorie"></i> Catégories</a>
        <a href="page_produits.php?="><i class="fas fa-box me-2" name="produits"></i> Produits</a>
        <a href="commandes.php?="><i class="fa fa-shopping-cart me-2" name="commandes"></i> Commandes</a>
        <a href="auth/logout.php?=" class="text-danger"><i class="fas fa-sign-out-alt me-2" name="deconnexion"></i> Déconnexion</a>
    </div>