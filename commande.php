<?php
require_once 'include/Database.php';
require_once 'include/Order.php';

$idCommande = $_GET['id'];

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);
$commande = $order->readOne($idCommande);
$lignesCommandes = $order->readOrderLines($idCommande);
?>
<!doctype html>
<html lang="en">
<head>
    <?php include 'include/head.php' ?>
    <title>Commande | Numéro <?= htmlspecialchars($commande['id']) ?> </title>
</head>
<body>
<?php include 'include/nav.php' ?>
<div class="container py-2">
    <h2>Détails Commandes</h2>
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
        <tr>
            <td><?= htmlspecialchars($commande['id']) ?></td>
            <td><?= htmlspecialchars($commande['login']) ?></td>
            <td><?= htmlspecialchars($commande['total']) ?> <i class="fa fa-solid fa-dollar"></i></td>
            <td><?= htmlspecialchars($commande['date_creation']) ?></td>
            <td>
                <?php if ($commande['valide'] == 0) : ?>
                    <a class="btn btn-success btn-sm" href="valider_commande.php?id=<?= htmlspecialchars($commande['id']) ?>&etat=1">Valider la commande</a>
                <?php else: ?>
                    <a class="btn btn-danger btn-sm" href="valider_commande.php?id=<?= htmlspecialchars($commande['id']) ?>&etat=0">Annuler la commande</a>
                <?php endif; ?>
            </td>
        </tr>
        </tbody>
    </table>
    <hr>
    <h2>Produits : </h2>
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>#ID</th>
            <th>Produit</th>
            <th>Prix unitaire</th>
            <th>Quantité</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($lignesCommandes as $lignesCommande) : ?>
            <tr>
                <td><?= htmlspecialchars($lignesCommande->id) ?></td>
                <td><?= htmlspecialchars($lignesCommande->libelle) ?></td>
                <td><?= htmlspecialchars($lignesCommande->prix) ?> <i class="fa fa-solid fa-dollar"></i></td>
                <td>x <?= htmlspecialchars($lignesCommande->quantite) ?></td>
                <td><?= htmlspecialchars($lignesCommande->total) ?> <i class="fa fa-solid fa-dollar"></i></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
