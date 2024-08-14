<?php
session_start();


include '../include/database.php';
include '../include/nav_front.php'; 
include '../include/head_front.php'; 

$commande_id = $_GET['id'] ?? 0;

if (!$commande_id) {
    die('Commande non valide.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $method = $_POST['method'];
    if ($method == 'credit_card') {
        header('Location: payment_credit_card.php?id=' . $commande_id);
        exit();
    } elseif ($method == 'paypal') {
        header('Location: payment_paypal.php?id=' . $commande_id);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement</title>
    <link rel="stylesheet" href="../assets/css/style.css"> 
</head>
<body>
    <div class="container py-4">
        <h2>Choisissez votre méthode de paiement</h2>
        <form method="POST" action="paiement.php?id=<?php echo $commande_id; ?>">
            <div>
                <input type="radio" id="credit_card" name="method" value="credit_card" required>
                <label for="credit_card">Carte de Crédit</label>
            </div>
            <div>
                <input type="radio" id="paypal" name="method" value="paypal">
                <label for="paypal">PayPal</label>
            </div>
            <button type="submit" class="btn btn-primary">Procéder au paiement</button>
        </form>
    </div>
</body>
</html>

