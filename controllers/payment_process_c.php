<?php
session_start();

require_once '../includes/auth_check.php';
checkAuth();

$pdo = require_once '../database/connect_bdd.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: catalogue_c.php');
    exit;
}

// Récupérer les données
$carte_numero = $_POST['carte_numero'] ?? '';
$carte_nom = $_POST['carte_nom'] ?? '';
$carte_expiration = $_POST['carte_expiration'] ?? '';
$carte_cvv = $_POST['carte_cvv'] ?? '';
$cart_json = $_POST['cart'] ?? '[]';
$total = floatval($_POST['total'] ?? 0);
$test_result = $_POST['test_result'] ?? 'ok'; // ok ou error

// Décoder le panier
$cart = json_decode($cart_json, true);

// Validation basique
if (empty($carte_numero) || empty($carte_nom) || empty($carte_expiration) || empty($carte_cvv)) {
    $_SESSION['payment_error'] = "Tous les champs sont obligatoires";
    header('Location: payment_c.php');
    exit;
}

// SIMULATION DE PAIEMENT
// Si test_result = "error", on simule une erreur de paiement
if ($test_result === 'error') {
    $_SESSION['payment_error'] = " Paiement refusé. Veuillez vérifier vos informations bancaires.";
    $_SESSION['cart_data'] = $cart_json;
    $_SESSION['total_data'] = $total;
    header('Location: payment_result_c.php?status=error');
    exit;
}

// PAIEMENT RÉUSSI
try {
    // Générer un numéro de commande unique
    $numero_commande = 'CMD-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(4)));
    
    // Créer la table commandes si elle n'existe pas
    $sql_create = "CREATE TABLE IF NOT EXISTS commandes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        utilisateur_id INT NOT NULL,
        numero_commande VARCHAR(50) NOT NULL UNIQUE,
        montant_total DECIMAL(10,2) NOT NULL,
        statut VARCHAR(20) DEFAULT 'payee',
        date_commande TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        carte_last4 VARCHAR(4),
        INDEX idx_user (utilisateur_id),
        INDEX idx_numero (numero_commande)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    $pdo->exec($sql_create);
    
    // Créer la table commandes_produits si elle n'existe pas
    $sql_create_items = "CREATE TABLE IF NOT EXISTS commandes_produits (
        id INT AUTO_INCREMENT PRIMARY KEY,
        commande_id INT NOT NULL,
        produit_id INT NOT NULL,
        produit_type VARCHAR(20),
        produit_titre VARCHAR(255),
        prix_unitaire DECIMAL(10,2) NOT NULL,
        quantite INT DEFAULT 1,
        INDEX idx_commande (commande_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    $pdo->exec($sql_create_items);
    
    // Insérer la commande
    $last4 = substr($carte_numero, -4);
    
    $query = "INSERT INTO commandes (utilisateur_id, numero_commande, montant_total, carte_last4) 
              VALUES (:user_id, :numero, :total, :last4)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'user_id' => $_SESSION['user_id'],
        'numero' => $numero_commande,
        'total' => $total,
        'last4' => $last4
    ]);
    
    $commande_id = $pdo->lastInsertId();
    
    // Insérer les produits de la commande
    $query_items = "INSERT INTO commandes_produits (commande_id, produit_id, produit_type, produit_titre, prix_unitaire) 
                    VALUES (:commande_id, :produit_id, :produit_type, :produit_titre, :prix)";
    $stmt_items = $pdo->prepare($query_items);
    
    foreach ($cart as $item) {
        $stmt_items->execute([
            'commande_id' => $commande_id,
            'produit_id' => $item['id'],
            'produit_type' => $item['type'],
            'produit_titre' => $item['titre'],
            'prix' => $item['prix']
        ]);
    }
    
    // Stocker les infos pour la page de succès
    $_SESSION['payment_success'] = true;
    $_SESSION['order_number'] = $numero_commande;
    $_SESSION['order_total'] = $total;
    $_SESSION['order_date'] = date('d/m/Y H:i');
    
    header('Location: payment_result_c.php?status=success');
    exit;
    
} catch (PDOException $e) {
    error_log("Erreur commande: " . $e->getMessage());
    $_SESSION['payment_error'] = "Une erreur est survenue lors du traitement de votre commande.";
    header('Location: payment_result_c.php?status=error');
    exit;
}
?>