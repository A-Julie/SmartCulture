<?php
include ("./databaseconnect_bdd.php");

$id_prod=$_GET["id_prod"];

$chaine_sql="delete from produits where id_produits=".$id_prod;
$resultats=$pdo->exec($chaine_sql);

?>