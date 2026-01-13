<?php
session_start();

require_once '../includes/auth_check.php';
checkAuth();

$pdo = require_once '../database/connect_bdd.php';
require_once '../models/produits_m.php';

// Récupérer les filtres
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$type = isset($_GET['type']) ? $_GET['type'] : '';

// Récupérer les produits selon les filtres
if (!empty($search)) {
    $produits = searchProduits($pdo, $search);
    $titre_page = "Résultats pour : " . htmlspecialchars($search);
} elseif (!empty($type)) {
    $produits = getProduitsByType($pdo, $type);
    $titre_page = "Catalogue " . htmlspecialchars($type);
} else {
    $produits = getAllProduits($pdo);
    $titre_page = "Tous nos produits";
}

// Afficher la vue
require_once '../views/catalogue_v.php';
?>