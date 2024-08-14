<!doctype html>
<html lang="en">
<head>
    <?php include 'include/head.php' ?>
    <title>Liste des catégories</title>
</head>
<body>
<?php
require_once 'include/Database.php';
require_once 'include/Categorie.php';
include 'include/nav.php';

$database = new Database();
$db = $database->getConnection();

$category = new Category($db);
$categories = $category->readAll();
?>
<div class="container py-2">
    <h2>Liste des catégories</h2>
    <a href="ajouter_categorie.php" class="btn btn-primary">Ajouter catégorie</a>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#ID</th>
                <th>Libelle</th>
                <th>Description</th>
                <th>Icone</th>
                <th>Date</th>
                <th>Opérations</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($categories as $categorie) {
            ?>
            <tr>
                <td><?php echo htmlspecialchars($categorie['id']); ?></td>
                <td><?php echo htmlspecialchars($categorie['libelle']); ?></td>
                <td><?php echo htmlspecialchars($categorie['description']); ?></td>
                <td>
                    <i class="fa <?php echo htmlspecialchars($categorie['icone']); ?>"></i>
                </td>
                <td><?php echo htmlspecialchars($categorie['date_creation']); ?></td>
                <td>
                    <a href="modifier_categorie.php?id=<?php echo htmlspecialchars($categorie['id']); ?>" class="btn btn-primary">Modifier</a>
                    <a href="supprimer_categorie.php?id=<?php echo htmlspecialchars($categorie['id']); ?>" onclick="return confirm('Voulez vous vraiment supprimer la catégorie <?php echo htmlspecialchars($categorie['libelle']); ?>');" class="btn btn-danger">Supprimer</a>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>

</body>
</html>
