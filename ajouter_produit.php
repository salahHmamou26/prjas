<!doctype html>
<html lang="en">
<head>
    <?php include 'include/head.php' ?>
    <title>Ajouter produit</title>
    
</head>
<body>
<?php
require_once 'include/Database.php';
require_once 'include/Product.php';
require_once 'include/SessionManager.php';
include 'include/nav.php';

$sessionManager = new SessionManager();
$sessionManager->isUserLoggedIn(); 


if ($_SESSION['utilisateur']['role'] !== 'admin') {
    header('Location: index.php'); 
    exit();
}

$database = new Database();
$db = $database->getConnection();

$produit = new Product($db);

if (isset($_POST['ajouter'])) {
    $produit->libelle = $_POST['libelle'];
    $produit->prix = $_POST['prix'];
    $produit->discount = $_POST['discount'];
    $produit->categorie_id = $_POST['categorie'];
    $produit->description = $_POST['description'];
    $produit->date_creation = date('Y-m-d H:i:s'); 
    $produit->image = $_FILES['image'];

    if ($produit->processImageUpload($produit->image)) {
        if (!empty($produit->libelle) && !empty($produit->prix) && !empty($produit->categorie_id)) {
            if ($produit->create()) {
                header('location: produits.php');
                exit();
            } else {
                echo '<div class="alert alert-danger" role="alert">Une erreur est survenue lors de l\'ajout du produit.</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">Libelle, prix, et catégorie sont obligatoires.</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">Une erreur est survenue lors de l\'upload de l\'image.</div>';
    }
}

?>
<div class="container py-2">
    <h4>Ajouter produit</h4>
    <form method="post" enctype="multipart/form-data">
        <label class="form-label">Libelle</label>
        <input type="text" class="form-control" name="libelle" required>

        <label class="form-label">Prix</label>
        <input type="number" class="form-control" step="0.1" name="prix" min="0" required>

        <label class="form-label">Discount</label>
        <input type="range" value="0" class="form-control" name="discount" min="0" max="90">

        <label class="form-label">Description</label>
        <textarea class="form-control" name="description"></textarea>

        <label class="form-label">Image</label>
        <input type="file" class="form-control" name="image">

        <?php
   
        $categories = $db->query('SELECT * FROM categories')->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <label class="form-label">Catégorie</label>
        <select name="categorie" class="form-control" required>
            <option value="">Choisissez une catégorie</option>
            <?php
            foreach ($categories as $categorie) {
                echo "<option value='" . 
$categorie['id'] . "'>" . $categorie['libelle'] . "</option>";
            }
            ?>
        </select>

        <input type="submit" value="Ajouter produit" class="btn btn-primary my-2" name="ajouter">
    </form>
</div>

</body>
</html>
