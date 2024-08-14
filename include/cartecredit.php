<?php

class CarteCredit {
    private $pdo;
    private $idCommande;
    private $numeroCarte;
    private $dateExpiration;
    private $cvc;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function setDetails($idCommande, $numeroCarte, $dateExpiration, $cvc) {
        $this->idCommande = $idCommande;
        $this->numeroCarte = $numeroCarte;
        $this->dateExpiration = $dateExpiration;
        $this->cvc = $cvc;
    }

    public function sauvegarderCarte() {
        $sql = "INSERT INTO cartes_credit (id_commande, numero_carte, date_expiration, cvc) 
                VALUES (:id_commande, :numero_carte, :date_expiration, :cvc)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_commande', $this->idCommande);
        $stmt->bindParam(':numero_carte', $this->numeroCarte);
        $stmt->bindParam(':date_expiration', $this->dateExpiration);
        $stmt->bindParam(':cvc', $this->cvc);
        return $stmt->execute();
    }
}

?>
