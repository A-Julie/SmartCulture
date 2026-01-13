<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Récupérer la connexion PDO
$pdo = require_once '../database/connect_bdd.php';
require_once '../models/authentication_m.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'login';

switch($action) {
   case 'login':
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        $user = loginUser($pdo, $email, $password);
        
        if ($user) {
            $_SESSION['user_id'] = $user['id_utilisateur'];
            $_SESSION['user_nom'] = $user['nom'];
            $_SESSION['user_prenom'] = $user['prenom'];
            $_SESSION['user_email'] = $user['email'];
            
            header('Location: catalogue_c.php');  // ⬅️ ICI
            exit;
        } else {
            $error = "Identifiants incorrects";
            require_once '../views/authentication_v.php';
        }
    } else {
        require_once '../views/authentication_v.php';
    }
        break;
        
    case 'logout':
        session_destroy();
        header('Location: authentication_c.php');
        exit;
        break;
        
    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');
            $prenom = trim($_POST['prenom'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            
            // Validation
            if (empty($nom) || empty($prenom) || empty($email) || empty($password)) {
                $error = "Tous les champs sont obligatoires";
                $_GET['register'] = true;
                require_once '../views/authentication_v.php';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Format d'email invalide";
                $_GET['register'] = true;
                require_once '../views/authentication_v.php';
            } elseif ($password !== $confirm_password) {
                $error = "Les mots de passe ne correspondent pas";
                $_GET['register'] = true;
                require_once '../views/authentication_v.php';
            } elseif (strlen($password) < 6) {
                $error = "Le mot de passe doit contenir au moins 6 caractères";
                $_GET['register'] = true;
                require_once '../views/authentication_v.php';
            } else {
                $result = registerUser($pdo, $nom, $prenom, $email, $password);
                
                if ($result === true) {
                    $success = "✅ Inscription réussie ! Vous pouvez maintenant vous connecter.";
                    require_once '../views/authentication_v.php';
                } else {
                    $error = "❌ Erreur lors de l'inscription. Cet email existe peut-être déjà.";
                    $_GET['register'] = true;
                    require_once '../views/authentication_v.php';
                }
            }
        } else {
            $_GET['register'] = true;
            require_once '../views/authentication_v.php';
        }
        break;
        
    default:
        require_once '../views/authentication_v.php';
        break;
}
?>