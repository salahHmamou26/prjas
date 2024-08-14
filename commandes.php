<!doctype html>
<html lang="en">
<head>
    <?php include 'include/head.php' ?>
    <title>Liste des Commandes</title>
</head>
<body>
<?php
require_once 'include/Database.php';
require_once 'include/Order.php';
include 'include/nav.php';

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);
$commandes = $order->readAll();
?>
<div class="container py-2">
    <h2>Liste des Commandes</h2>
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>#ID</th>
            <th>Client</th>
            <th>Total</th>
            <th>Date</th>
            <th>Opérations</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($commandes as $commande) : ?>
            <tr>
                <td><?= htmlspecialchars($commande['id']) ?></td>
                <td><?= htmlspecialchars($commande['login']) ?></td>
                <td><?= htmlspecialchars($commande['total']) ?> <i class="fa fa-solid fa-dollar"></i></td>
                <td><?= htmlspecialchars($commande['date_creation']) ?></td>
                <td><a class="btn btn-primary btn-sm" href="commande.php?id=<?= htmlspecialchars($commande['id']) ?>">Afficher détails</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
