<?php
class User {
    private $conn;
    private $table_name = "utilisateur";

    public $id;
    public $login;
    public $password;
    public $role;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function loginUser() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE login = ? AND password = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->login);
        $stmt->bindParam(2, $this->password);

        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->role = $row['role'];  
            $_SESSION['utilisateur'] = ['id' => $this->id, 'role' => $this->role, 'login' => $this->login];
            return true;
        }

        return false;
    }

    public function loginExists() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE login = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->login);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

 
    public function registerUser() {
       
        if ($this->loginExists()) {
            return "Le nom d'utilisateur est déjà pris. Veuillez en choisir un autre.";
        }

        $query = "INSERT INTO " . $this->table_name . " (login, password) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);

        
     
        $stmt->bindParam(1, $this->login);
        $stmt->bindParam(2, $this->password);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
   
    public function authenticate() {
        if ($this->loginUser()) {
      
            header('location: index.php');
            exit();
        } else {
            return "Login ou mot de passe incorrect.";
        }
    }
}
?>
