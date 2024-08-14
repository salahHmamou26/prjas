<!doctype html>
<html lang="en">
<head>
    <?php include 'include/head.php' ?>
    <title>Ajouter catégorie</title>
    
</head>
<body>
<?php
require_once 'include/Database.php';
require_once 'include/Categorie.php';
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

$category = new Category($db);
if (isset($_POST['ajouter'])) {
    $category->libelle = $_POST['libelle'];
    $category->description = $_POST['description'];
    $category->icone = $_POST['icone'];

    
    if (!empty($category->libelle) && !empty($category->description)) {
        if ($category->create()) {
            header('location: categories.php');
            exit();
        } else {
            ?>
            <div class="alert alert-danger" role="alert">
                Une erreur est survenue lors de l'ajout de la catégorie.
            </div>
            <?php
        }
    } else {
        ?>
        <div class="alert alert-danger" role="alert">
            Libelle et description sont obligatoires.
        </div>
        <?php
    }
}
?>
<div class="container py-2">
    <h4>Ajouter catégorie</h4>
    <form method="post">
        <label class="form-label">Libelle</label>
        <input type="text" class="form-control" name="libelle" required>

        <label class="form-label">Description</label>
        <textarea class="form-control" name="description" required></textarea>

        <label class="form-label">Icône</label>
        <input type="text" class="form-control" name="icone" required>

        <input type="submit"  value="Ajouter catégorie" class="btn btn-primary my-2" name="ajouter">
    </form>
</div>

</body>
</html>
