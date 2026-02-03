<?php
session_start();

require_once '../includes/auth_check.php';
requireAdmin(); // PROTECTION ADMIN

$pdo = require_once '../database/connect_bdd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'] ?? '';
    $titre = trim($_POST['titre'] ?? '');
    $date_sortie = trim($_POST['date_sortie'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $prix = floatval($_POST['prix'] ?? 0);
    $stock = intval($_POST['stock'] ?? 0);
    
    // Validation
    if (empty($titre) || empty($date_sortie) || empty($type)) {
        echo json_encode(['success' => false, 'message' => 'Tous les champs obligatoires doivent être remplis']);
        exit;
    }
    
    try {
        if ($type === 'DVD') {
            $query = "INSERT INTO dvd (titre, date_sortie, description, prix, stock, actif) 
                      VALUES (:titre, :date_sortie, :description, :prix, :stock, 1)";
        } elseif ($type === 'Bluray') {
            $query = "INSERT INTO bluray (titre, date_sortie, description, prix, stock, actif) 
                      VALUES (:titre, :date_sortie, :description, :prix, :stock, 1)";
        } else {
            echo json_encode(['success' => false, 'message' => 'Type de produit invalide']);
            exit;
        }
        
        $stmt = $pdo->prepare($query);
        $result = $stmt->execute([
            'titre' => $titre,
            'date_sortie' => $date_sortie,
            'description' => $description,
            'prix' => $prix,
            'stock' => $stock
        ]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Produit ajouté avec succès']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout du produit']);
        }
        
    } catch (PDOException $e) {
        error_log("Erreur ajout produit: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Erreur serveur']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
}
?>