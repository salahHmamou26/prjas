<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


$connecte = isset($_SESSION['utilisateur']);
$role = $_SESSION['utilisateur']['role'] ?? null;

?>
<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Ecommerce</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php
        
        $currentPage = basename($_SERVER['PHP_SELF']);
        ?>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?php if ($currentPage == 'index.php') echo 'active' ?>"
                       aria-current="page" href="index.php"><i class="fa-solid fa-home"></i> Accueil</a>
                </li>
                <?php if ($connecte && $role === 'admin'):  ?>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($currentPage == 'ajouter_utilisateur.php') echo 'active' ?>"
                           aria-current="page" href="ajouter_utilisateur.php"><i class="fa-solid fa-user-plus"></i>
                            Ajouter utilisateur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($currentPage == 'categories.php') echo 'active' ?>"
                           aria-current="page" href="categories.php"><i class="fa-brands fa-dropbox"></i> Liste des catégories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($currentPage == 'produits.php') echo 'active' ?>"
                           aria-current="page" href="produits.php"><i class="fa-solid fa-tag"></i> Liste des produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($currentPage == 'commandes.php') echo 'active' ?>"
                           aria-current="page" href="commandes.php"><i class="fa-solid fa-barcode"></i> Commandes</a>
                    </li>
                <?php endif; ?>
                <?php if ($connecte): ?>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="deconnexion.php"><i class="fa-solid fa-right-from-bracket"></i> Déconnexion</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($currentPage == 'connexion.php') echo 'active' ?>"
                           href="connexion.php"><i class="fa-solid fa-arrow-right-to-bracket"></i> Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($currentPage == 'inscription.php') echo 'active' ?>"
                           href="inscription.php"><i class="fa-solid fa-user-plus"></i> Inscription</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <?php
        $productCount = 0;
        if (isset($_SESSION['utilisateur'])) {
            $idUtilisateur = $_SESSION['utilisateur']['id'];
            $productCount = count($_SESSION['panier'][$idUtilisateur] ?? []);
        }

        function calculerRemise($prix, $discount) {
            return $prix - (($prix * $discount) / 100);
        }
        ?>
        <a class="btn float-end" href="front/"><i class="fa-solid fa-cart-shopping"></i> Site front</a>
    </div>
</nav>
