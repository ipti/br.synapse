<?php
session_start();
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-MENU/SCREEN
if(isset($piece_id) && $piece_id!=""){
	$SQL = "SELECT lp.screen
			FROM layer_property lp
					LEFT JOIN piece p ON p.id = lp.piece_id
			WHERE p.id=".$piece_id."";
	$res = pg_query($SQL);
	if($l = pg_fetch_array($res)){
		$screen = $l['screen'];
	}else{
		$SQL = "SELECT lp.piece_id FROM layer_property lp WHERE lp.piece_id=".$piece_id." AND lp.screen = ".$screen."";
		$res = pg_query($SQL);
		if(pg_num_rows($res)>0){
			$screen = $screen;
		}else{
			$screen = ($screen-1);
		}
	}
}

echo "<table width='140'>";
echo "<tr>";
	echo "<td class='azultit' width='110' align='center'>".$screenactivity."</td>";
	echo "<td class='azultit' width='30' align='center'>";
		if(!isset($newscreen) && !isset($newpiece)){
			echo "<a href='activity.php?";
			echo "newscreen=true";
if(isset($blockname_varchar) && $blockname_varchar!=""){echo "&blockname_varchar=".$blockname_varchar;}
if(isset($block_content) && $block_content!=""){echo "&block_content=".$block_content;}
if(isset($semantic_id) && $semantic_id!=""){echo "&semantic_id=".$semantic_id;}
if(isset($semanticname) && $semanticname!=""){echo "&semanticname=".$semanticname;}
if(isset($discipline) && $discipline!=""){echo "&discipline=".$discipline;}
if(isset($screen) && $screen!=""){echo "&screen=".$screen;}
if(isset($goal_id) && $goal_id!=""){echo "&goal_id=".$goal_id;}
if(isset($activity_id) && $activity_id!=""){echo "&activity_id=".$activity_id;}
if(isset($activitytype_id) && $activitytype_id!=""){echo "&activitytype_id=".$activitytype_id;}
			echo "' style='text-decoration:none;'>";
				echo "<img src='images/icon-plus.png' width='20' height='20' border='0'>";
			echo "</a>";
		}
	echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width='140'>";
$SQLs = "SELECT lp.screen
		 FROM layer_property lp
		 		LEFT JOIN piece p ON p.id = lp.piece_id
				LEFT JOIN activity a ON a.id = p.activity_id 
		 WHERE a.id = ".$activity_id."
		 GROUP BY lp.screen
		 ORDER BY lp.screen";
$ress = pg_query($SQLs);
if(pg_num_rows($ress)){
	$i=0;
	while($linhas = pg_fetch_array($ress)){
		$i ++;
		if(($i==1) || ($i==6) || ($i==11) || ($i==16)){ echo "<tr>"; }
//		echo "screen: ".$screen."<br>";
//		echo "linha: ".$linhas['screen']."<br>";
		if((isset($screen) && $screen==$linhas['screen']) && (!isset($newscreen) || (isset($newscreen) && $newscreen!=true))){
			echo "<td class='azulahover'>";
			echo $linhas['screen'];
		}else{
			echo "<td class='azul'>";
			echo "<a href='activity.php?";
			echo "screen=".$linhas['screen'];
if(isset($blockname_varchar) && $blockname_varchar!=""){echo "&blockname_varchar=".$blockname_varchar;}
if(isset($block_content) && $block_content!=""){echo "&block_content=".$block_content;}
if(isset($semantic_id) && $semantic_id!=""){echo "&semantic_id=".$semantic_id;}
if(isset($semanticname) && $semanticname!=""){echo "&semanticname=".$semanticname;}
if(isset($discipline) && $discipline!=""){echo "&discipline=".$discipline;}
if(isset($goal_id) && $goal_id!=""){echo "&goal_id=".$goal_id;}
if(isset($activity_id) && $activity_id!=""){echo "&activity_id=".$activity_id;}
if(isset($activitytype_id) && $activitytype_id!=""){echo "&activitytype_id=".$activitytype_id;}
			echo "'>";
			echo $linhas['screen'];
			echo "</a>";	
		}
		echo "</td>";
		if(($i==5) || ($i==10) || ($i==15)){ echo "</tr>"; }
	}
	if(isset($newscreen) && $newscreen==true){
		echo "<td class='azulahover'>";
			echo $totalscreen+1;
		echo "</td>";
	}
}else{
	echo "<td class='azulahover' align='center'>1</td>";
	$newscreen=true;
}
echo "</table>";
?>