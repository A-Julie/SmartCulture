<?php
$db = "smartculture";
$dbhost = "localhost";
$dbport = "3306";
$dbuser = "userSC";
$dbpasswd = "userSC";

try {
    $pdo = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db, $dbuser, $dbpasswd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // Retourner la connexion
    return $pdo;
    
} catch (PDOException $e) {
    die("❌ Erreur de connexion : " . $e->getMessage());
}
?>


