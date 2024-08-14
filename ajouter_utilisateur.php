<!doctype html>
<html lang="en">
<head>
    <?php include 'include/head.php' ?>
    <title>Ajouter utilisateur</title>
</head>
<body>
<?php
require_once 'include/Database.php';
require_once 'include/User.php';
include 'include/nav.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

if (isset($_POST['ajouter'])) {
    $user->login = $_POST['login'];
    $user->password = $_POST['password'];
    $user->date = date('Y-m-d');

    if (!empty($user->login) && !empty($user->password)) {
        
        if (!$user->loginExists()) {
            if ($user->registerUser()) {
                header('location: connexion.php');
            } else {
                ?>
                <div class="alert alert-danger" role="alert">
                    Une erreur est survenue lors de l'ajout de l'utilisateur.
                </div>
                <?php
            }
        } else {
            ?>
            <div class="alert alert-danger" role="alert">
                Ce login est déjà utilisé. Veuillez en choisir un autre.
            </div>
            <?php
        }
    } else {
        ?>
        <div class="alert alert-danger" role="alert">
            Login et mot de passe sont obligatoires.
        </div>
        <?php
    }
}
?>
<div class="container py-2">
    <h4>Ajouter utilisateur</h4>
    <form method="post" autocomplete="off">
        <label class="form-label">Login</label>
        <input type="text" class="form-control" name="login" required>

        <label class="form-label">Password</label>
        <input type="password" class="form-control" name="password" required>

        <input type="submit" value="Ajouter utilisateur" class="btn btn-primary my-2" name="ajouter">
    </form>
</div>

</body>
</html>
