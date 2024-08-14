<?php
session_start();
require_once '../include/database.php';
require_once '../include/CarteCredit.php'; // Incluez la classe CarteCredit

$database = new Database();
$pdo = $database->getConnection();

$idCommande = $_POST['commande_id'] ?? 0;
$numeroCarte = $_POST['card_number'] ?? '';
$dateExpiration = $_POST['card_expiry'] ?? '';
$cvc = $_POST['card_cvc'] ?? '';

if ($idCommande && $numeroCarte && $dateExpiration && $cvc) {
    $carteCredit = new CarteCredit($pdo);
    $carteCredit->setDetails($idCommande, $numeroCarte, $dateExpiration, $cvc);

    if ($carteCredit->sauvegarderCarte()) {
        $message = "Paiement effectué avec succès.";
    } else {
        $message = "Échec du paiement, veuillez réessayer.";
    }
} else {
    $message = "Détails de la carte manquants, veuillez réessayer.";
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Inclure le CSS via head_front.php -->
    <?php include '../include/head_front.php'; ?>
    <title>Résultat du Paiement</title>
</head>
<body>
    <?php include '../include/nav_front.php'; ?>
    <div class="container py-4">
        <h2><?php echo $message; ?></h2>
        <a href="index.php" class="btn btn-success">Retour à la boutique</a>
    </div>
</body>
</html>
