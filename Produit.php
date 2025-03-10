<?php
class Produit {
    private $id;
    private $nom;
    private $prix;
    private $description;
    private $image;
    private $id_categorie;  

    public function __construct($id, $nom, $prix, $description, $image, $id_categorie) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prix = $prix;
        $this->description = $description;
        $this->image = $image;
        $this->id_categorie = $id_categorie;
    }

    public function getId() {
        return $this->id;
    }
    public function getNom() {
        return $this->nom;
    }
    public function getPrix() {
        return $this->prix;
    }
    public function getDescription() {
        return $this->description;
    }
    public function getImage() {
        return $this->image;
    }
    public function getIdCategorie() {
        return $this->id_categorie;
    }
    public function setId($id) {
        $this->id = $id;
    }
    public function setNom($nom) {
        $this->nom = $nom;
    }
    public function setPrix($prix) {
        $this->prix = $prix;
    }
    public function setDescription($description) {
        $this->description = $description;
    }
    public function setImage($image) {
        $this->image = $image;
    }
    public function setIdCategorie($id_categorie) {
        $this->id_categorie = $id_categorie;
    }
    public function __toString() {
        return "Produit[id=$this->id, nom=$this->nom, prix=$this->prix, description=$this->description, image=$this->image, id_categorie=$this->id_categorie]";
    }

}