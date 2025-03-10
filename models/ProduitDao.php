<?php
require_once  'Database.php';
require_once 'Produit.php';
class ProduitDao {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Méthode pour ajouter un seul produit
    public function ajouterProduit(Produit $produit) {
        $sql = "INSERT INTO produits(nom, prix, description, image, id_categorie) 
                VALUES(:nom, :prix, :description, :image, :id_categorie)";
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare($sql);   

        return $stmt->execute([
            'nom' => $produit->getNom(),
            'prix' => $produit->getPrix(),
            'description' => $produit->getDescription(),
            'image' => $produit->getImage(),
            'id_categorie' => $produit->getIdCategorie()
        ]);
    }

    // Méthode pour ajouter plusieurs produits en une seule requête
    public function ajouterProduits(array $produits) {
        $sql = "INSERT INTO produits(nom, prix, description, image, id_categorie) 
                VALUES (:nom, :prix, :description, :image, :id_categorie)";
        
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare($sql);

        foreach ($produits as $produit) {
            $stmt->bindValue(':nom', $produit->getNom());
            $stmt->bindValue(':prix', $produit->getPrix());
            $stmt->bindValue(':description', $produit->getDescription());
            $stmt->bindValue(':image', $produit->getImage());
            $stmt->bindValue(':id_categorie', $produit->getIdCategorie());
            $stmt->execute();
        }

        return true;
    }

    // Methode pour vérifier si le produit existe déjà
    public function produitExiste($nom) {
        $sql = "SELECT COUNT(*) FROM produits WHERE nom = :nom";
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':nom', $nom);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        return $count > 0;
    }

    // Méthode pour récupérer tous les produits
    public function getProduitsParCategorie($idCategorie) {
        $sql = "SELECT * FROM produits WHERE id_categorie = :id_categorie";
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id_categorie' => $idCategorie]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProduits() {
        $sql = "SELECT * FROM produits";
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProduitParId($id) {
        $sql = "SELECT * FROM produits WHERE id = :id";
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getNouveauxProduits($limit = 3) {
        $sql = "SELECT * FROM produits ORDER BY date_creation DESC LIMIT :limit";
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }   
    

}
