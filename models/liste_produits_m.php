<?php
include ("./database/connect_bdd.php");

$chaine_sql="select * from produits";
$resultats=$pdo->query($chaine_sql);
$resultats->setFetchMode(PDO::FETCH_OBJ);
?>