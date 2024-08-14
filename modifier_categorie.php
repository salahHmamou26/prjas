<!doctype html>
<html lang="en">
<head>
    <?php include 'include/head.php' ?>
    <title>Modifier catégorie</title>
</head>
<body>
<?php
require_once 'include/Database.php';
require_once 'include/Categorie.php';
include 'include/nav.php';

$database = new Database();
$db = $database->getConnection();

$category = new Category($db);

$id = $_GET['id'];
$category->readOne($id);

if (isset($_POST['modifier'])) {
    $category->libelle = $_POST['libelle'];
    $category->description = $_POST['description'];
    $category->icone = $_POST['icone'];

    if (!empty($category->libelle) && !empty($category->description)) {
        if ($category->update()) {
            header('location: categories.php');
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
            Libelle et description sont obligatoires.
        </div>
        <?php
    }
}
?>
<div class="container py-2">
    <h4>Modifier catégorie</h4>
    <form method="post">
        <input type="hidden" class="form-control" name="id" value="<?php echo htmlspecialchars($category->id); ?>">
        <label class="form-label">Libelle</label>
        <input type="text" class="form-control" name="libelle" value="<?php echo htmlspecialchars($category->libelle); ?>">

        <label class="form-label">Description</label>
        <textarea class="form-control" name="description"><?php echo htmlspecialchars($category->description); ?></textarea>

        <label class="form-label">Icône</label>
        <input type="text" class="form-control" name="icone" value="<?php echo htmlspecialchars($category->icone); ?>">

        <input type="submit" value="Modifier catégorie" class="btn btn-primary my-2" name="modifier">
    </form>
</div>

</body>
</html>
