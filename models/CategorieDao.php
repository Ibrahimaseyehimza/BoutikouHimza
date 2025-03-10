<?php
require_once  'Database.php';
require_once 'Categorie.php';

class CategorieDao {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Methode pour ajouter une categorie
    // public function ajouterCategorie(Categorie $categorie) {
    //     $sql = "INSERT INTO categories(nom) VALUES(:nom)";
    //     $conn = $this->db->getConnection();
    //     $stmt = $conn->prepare($sql);   

    //     return $stmt->execute([
    //         'nom' => $categorie->getNom()
    //     ]);
    // }

    public function ajouterCategorie(array $categories) {
        $sqlCheck = "SELECT COUNT(*) FROM categories WHERE nom = :nom";
        $sqlInsert = "INSERT INTO categories(nom) VALUES(:nom)";
        
        $conn = $this->db->getConnection();
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtInsert = $conn->prepare($sqlInsert);
    
        foreach ($categories as $categorie) {
            $nom = $categorie->getNom();
            
            // Vérifier si la catégorie existe déjà
            $stmtCheck->bindValue(':nom', $nom);
            $stmtCheck->execute();
            $count = $stmtCheck->fetchColumn();
    
            if ($count == 0) { // Si la catégorie n'existe pas, on l'ajoute
                $stmtInsert->bindValue(':nom', $nom);
                $stmtInsert->execute();
            } else {
                echo "La catégorie '$nom' existe déjà. Insertion ignorée.<br>";
            }
        }
        return true;
    
    }    

        //Methode pour ajouter une categorie
        // public function ajouterCategorie(array $categories) {
        //     $sql = "INSERT INTO categories(nom) VALUES(:nom)";
        //     $conn = $this->db->getConnection();
        //     $stmt = $conn->prepare($sql);
    
        //     foreach ($categories as $categorie) {
        //         $nom = $categorie->getNom();
        //         $stmt->bindParam(':nom', $nom);
        //         $stmt->execute();
        //     }

        public function getCategories() {
            $sql = "SELECT * FROM categories";
            $conn = $this->db->getConnection();
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getCategorieParId($id) {
            $sql = "SELECT * FROM categories WHERE id = :id";
            $conn = $this->db->getConnection();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
  
    
}