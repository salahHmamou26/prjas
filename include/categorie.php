<?php
class Category {
    private $conn;
    private $table_name = "categories"; // Assure-toi que le nom de la table est correct

    public $id;
    public $libelle;
    public $description;
    public $icone;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lire les détails d'une seule catégorie
    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->id = $row['id'];
            $this->libelle = $row['libelle'];
            $this->description = $row['description'];
            $this->icone = $row['icone'];
        }
    }

    // Lire toutes les catégories
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Créer une nouvelle catégorie
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (libelle, description, icone) VALUES (:libelle, :description, :icone)";
        $stmt = $this->conn->prepare($query);

        // Liaison des paramètres
        $stmt->bindParam(':libelle', $this->libelle);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':icone', $this->icone);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Mettre à jour une catégorie existante
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET libelle = :libelle, description = :description, icone = :icone
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Liaison des paramètres
        $stmt->bindParam(':libelle', $this->libelle);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':icone', $this->icone);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Supprimer une catégorie
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
