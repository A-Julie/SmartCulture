<?php
include ("./databaseconnect_bdd.php");

$id_prod=$_GET["id_prod"];

$chaine_sql="select * from produits where id_produits=".$id_prod;
$resultats=$pdo->query($chaine_sql);
$resultats->setFetchMode(PDO::FETCH_OBJ);
?>