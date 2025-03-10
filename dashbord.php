<?php
require_once 'Database.php';
require_once 'include/header_dashbord.php';



session_start();
if (!isset($_SESSION['utilisateur_id'])) {
    header("Location: login.php");
    exit();
}

// Debugging : Vérifier si les sessions existent
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

$nom_utilisateur = $_SESSION['utilisateur_nom'] ?? "";
$prenom_utilisateur = $_SESSION['utilisateur_prenom'] ?? "Prénom inconnu";
?>

<?php
// Créer une intance de connexion à la base de données
$database = new Database();
$pdo = $database->getConnection();

// Prépaer et executer la requête sql
$sql = "SELECT COUNT(*) AS total FROM produits";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Récupérer le total des produits
$totalProduits = $result['total'];

$sql = "SELECT COUNT(*) AS total FROM categories";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result2 = $stmt->fetch(PDO::FETCH_ASSOC);

// Récupérer le total des produits
$totalCategorie = $result2['total'];

// Toatal des commandes
$sql = "SELECT COUNT(*) AS total FROM commandes";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result3 = $stmt->fetch(PDO::FETCH_ASSOC);

// Récupérer le totale des commandes
$totaleCommande = $result3['total'];

// Commende en cours
$sql = "SELECT COUNT(*) AS total FROM commandes WHERE statut='En attente'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result4 = $stmt->fetch(PDO::FETCH_ASSOC);

$CommandeEnAttente = $result4['total'];

// Commende en terminer
$sql = "SELECT COUNT(*) AS total FROM commandes WHERE statut='Payée'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result5 = $stmt->fetch(PDO::FETCH_ASSOC);

$Commandeterminer = $result5['total'];




?>
<div class="d-flex justify-content-end">
    <p class="text-white">Bienvenue, <strong><?= htmlspecialchars($nom_utilisateur); ?></strong> 👋</p>
</div>

    <div class="content">
        <h2 class="text-center mb-4 fw-bold">Tableau de Bord</h2>
        <div class="row" id="card_dashboard">
            <div class="col-md-4">
                <div class="card card-custom bg-primary text-white">
                    <h5>Total Produits</h5>
                    <p><?php echo $totalProduits; ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom bg-success text-white">
                    <h5>Total Catégories</h5>
                    <p><?php echo $totalCategorie; ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom bg-warning text-dark">
                    <h5>Produits Récents</h5>
                    <p>3 nouveaux produits</p>
                </div>
            </div>
        </div>
        <div class="row py-5" >
            <div class="col-md-4">
                <div class="card card-custom bg-primary text-white">
                    <h5>Total des commandes</h5>
                    <p><?php echo $totaleCommande; ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom bg-primary text-white">
                    <h5>Commandes en Cours</h5>
                    <p><?php echo $CommandeEnAttente; ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom bg-warning text-dark">
                    <h5>Commandes Terminée</h5>
                    <p><?php echo $Commandeterminer; ?></p>
                </div>
            </div>
        </div>
        <div class="row py-4" >
            <div class="col-md-6">
                <a href="page_produits.php?=" class="text-decoration-none">
                    <div id="card" class="card card-custom bg-primary text-white p-3">
                        <i id="card_position1" class="fas fa-box me-2"></i>
                        <h5 id="card_position">Gestionnaires des produits</h5>
                    </div>
                </a>
            </div>
            <div   class="col-md-6">
                <a href="page_categorie.php?=" class="text-decoration-none">
                    <div id="card" class="card card-custom bg-success text-white d-flex align-items-center">
                        <i id="card_position1" class="fas fa-list me-2"></i>
                        <h5 id="card_position"  >Gestionnaires des categorie</h5>
                    </div>
                </a>
            </div>
            </div>
        </div>
    </div>
    <p>Bienvenue, <strong><?= $prenom_utilisateur . ' ' . $nom_utilisateur; ?></strong> 👋</p>
<?php require_once 'include/footer_dashbord.php';?>
