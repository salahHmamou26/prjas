<?php
require_once 'include/database.php';

$database = new Database();
$pdo = $database->getConnection();

$id = $_GET['id'] ?? null;

if ($id) {
    try {
       
        $pdo->beginTransaction();

       
        $sqlState = $pdo->prepare('DELETE FROM ligne_commande WHERE id_produit = ?');
        $sqlState->execute([$id]);

        
        $sqlState = $pdo->prepare('DELETE FROM produit WHERE id = ?');
        $sqlState->execute([$id]);

        
        $pdo->commit();

       
        header('Location: produits.php');
        exit();
    } catch (Exception $e) {
       
        $pdo->rollBack();
        echo 'Erreur : ' . $e->getMessage();
    }
} else {
    echo "ID de produit manquant.";
}
?>
