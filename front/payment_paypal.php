<?php
session_start();
require_once '../include/database.php';
$commande_id = $_GET['id'] ?? 0;

// Récupérer le montant total de la commande à partir de la base de données
$database = new Database();
$pdo = $database->getConnection();

$query = "SELECT total FROM commande WHERE id = :commande_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':commande_id', $commande_id, PDO::PARAM_INT);
$stmt->execute();

$commande = $stmt->fetch(PDO::FETCH_ASSOC);
$total = $commande['total'] ?? 0; // Si aucun total n'est trouvé, mettre 0 par défaut

$email_vendeur = 'salaheddine.hmamou26@gmail.com';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include '../include/head_front.php'; ?>
    <title>Paiement via PayPal</title>
</head>
<body>
    <?php include '../include/nav_front.php'; ?>
    <div class="container py-4">
        <h2>Paiement via PayPal</h2>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
          
            <input type="hidden" name="business" value="<?php echo $email_vendeur; ?>">
           
            <input type="hidden" name="cmd" value="_xclick">
           
            <input type="hidden" name="item_name" value="Commande #<?php echo $commande_id; ?>">
            <input type="hidden" name="amount" value="<?php echo $total; ?>">
            <input type="hidden" name="currency_code" value="USD">
            
            <input type="hidden" name="return" value="http://votre-site.com/confirmation.php?commande_id=<?php echo $commande_id; ?>">
           
            <input type="hidden" name="cancel_return" value="http://votre-site.com/annulation.php">
            
            <input type="hidden" name="notify_url" value="http://votre-site.com/ipn.php">
           
            <button type="submit" class="btn btn-primary">Continuer vers PayPal</button>
        </form>
    </div>
</body>
</html>

