<!-- ============================================ -->
<?php
// Inclusion de la connexion à la BDD
include_once("./database/connect_bdd.php");

// Initialisation du tableau de produits
$produits = array();

// Récupération des DVD
try {
    $sql_dvd = "SELECT id, titre, description, prix, stock, 'DVD' as type_produit FROM dvd WHERE actif = 1";
    $result_dvd = $pdo->query($sql_dvd);
    while ($row = $result_dvd->fetch(PDO::FETCH_ASSOC)) {
        $produits[] = $row;
    }
} catch (PDOException $e) {
    error_log("Erreur DVD : " . $e->getMessage());
}

// Récupération des BLURAY
try {
    $sql_bluray = "SELECT id, titre, description, prix, stock, 'BLURAY' as type_produit FROM bluray WHERE actif = 1";
    $result_bluray = $pdo->query($sql_bluray);
    while ($row = $result_bluray->fetch(PDO::FETCH_ASSOC)) {
        $produits[] = $row;
    }
} catch (PDOException $e) {
    error_log("Erreur BLURAY : " . $e->getMessage());
}

// Récupération des LIVRES (si vous voulez les afficher maintenant)
try {
    $sql_livres = "SELECT id, titre, description, prix, stock, 'LIVRE' as type_produit FROM livres WHERE actif = 1";
    $result_livres = $pdo->query($sql_livres);
    while ($row = $result_livres->fetch(PDO::FETCH_ASSOC)) {
        $produits[] = $row;
    }
} catch (PDOException $e) {
    error_log("Erreur LIVRES : " . $e->getMessage());
}

// Récupération des JEUX (si vous voulez les afficher maintenant)
try {
    $sql_jeux = "SELECT id, titre, description, prix, stock, 'JEU' as type_produit FROM jeu_de_societe WHERE actif = 1";
    $result_jeux = $pdo->query($sql_jeux);
    while ($row = $result_jeux->fetch(PDO::FETCH_ASSOC)) {
        $produits[] = $row;
    }
} catch (PDOException $e) {
    error_log("Erreur JEUX : " . $e->getMessage());
}

// Nombre total de produits
$nb_produits = count($produits);
?>


<!-- ============================================ -->