<?php
session_start();
ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
include("includes/conecta.php");
include("goal/goal_name.php");
ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

echo '<form name="goal_ins" action="form.php" method="post">';
	echo "Habilidade1:";
	echo "<select name='habilidade' onChange=document.goal_ins.submit()>";
		$SQLh = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 11 ORDER BY name_varchar";	
		$resh = pg_query($SQLh);
		echo "<option value='".(isset($habilidade)?$habilidade:"")."'>".(isset($habilidadename)?$habilidadename:"")."</option>";
		echo "<option value=''></option>";
		while($linhah = pg_fetch_array($resh)){
			$habilidadename = $linhah['name_varchar'];
			echo "<option value='".$linhah['id']."'>".$linhah['name_varchar']."</option>";
		}
	echo "</select>";
	echo '<input type="hidden" name="discipline" value="'.$discipline.'">';		
	echo '<input type="submit" value="Sel" onClick=filtra(select)>';
echo "</form>";
?>