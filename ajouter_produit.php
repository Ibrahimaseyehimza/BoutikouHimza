<?php
require_once 'Database.php';
require_once 'include/header_simple.php';
require_once 'Produit.php';

$db = new Database();
$conn = $db->getConnection();

// Récupérer toutes les catégories pour le menu déroulant
$sql = "SELECT * FROM categories";
$stmt = $conn->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Traitement du formulaire d'ajout

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST['nom']);
    $prix = trim($_POST['prix']);
    $description = trim($_POST['description']);
    $id_categorie = $_POST['id_categorie'];

    // Vérifier si les champs sont bien remplis
    if (!empty($nom) && !empty($prix) && !empty($description) && !empty($id_categorie) && !empty($_FILES['image']['name'])) {

        // Fonction pour uploader une image
        function uploadImage($fichier, $prefixe = '') {
            $dossier_uploads = 'uploads/images/';
            
            // Créer le dossier s'il n'existe pas
            if (!file_exists($dossier_uploads)) {
                mkdir($dossier_uploads, 0777, true);
            }

            // Vérifier si un fichier a bien été envoyé
            if (!isset($fichier) || $fichier['error'] !== UPLOAD_ERR_OK) {
                return false;
            }

            // Générer un nom de fichier unique
            $extension = pathinfo($fichier['name'], PATHINFO_EXTENSION);
            $nom_fichier = uniqid($prefixe, true) . '.' . $extension;
            $chemin_destination = $dossier_uploads . $nom_fichier;

            // Vérifier le type de fichier
            $types_autorises = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
            if (!in_array($fichier['type'], $types_autorises)) {
                return false;
            }

            // Vérifier la taille du fichier (max 5 Mo)
            if ($fichier['size'] > 5 * 1024 * 1024) {
                return false;
            }

            // Déplacer le fichier téléchargé
            if (move_uploaded_file($fichier['tmp_name'], $chemin_destination)) {
                return $chemin_destination;
            }

            return false;
        }

        // Gestion de l'upload de l'image
        $chemin_image = uploadImage($_FILES['image'], 'produit_');

        if ($chemin_image) {
            // Instanciation de la classe Produit
            $produit = new Produit(null, $nom, $prix, $description, $chemin_image, $id_categorie);

            // Insertion dans la base de données
            $sql = "INSERT INTO produits (nom, prix, description, image, id_categorie) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$produit->getNom(), $produit->getPrix(), $produit->getDescription(), $produit->getImage(), $produit->getIdCategorie()]);

            // Récupérer l'ID du produit inséré
            $id_produit = $conn->lastInsertId();

            // Insertion des détails du produit dans la table details_produits
            $sql = "INSERT INTO details (id_produit, details) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$id_produit, $_POST['details']]);


            // Redirection après l'ajout
            header("Location: page_produits.php");
            exit();
        } else {
            $error = "Erreur lors de l'upload de l'image.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>




<div class="content">
<h2 class="text-center">Ajouter un Nouveau Produit</h2>
<?php if (isset($error)) : ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="p-4 border rounded shadow-sm bg-light">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom du Produit :</label>
                <input type="text" id="nom" name="nom" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="prix" class="form-label">Prix :</label>
                <input type="number" id="prix" name="prix" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description :</label>
                <textarea id="description" name="description" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image du Produit :</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*" required>
            </div>

            <div class="mb-3">
                <label for="id_categorie" class="form-label">Catégorie :</label>
                <select id="id_categorie" name="id_categorie" class="form-select" required>
                    <?php foreach ($categories as $categorie) : ?>
                        <option value="<?= $categorie['id']; ?>"><?= htmlspecialchars($categorie['nom']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-warning">Ajouter</button>
                <a href="page_produits.php?=" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
</div>

<?php require_once 'include/footer.php'; ?>
