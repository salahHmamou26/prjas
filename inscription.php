<?php
session_start();
require_once 'include/Database.php';
require_once 'include/User.php';
$database = new Database();
$pdo = $database->getConnection();
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['register'])) {
        $user = new User($pdo);
        $user->login = $_POST['login'];
        $user->password = $_POST['password'];

        $result = $user->registerUser();
        if ($result === true) {
            $message = "Inscription réussie. Vous pouvez maintenant vous connecter.";
        } else {
            $message = $result;
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <?php include './include/head_front.php'; ?>
    <title>Inscription</title>
    <style>
       
       .navbar {
           background-color: #343a40; 
           color: #ffffff;
       }
   
      
      
       .navbar .nav-link.active {
           color: #FFD700; 
       }
   
       
   
    
       .btn.float-end {
           background-color: #FFD700; 
           color: #343a40; 
       }
   
      
           
       </style>
</head>
<body>
    <?php include './include/nav.php'; ?>
    <div class="container py-4">
        <h4>Inscription</h4>
        <?php if ($message): ?>
            <div class="alert alert-info">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="">
            <div class="form-group">
                <label for="login">Nom d'utilisateur</label>
                <input type="text" class="form-control" id="login" name="login" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" name="register" class="btn btn-primary">S'inscrire</button>
        </form>
    </div>
</body>
</html>
