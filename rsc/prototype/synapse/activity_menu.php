<?php
session_start();
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-MENU/PIECE!ELEMENT
$SQL = "SELECT *
		FROM piece
		WHERE activity_id = ".$activity_id."
		ORDER BY seq";
$res =pg_query($SQL);
if(pg_num_rows($res)){
	echo "<hr>";
	while($l = pg_fetch_array($res)){
		$SQL1 = "SELECT id FROM piece_element WHERE piece_id = ".$l['id']."";
		$res1 = pg_query($SQL1);
		if(pg_num_rows($res1)==0){
			echo "<a href='activity.php?";
				echo "newpieceelement=true&";
				echo "pieceseq=".$linhap['seq']."&";
				echo "piece_id=".$linhap['id']."&";
				echo "piecename=".$linhap['name_varchar']."&";
				echo "piecedescription=".$linhap['description']."&";
				echo "piecetype_id=".$linhap['piecetype_id'];
if(isset($screen) && $screen!=""){echo "&screen=".$screen;}
if(isset($newpiece) && $newpiece==true){echo "&newpiece=true";}
if(isset($blockname_varchar) && $blockname_varchar!=""){echo "&blockname_varchar=".$blockname_varchar;}
if(isset($block_content) && $block_content!=""){echo "&block_content=".$block_content;}
if(isset($semantic_id) && $semantic_id!=""){echo "&semantic_id=".$semantic_id;}
if(isset($semanticname) && $semanticname!=""){echo "&semanticname=".$semanticname;}
if(isset($discipline) && $discipline!=""){echo "&discipline=".$discipline;}
if(isset($goal_id) && $goal_id!=""){echo "&goal_id=".$goal_id;}
if(isset($activity_id) && $activity_id!=""){echo "&activity_id=".$activity_id;}
if(isset($activitytype_id) && $activitytype_id!=""){echo "&activitytype_id=".$activitytype_id;}
			echo "'>";
				if(isset($piece_id) && $piece_id == $l['id']){ echo "<u>"; }
				echo $l['seq']." - ".($l['name_varchar']!=""?$l['name_varchar']:"");
				if(isset($piece_id) && $piece_id == $l['id']){ echo "</u>"; }
			echo "</a>";
			echo "<a href='#' onClick=\"javascript:window.open('piece_ins.php?acao=2&activity_id=".$activity_id."&piece_id=".$l['id']."&";
			echo "piecetype_id=".$linhap['piecetype_id']."&nameupd=".$l['name_varchar']."&descriptionupd=".$l['description']."&sequpd=".$l['seq'];
			echo "','','statusbar=no,menubar=no,resizable=no,scrollbars=no,titlebar=no,toolbar=no,width=600,height=200')\">";
				echo "<img src='images/update.png' width='15' border='0'>";
			echo "</a>";
			echo "<a href='#'  onClick=\"javascript:window.open('piece_ins.php?acao=3&activity_id=".$activity_id."&piece_id=".$l['id'];
			echo "','','statusbar=no,menubar=no,resizable=no,scrollbars=no,titlebar=no,toolbar=no,width=600,height=200')\">";
				echo "<img src='images/delete.png' width='15' border='0'>";
			echo "</a>";
		}
	}
}

$SQLp = "SELECT DISTINCT p.*, pe.id as piece_element
		 FROM piece p
		 		LEFT JOIN piece_element pe ON pe.piece_id = p.id
		 WHERE p.activity_id = ".$activity_id." AND
		 		pe.id is not null
		ORDER BY p.seq";
$resp = pg_query($SQLp);
//echo $SQLp."<br>";
while($linhap = pg_fetch_array($resp)){
	$SQL = "SELECT id FROM layer_property WHERE piece_element_id = ".$linhap['piece_element']."";
	$res = pg_query($SQL);
//echo $SQL."<br>";
	if(pg_num_rows($res)==0){
		echo "<hr>";
		echo "<a href='activity.php?";
						echo "newpieceelement=true&";
				echo "pieceseq=".$linhap['seq']."&";
				echo "piece_id=".$linhap['id']."&";
				echo "piecename=".$linhap['name_varchar']."&";
				echo "piecedescription=".$linhap['description']."&";
				echo "piecetype_id=".$linhap['piecetype_id'];
if(isset($screen) && $screen!=""){echo "&screen=".$screen;}
if(isset($newpiece) && $newpiece==true){echo "&newpiece=true";}
if(isset($blockname_varchar) && $blockname_varchar!=""){echo "&blockname_varchar=".$blockname_varchar;}
if(isset($block_content) && $block_content!=""){echo "&block_content=".$block_content;}
if(isset($semantic_id) && $semantic_id!=""){echo "&semantic_id=".$semantic_id;}
if(isset($semanticname) && $semanticname!=""){echo "&semanticname=".$semanticname;}
if(isset($discipline) && $discipline!=""){echo "&discipline=".$discipline;}
if(isset($goal_id) && $goal_id!=""){echo "&goal_id=".$goal_id;}
if(isset($activity_id) && $activity_id!=""){echo "&activity_id=".$activity_id;}
if(isset($activitytype_id) && $activitytype_id!=""){echo "&activitytype_id=".$activitytype_id;}
		echo "'>";
			if(isset($piece_id) && $piece_id == $linhap['id']){ echo "<u>"; }
			echo $linhap['seq'].($linhap['name_varchar']!=""?" - ".$linhap['name_varchar']:"");
			if(isset($piece_id) && $piece_id == $linhap['id']){ echo "</u>"; }
		echo "</a>";
		echo "<a href='#' onClick=\"javascript:window.open('piece_ins.php?acao=4&activity_id=".$activity_id."&piece_id=".$linhap['id']."&";
		echo "piecetype_id=".$linhap['piecetype_id']."','','statusbar=no,menubar=no,resizable=no,scrollbars=no,titlebar=no,toolbar=no,width=600,height=200')\">";
			echo "<img src='images/delete.png' width='15' border='0'>";
		echo "</a>";
		echo "<br>";
	}//if(pg_num_rows($resp)==0){
}
?>