<?php
// models/produits_m.php

function getAllProduits($pdo) {
    $produits = array();

    // Récupération des DVD
    try {
        $sql_dvd = "SELECT id, titre, date_sortie, description, prix, stock, 'DVD' as type FROM dvd WHERE actif = 1";
        $result_dvd = $pdo->query($sql_dvd);
        while ($row = $result_dvd->fetch(PDO::FETCH_ASSOC)) {
            $produits[] = $row;
        }
    } catch (PDOException $e) {
        error_log("Erreur DVD : " . $e->getMessage());
    }

    // Récupération des BLURAY
    try {
        $sql_bluray = "SELECT id, titre, date_sortie, description, prix, stock, 'Bluray' as type FROM bluray WHERE actif = 1";
        $result_bluray = $pdo->query($sql_bluray);
        while ($row = $result_bluray->fetch(PDO::FETCH_ASSOC)) {
            $produits[] = $row;
        }
    } catch (PDOException $e) {
        error_log("Erreur BLURAY : " . $e->getMessage());
    }

    return $produits;
}

function getProduitsByType($pdo, $type) {
    $produits = array();
    
    try {
        if ($type === 'DVD') {
            $sql = "SELECT id, titre, date_sortie, description, prix, stock, 'DVD' as type FROM dvd WHERE actif = 1";
        } elseif ($type === 'Bluray') {
            $sql = "SELECT id, titre, date_sortie, description, prix, stock, 'Bluray' as type FROM bluray WHERE actif = 1";
        } else {
            return $produits;
        }
        
        $result = $pdo->query($sql);
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $produits[] = $row;
        }
    } catch (PDOException $e) {
        error_log("Erreur getProduitsByType : " . $e->getMessage());
    }
    
    return $produits;
}

function searchProduits($pdo, $search) {
    $produits = array();
    
    // Chercher dans DVD
    try {
        $sql_dvd = "SELECT id, titre, date_sortie, description, prix, stock, 'DVD' as type FROM dvd WHERE actif = 1 AND titre LIKE :search";
        $stmt_dvd = $pdo->prepare($sql_dvd);
        $stmt_dvd->execute(['search' => '%' . $search . '%']);
        while ($row = $stmt_dvd->fetch(PDO::FETCH_ASSOC)) {
            $produits[] = $row;
        }
    } catch (PDOException $e) {
        error_log("Erreur recherche DVD : " . $e->getMessage());
    }
    
    // Chercher dans Bluray
    try {
        $sql_bluray = "SELECT id, titre, date_sortie, description, prix, stock, 'Bluray' as type FROM bluray WHERE actif = 1 AND titre LIKE :search";
        $stmt_bluray = $pdo->prepare($sql_bluray);
        $stmt_bluray->execute(['search' => '%' . $search . '%']);
        while ($row = $stmt_bluray->fetch(PDO::FETCH_ASSOC)) {
            $produits[] = $row;
        }
    } catch (PDOException $e) {
        error_log("Erreur recherche Bluray : " . $e->getMessage());
    }
    
    return $produits;
}

function getProduitById($pdo, $id, $type) {
    try {
        if ($type === 'DVD') {
            $sql = "SELECT id, titre, date_sortie, description, prix, stock, 'DVD' as type FROM dvd WHERE id = :id AND actif = 1";
        } elseif ($type === 'Bluray') {
            $sql = "SELECT id, titre, date_sortie, description, prix, stock, 'Bluray' as type FROM bluray WHERE id = :id AND actif = 1";
        } else {
            return null;
        }
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur getProduitById : " . $e->getMessage());
        return null;
    }
}
?> 