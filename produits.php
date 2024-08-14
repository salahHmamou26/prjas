<!doctype html>
<html lang="en">
<head>
    <?php include 'include/head.php' ?>
    <title>Liste des produits</title>
</head>
<body>
<?php
require_once 'include/Database.php';
require_once 'include/Product.php';
include 'include/nav.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$produits = $product->readAll();
?>
<div class="container py-2">
    <h2>Liste des produits</h2>
    <a href="ajouter_produit.php" class="btn btn-primary mb-3">Ajouter produit</a>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#ID</th>
                <th>Libelle</th>
                <th>Prix</th>
                <th>Discount</th>
                <th>Catégorie</th>
                <th>Date de création</th>
                <th>Image</th>
                <th>Opérations</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($produits as $produit) :
            $prix = $produit->prix;
            $discount = $produit->discount;
            $prixFinale = $prix - (($prix * $discount) / 100);
            ?>
            <tr>
                <td><?= htmlspecialchars($produit->id); ?></td>
                <td><?= htmlspecialchars($produit->libelle); ?></td>
                <td><?= htmlspecialchars($prixFinale); ?> <i class="fa fa-solid fa-dollar"></i></td>
                <td><?= htmlspecialchars($discount); ?> %</td>
                <td><?= htmlspecialchars($produit->categorie_libelle); ?></td>
                <td><?= htmlspecialchars($produit->date_creation); ?></td>
                <td>
                    <img class="img-fluid" width="90" src="upload/produit/<?= htmlspecialchars($produit->image); ?>" alt="<?= htmlspecialchars($produit->libelle); ?>">
                </td>
                <td>
                    <a class="btn btn-primary" href="modifier_produit.php?id=<?= htmlspecialchars($produit->id); ?>">Modifier</a>
                    <a class="btn btn-danger" href="supprimer_produit.php?id=<?= htmlspecialchars($produit->id); ?>" onclick="return confirm('Voulez-vous vraiment supprimer le produit <?= htmlspecialchars($produit->libelle); ?> ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
