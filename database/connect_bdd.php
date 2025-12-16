<?php
$db="smartculture";
$dbhost="localhost";
$dbport = "3306"; // Port MySQL par défaut
$dbuser="userSC";
$dbpasswd="userSC";
 
// try {
// 		$pdo = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db.'', $dbuser, $dbpasswd);
// 	}
// catch (PDOException $e)
// 	{
// 		print "Erreur !: " . $e->getMessage() . "<br/>";
// 		die();
// 	}

try {
    $pdo = new PDO('mysql:host='.$dbhost.';dbname='.$db, $dbuser, $dbpasswd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Connexion réussie !";
    
} catch (PDOException $e) {
    echo "❌ Erreur : " . $e->getMessage();
    die();
}
?>
?>
