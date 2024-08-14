<?php
require_once 'include/database.php';

$message = ''; 

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $database = new Database();
    $pdo = $database->getConnection();

    try {
     
        $sqlState = $pdo->prepare('SELECT COUNT(*) FROM produit WHERE id_categorie = ?');
        $sqlState->execute([$id]);
        $produitCount = $sqlState->fetchColumn();

        if ($produitCount > 0) {
           
            $message = 'Erreur : Cette catégorie contient encore des produits. Veuillez d\'abord les supprimer ou les réaffecter à une autre catégorie.';
        } else {
            
            $sqlState = $pdo->prepare('DELETE FROM categories WHERE id = ?');
            $sqlState->execute([$id]);

            
            $message = 'La catégorie a été supprimée avec succès.';
        }
    } catch (Exception $e) {
        
        $message = 'Erreur : ' . $e->getMessage();
    }
} else {
    $message = "ID de catégorie non fourni.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer Catégorie</title>
</head>
<body>
    <div class="container">
        <?php if ($message): ?>
            <div class="alert alert-info">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        
        <a href="categories.php">Retourner à la liste des catégories</a>
    </div>
</body>
</html>

