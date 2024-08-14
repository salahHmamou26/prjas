<?php
class Database {
    private $host = "localhost";
    private $db_name = "ecommerce1";  // Remplacez par le nom de votre base de données
    private $username = "root";  // Nom d'utilisateur MySQL
    private $password = "";  // Mot de passe MySQL (laissez vide si vous n'avez pas de mot de passe)
    public $conn;

    // Méthode pour obtenir la connexion à la base de données
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Erreur de connexion : " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
