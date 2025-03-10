<?php
class UtilisateurDao {
    private $conn;

    public function __construct($pdo) {
        $this->conn = $pdo;
    }

    public function inscription($prenom, $email, $mot_de_passe, $mot_de_passeConfirm) {
        // Votre logique d'inscription
        $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO utilisateurs (prenom, email, mot_de_passe, mot_de_passeConfirm ) VALUES (:prenom, :email, :mot_de_passe, :mot_de_passeConfirm)";
        $stmt = $this->conn->prepare($sql);
        
        return $stmt->execute([
            ':prenom' => $prenom,
            ':email' => $email,
            ':mot_de_passe' => $mot_de_passe_hash,
            ':mot_de_passeConfirm' => $mot_de_passeConfirm,
        ]);
    }

    public function connexion($email, $mot_de_passe) {
        try {
            // Préparer la requête pour récupérer l'utilisateur par email
            $query = "SELECT * FROM utilisateurs WHERE email = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Vérifier si l'utilisateur existe et si le mot de passe est correct
            if ($utilisateur && password_verify($mot_de_passe, $utilisateur['mot_de_passe'])) {
                // Retourner les informations de l'utilisateur sans le mot de passe
                unset($utilisateur['mot_de_passe']);
                return $utilisateur;
            }
            
            return false;
        } catch (PDOException $e) {
            // Gérer les erreurs de base de données
            throw new Exception("Erreur de connexion : " . $e->getMessage());
        }
    }
}
?>