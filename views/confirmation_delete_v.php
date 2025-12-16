<?php
$ligne = $resultats->fetch();
echo "<div name='element_produit'>";
	echo 'Produits : '.$ligne->nom_produit.'<br />';
	echo $ligne->description_produit.'<br />';
echo "</div>";
echo "<a href='./controllers/delete_fiche_c.php?id_prod=".$ligne->id_produits."'>Confirmer la suppression</a>";
echo "<br />";
echo "<a href='./controllers/liste_produits_c.php?id_prod=".$ligne->id_produits."'>Annuler la suppression</a>";
echo "<br />";
echo "<a href='./controllers/liste_produits_c.php'>Retour</a>";
?>