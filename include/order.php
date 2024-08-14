<?php
class Order {
    private $conn;
    private $table_name = "commande";

    public $id;
    public $id_client;
    public $total;
    public $date_creation;
    public $valide;
    public $login;

    public function __construct($db) {
        $this->conn = $db;
    }

  
    public function readAll() {
        $query = 'SELECT commande.*, utilisateur.login as "login"
                  FROM ' . $this->table_name . ' 
                  INNER JOIN utilisateur ON commande.id_client = utilisateur.id 
                  ORDER BY commande.date_creation DESC';

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   
    public function readOne($idCommande) {
        $query = 'SELECT commande.*, utilisateur.login as "login"
                  FROM ' . $this->table_name . ' 
                  INNER JOIN utilisateur ON commande.id_client = utilisateur.id 
                  WHERE commande.id = ?
                  ORDER BY commande.date_creation DESC';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $idCommande);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

  
    public function readOrderLines($idCommande) {
        $query = 'SELECT ligne_commande.*, produit.libelle, produit.image 
                  FROM ligne_commande 
                  INNER JOIN produit ON ligne_commande.id_produit = produit.id 
                  WHERE id_commande = ?';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $idCommande);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
?>

