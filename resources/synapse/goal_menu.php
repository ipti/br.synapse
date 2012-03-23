<?php
$SQLd = "SELECT * FROM discipline ORDER BY id";
$resd = pg_query($SQLd);
echo "<div id='menu2acesso'><ul>";
while($linhad = pg_fetch_array($resd)){
	echo "<li class='dest'><a href='goal.php?discipline=".$linhad['id']."'>".$linhad['name']."</a></li>";
}
echo "</div></ul>";
?>
