<?php
session_start();

$commande_id = $_GET['id'] ?? 0;

if (!$commande_id) {
    die('Commande non valide.');
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Inclure le même fichier head_front.php pour le CSS et autres métadonnées -->
    <?php include '../include/head_front.php'; ?>
    <title>Paiement par Carte de Crédit</title>
</head>
<body>
    <!-- Inclure la même barre de navigation -->
    <?php include '../include/nav_front.php'; ?>
    <div class="container py-4">
        <h2>Paiement par Carte de Crédit</h2>
        <form method="post" action="process_credit_card.php">
            <div class="form-group">
                <label for="card_number">Numéro de Carte</label>
                <input type="text" class="form-control" id="card_number" name="card_number" required>
            </div>
            <div class="form-group">
                <label for="card_expiry">Date d'Expiration</label>
                <input type="text" class="form-control" id="card_expiry" name="card_expiry" required placeholder="MM/YY">
            </div>
            <div class="form-group">
                <label for="card_cvc">CVC</label>
                <input type="text" class="form-control" id="card_cvc" name="card_cvc" required>
            </div>
            <input type="hidden" name="commande_id" value="<?php echo $commande_id; ?>">
            <button type="submit" class="btn btn-primary">Payer</button>
        </form>
    </div>
</body>
</html>
