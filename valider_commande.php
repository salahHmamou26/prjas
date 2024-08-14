<?php

require_once 'include/Database.php';


$database = new Database();
$pdo = $database->getConnection();

if ($pdo === null) {
    die('La connexion à la base de données a échoué.');
}


$id = $_GET['id'] ?? null;

if ($id) {
   
    $sqlState = $pdo->prepare('UPDATE commande SET status = "validée" WHERE id = ?');
    $sqlState->execute([$id]);

    
    header('Location: commandes.php');
    exit();
} else {
    echo "ID de commande manquant.";
}
?>
