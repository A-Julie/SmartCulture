<?php
session_start();

require_once '../includes/auth_check.php';
checkAuth();

$pdo = require_once '../database/connect_bdd.php';

// Récupérer le panier depuis le formulaire
$cart_json = $_POST['cart'] ?? '[]';
$cart = json_decode($cart_json, true);

if (empty($cart)) {
    header('Location: catalogue_c.php');
    exit;
}

// Calculer le total
$total = 0;
foreach ($cart as $item) {
    $total += floatval($item['prix'] ?? 0);
}

require_once '../views/payment_v.php';
?>