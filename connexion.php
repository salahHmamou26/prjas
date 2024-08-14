<?php
session_start();
require_once 'include/Database.php';
require_once 'include/User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

if (isset($_POST['connexion'])) {
    $user->login = $_POST['login'];
    $user->password = $_POST['password'];
    $user->role = $_POST['role'];

    $error = $user->authenticate();  
}
?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/head.php' ?>
    <title>Connexion</title>
    
</head>
<body>
<?php include 'include/nav.php' ?>
<div class="container py-2">
    <?php if(isset($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    <h4>Connexion</h4>
    <form method="post">
        <label class="form-label">Login</label>
        <input type="text" class="form-control" name="login" required>

        <label class="form-label">Password</label>
        <input type="password" class="form-control" name="password" required>

        <label class="form-label">Role</label>
<select name="role" class="form-control" required>
    <option value="admin">Admin</option>
    <option value="user">User</option>
</select>

        <input type="submit" value="Connexion" class="btn btn-primary my-2" name="connexion">
    </form>
</div>
</body>
</html>
