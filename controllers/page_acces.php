<?php
session_start; 
//Bouchon 
$_SESSION['profil'] = 'user';  
$_SESSION['profil'] = 'admin ';
?> 
<html><head> 
    link rel="stylesheet" href="./css/style.css" />
</head>
<body>
<?php
include ("liste_produits_m.php");
include ("liste_produits_v.php");
?>      
</body></html>
