<?php
// includes/auth_check.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Vérifie si l'utilisateur est connecté
 */
function checkAuth() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: authentication_c.php');
        exit;
    }
}

/**
 * Vérifie si l'utilisateur est admin
 * À utiliser sur les pages réservées aux admins
 */
function requireAdmin() {
    // Vérifier d'abord si connecté
    if (!isset($_SESSION['user_id'])) {
        header('Location: authentication_c.php');
        exit;
    }
    
    // Vérifier si admin
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        // L'utilisateur n'est pas admin, on le bloque
        http_response_code(403);
        die('
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Accès refusé</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background: #141414;
                    color: white;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                }
                .error-box {
                    text-align: center;
                    background: #1a0000;
                    padding: 40px;
                    border-radius: 10px;
                    border: 2px solid #dc143c;
                }
                .error-icon { font-size: 80px; margin-bottom: 20px; }
                h1 { color: #dc143c; margin-bottom: 15px; }
                p { margin-bottom: 25px; color: #999; }
                a {
                    display: inline-block;
                    padding: 12px 30px;
                    background: #e50914;
                    color: white;
                    text-decoration: none;
                    border-radius: 5px;
                    font-weight: bold;
                }
                a:hover { background: #f40612; }
            </style>
        </head>
        <body>
            <div class="error-box">
                <div class="error-icon">🚫</div>
                <h1>Accès Refusé</h1>
                <p>Vous n\'avez pas les droits nécessaires pour accéder à cette page.<br>
                Cette action est réservée aux administrateurs.</p>
                <a href="catalogue_c.php">← Retour au catalogue</a>
            </div>
        </body>
        </html>
        ');
    }
}