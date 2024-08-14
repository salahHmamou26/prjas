<?php
session_start();


if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'admin') {
    header("Location: connexion.php");
    exit();
}

?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/head.php' ?>
    <title>Administration</title>
</head>
<body>
<?php include 'include/nav.php' ?>
<div class="container py-2">
    <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['utilisateur']['login']); ?>!</h1>
    <p>Vous êtes connecté en tant qu'administrateur.</p>
    
   
    <p><a href="manage_users.php">Gérer les utilisateurs</a></p>
    <p><a href="manage_products.php">Gérer les produits</a></p>
   

</div>
</body>
</html>

