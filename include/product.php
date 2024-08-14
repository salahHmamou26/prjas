<?php
class Product {
    private $conn;
    private $table_name = "produit";

    public $id;
    public $libelle;
    public $prix;
    public $discount;
    public $categorie_id;
    public $description;
    public $image;
    public $date_creation;

    public function __construct($db) {
        $this->conn = $db;
    }

    
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (libelle, prix, discount, id_categorie, description, image, date_creation)
                  VALUES (:libelle, :prix, :discount, :categorie_id, :description, :image, :date_creation)";

        $stmt = $this->conn->prepare($query);

        
        $stmt->bindParam(':libelle', $this->libelle);
        $stmt->bindParam(':prix', $this->prix);
        $stmt->bindParam(':discount', $this->discount);
        $stmt->bindParam(':categorie_id', $this->categorie_id);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':date_creation', $this->date_creation);

   
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

   

    public function readAll() {
        $query = "SELECT produit.*, categories.libelle as categorie_libelle 
                  FROM " . $this->table_name . " 
                  INNER JOIN categories ON produit.id_categorie = categories.id 
                  ORDER BY produit.date_creation DESC";
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_OBJ);
        if ($row) {
            $this->id = $row->id;
            $this->libelle = $row->libelle;
            $this->prix = $row->prix;
            $this->discount = $row->discount;
            $this->categorie_id = $row->id_categorie;
            $this->description = $row->description;
            $this->image = $row->image;
            $this->date_creation = $row->date_creation;
        }
    }

    
    public function update($uploadImage = false) {
        if ($uploadImage && !empty($this->image)) {
            $this->processImageUpload($_FILES["image"]);
        }

        $query = "UPDATE " . $this->table_name . " 
                  SET libelle = :libelle, prix = :prix, discount = :discount, id_categorie = :categorie_id, description = :description, image = :image
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

  
        $stmt->bindParam(':libelle', $this->libelle);
        $stmt->bindParam(':prix', $this->prix);
        $stmt->bindParam(':discount', $this->discount);
        $stmt->bindParam(':categorie_id', $this->categorie_id);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    private function uploadImage($file) {
        $targetDir = "upload/produit/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true); 
        }
        $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        $targetFile = $targetDir . uniqid() . '.' . $imageFileType;
    
        try {
            
            $check = getimagesize($file["tmp_name"]);
            if ($check === false) {
                throw new Exception("Le fichier n'est pas une image.");
            }
    
            
            if ($file["size"] > 5000000) {
                throw new Exception("L'image est trop grande.");
            }
    
            
            $allowedFormats = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($imageFileType, $allowedFormats)) {
                throw new Exception("Seuls les formats JPG, JPEG, PNG & GIF sont autorisés.");
            }
    
            // Tenter l'upload du fichier
            if (!move_uploaded_file($file["tmp_name"], $targetFile)) {
                throw new Exception("Une erreur est survenue lors de l'upload de l'image.");
            }
    
            // Si tout est correct, définir l'image
            $this->image = basename($targetFile);
            return true;
    
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }
    
    
    public function processImageUpload($file) {
        try {
            return $this->uploadImage($file);
        } catch (Exception $e) {
            echo "Erreur lors du traitement de l'image : " . $e->getMessage();
            return false;
        }
    }

 
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
