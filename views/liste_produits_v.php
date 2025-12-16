<?php
echo "<div class='menu'>";
echo "<a href='./controllers/liste_produits_c.php'>Liste</a>&nbsp;|&nbsp;";
echo "<a href='./controllers/ajout_produits_c.php'>Ajouts</a>&nbsp;|&nbsp;";
echo "</div>";

echo "<div name='liste_produits'>";
while( $ligne = $resultats->fetch() )
 {        
	echo "<div name='element_produit'>";
		echo 'Produits : '.$ligne->nom_produit.'<br />';
		echo $ligne->description_produit.'<br />';
		echo "<a href='./controllers/fiche_detaillee_c.php?id_prod=".$ligne->id_produits."'>fiche détaillée</a>";
		echo '<br />';
		echo "<a href='./controllers/confirmation_delete_c.php?id_prod=".$ligne->id_produits."'>supprimer</a>";
	echo "</div>";
	echo '<br />';
}
echo "</div>";
?>