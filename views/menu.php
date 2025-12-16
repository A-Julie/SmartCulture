<div id="menu">
<?php 
while ($ligne = $resultats->fetch()) {
 echo '<div class="menu">';
echo "<a href='".$ligne->lien."?".$ligne->filtres."'>".$ligne->label."</a>";
echo '</div>';
echo '</br />';

}

?>
</div>