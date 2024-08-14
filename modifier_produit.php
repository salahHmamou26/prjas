<!doctype html>
<html lang="en">
<head>
    <?php include 'include/head.php' ?>
    <title>Modifier produit</title>
</head>
<body>
<?php
require_once 'include/Database.php';
require_once 'include/Product.php';
include 'include/nav.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$id = $_GET['id'];
$product->readOne($id);

if (isset($_POST['modifier'])) {
    $product->libelle = $_POST['libelle'];
    $product->prix = $_POST['prix'];
    $product->discount = $_POST['discount'];
    $product->categorie_id = $_POST['categorie'];
    $product->description = $_POST['description'];
    $product->image = $_FILES['image']['name'];

    if (!empty($product->libelle) && !empty($product->prix) && !empty($product->categorie_id)) {
        if ($product->update(!empty($product->image))) {
            header('location: produits.php');
        } else {
            ?>
            <div class="alert alert-danger" role="alert">
                Une erreur est survenue lors de la mise à jour.
            </div>
            <?php
        }
    } else {
        ?>
        <div class="alert alert-danger" role="alert">
            Libelle, prix, et catégorie sont obligatoires.
        </div>
        <?php
    }
}
?>
<div class="container py-2">
    <h4>Modifier produit</h4>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= htmlspecialchars($product->id); ?>">
        <label class="form-label">Libelle</label>
        <input type="text" class="form-control" name="libelle" value="<?= htmlspecialchars($product->libelle); ?>">

        <label class="form-label">Prix</label>
        <input type="number" class="form-control" step="0.1" name="prix" min="0" value="<?= htmlspecialchars($product->prix); ?>">

        <label class="form-label">Discount</label>
        <input type="range" value="<?= htmlspecialchars($product->discount); ?>" class="form-control" name="discount" min="0" max="90">

        <label class="form-label">Description</label>
        <textarea class="form-control" name="description"><?= htmlspecialchars($product->description); ?></textarea>

        <label class="form-label">Image</label>
        <input type="file" class="form-control" name="image">
        <?php if (!empty($product->image)): ?>
            <img width="250" class="img img-fluid" src="upload/produit/<?= htmlspecialchars($product->image); ?>"><br>
        <?php endif; ?>

        <label class="form-label">Catégorie</label>
        <?php
        $categories = $db->query('SELECT * FROM categories')->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <select name="categorie" class="form-control">
            <option value="">Choisissez une catégorie</option>
            <?php
            foreach ($categories as $categorie) {
                $selected = $product->categorie_id == $categorie['id'] ? ' selected ' : '';
                echo "<option $selected value='" . $categorie['id'] . "'>" . htmlspecialchars($categorie['libelle']) . "</option>";
            }
            ?>
        </select>
        <input type="submit" value="Modifier produit" class="btn btn-primary my-2" name="modifier">
    </form>
</div>

</body>
</html>
