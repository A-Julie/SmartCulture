<?php
$ligne = $resultats->fetch();
echo "<div name='element_produit'>";
	echo 'Produits : '.$ligne->nom_produit.'<br />';
	echo $ligne->description_produit.'<br />';
echo "</div>";
echo "<a href='./controllers/liste_produits_c.php'>Retour</a>";
?>