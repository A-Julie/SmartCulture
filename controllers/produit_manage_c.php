<?php
session_start();

require_once '../includes/auth_check.php';
checkAuth();

// Vérifier que l'utilisateur est admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Accès refusé']);
    exit;
}

$pdo = require_once '../database/connect_bdd.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'delete':
        deleteProduct($pdo);
        break;
    
    case 'update':
        updateProduct($pdo);
        break;
    
    case 'get':
        getProduct($pdo);
        break;
    
    default:
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Action invalide']);
        break;
}

function deleteProduct($pdo) {
    $id = intval($_POST['id'] ?? 0);
    $type = $_POST['type'] ?? '';
    
    if ($id <= 0 || empty($type)) {
        echo json_encode(['success' => false, 'message' => 'Paramètres invalides']);
        return;
    }
    
    try {
        if ($type === 'DVD') {
            $query = "DELETE FROM dvd WHERE id = :id";
        } elseif ($type === 'Bluray') {
            $query = "DELETE FROM bluray WHERE id = :id";
        } else {
            echo json_encode(['success' => false, 'message' => 'Type de produit invalide']);
            return;
        }
        
        $stmt = $pdo->prepare($query);
        $result = $stmt->execute(['id' => $id]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Produit supprimé avec succès']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression']);
        }
        
    } catch (PDOException $e) {
        error_log("Erreur suppression produit: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Erreur serveur']);
    }
}

function updateProduct($pdo) {
    $id = intval($_POST['id'] ?? 0);
    $type = $_POST['type'] ?? '';
    $titre = trim($_POST['titre'] ?? '');
    $date_sortie = trim($_POST['date_sortie'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $prix = floatval($_POST['prix'] ?? 0);
    $stock = intval($_POST['stock'] ?? 0);
    
    if ($id <= 0 || empty($type) || empty($titre) || empty($date_sortie)) {
        echo json_encode(['success' => false, 'message' => 'Tous les champs obligatoires doivent être remplis']);
        return;
    }
    
    try {
        if ($type === 'DVD') {
            $query = "UPDATE dvd SET titre = :titre, date_sortie = :date_sortie, description = :description, 
                      prix = :prix, stock = :stock WHERE id = :id";
        } elseif ($type === 'Bluray') {
            $query = "UPDATE bluray SET titre = :titre, date_sortie = :date_sortie, description = :description, 
                      prix = :prix, stock = :stock WHERE id = :id";
        } else {
            echo json_encode(['success' => false, 'message' => 'Type de produit invalide']);
            return;
        }
        
        $stmt = $pdo->prepare($query);
        $result = $stmt->execute([
            'id' => $id,
            'titre' => $titre,
            'date_sortie' => $date_sortie,
            'description' => $description,
            'prix' => $prix,
            'stock' => $stock
        ]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Produit modifié avec succès']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la modification']);
        }
        
    } catch (PDOException $e) {
        error_log("Erreur modification produit: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Erreur serveur']);
    }
}

function getProduct($pdo) {
    $id = intval($_GET['id'] ?? 0);
    $type = $_GET['type'] ?? '';
    
    if ($id <= 0 || empty($type)) {
        echo json_encode(['success' => false, 'message' => 'Paramètres invalides']);
        return;
    }
    
    try {
        if ($type === 'DVD') {
            $query = "SELECT * FROM dvd WHERE id = :id";
        } elseif ($type === 'Bluray') {
            $query = "SELECT * FROM bluray WHERE id = :id";
        } else {
            echo json_encode(['success' => false, 'message' => 'Type de produit invalide']);
            return;
        }
        
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($product) {
            echo json_encode(['success' => true, 'product' => $product]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Produit non trouvé']);
        }
        
    } catch (PDOException $e) {
        error_log("Erreur récupération produit: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Erreur serveur']);
    }
}
?>