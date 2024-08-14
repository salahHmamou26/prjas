<?php
session_start();
require_once '../include/database.php'; // Inclure le fichier de connexion à la base de données

// Initialisation de la connexion à la base de données
$database = new Database();
$pdo = $database->getConnection(); // Récupérer l'objet PDO

// Vérification que la connexion est bien établie
if (!$pdo) {
    die("Erreur de connexion à la base de données.");
}

$id = $_GET['id'];
$sqlState = $pdo->prepare("SELECT * FROM produit WHERE id=?");
$sqlState->execute([$id]);
$produit = $sqlState->fetch(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
    <?php include '../include/head_front.php' ?>
    <title>Produit | <?php echo htmlspecialchars($produit['libelle']); ?></title>
</head>
<body>
<?php include '../include/nav_front.php' ?>
<div class="container py-2">
    <h4><?php echo htmlspecialchars($produit['libelle']); ?></h4>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img class="img img-fluid w-75" src="../upload/produit/<?php echo htmlspecialchars($produit['image']); ?>"
                     alt="<?php echo htmlspecialchars($produit['libelle']); ?>">
            </div>
            <div class="col-md-6">
                <?php
                $discount = $produit['discount'];
                $prix = $produit['prix'];
                ?>
                <div class="d-flex align-items-center">
                    <h1 class="w-100"><?php echo htmlspecialchars($produit['libelle']); ?></h1>
                    <?php if (!empty($discount)) { ?>
                        <span class="badge text-bg-success">- <?php echo htmlspecialchars($discount); ?> %</span>
                    <?php } ?>
                </div>
                <hr>

                <p class="text-justify">
                    <?php echo htmlspecialchars($produit['description']); ?>
                </p>
                <hr>
                <div class="d-flex">
                    <?php
                    if (!empty($discount)) {
                        $total = $prix - (($prix * $discount) / 100);
                        ?>
                        <h5 class="mx-1">
                            <span class="badge text-bg-danger"><strike> <?php echo htmlspecialchars($prix); ?> <i class="fa fa-solid fa-dollar"></i> </strike></span>
                        </h5>
                        <h5 class="mx-1">
                            <span class="badge text-bg-success"><?php echo htmlspecialchars($total); ?> <i class="fa fa-solid fa-dollar"></i></span>
                        </h5>
                        <?php
                    } else {
                        $total = $prix;
                        ?>
                        <h5>
                            <span class="badge text-bg-success"><?php echo htmlspecialchars($total); ?> <i class="fa fa-solid fa-dollar"></i></span>
                        </h5>
                        <?php
                    }
                    ?>
                </div>
                <hr>
                <?php
                $idProduit = $produit['id'];
                include '../include/front/counter.php';
                ?>
                <hr>
            </div>
        </div>
    </div>
</div>
</body>
</html>
