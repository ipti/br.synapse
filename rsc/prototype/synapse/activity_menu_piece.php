<?php
session_start();
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-MENU/PIECE
echo "<hr>";

echo "<table width='140'><tr>";
	echo "<td class='cinzatit' width='110' align='center'>".$screenpiece."</td>";
	echo "<td class='cinzatit' width='30' align='center'>";
		if(!isset($newscreen) && !isset($newpiece)){
			echo "<a href='activity.php?";
			echo "newpiece=true";
if(isset($screen) && $screen!=""){echo "&screen=".$screen;}
if(isset($blockname_varchar) && $blockname_varchar!=""){echo "&blockname_varchar=".$blockname_varchar;}
if(isset($block_content) && $block_content!=""){echo "&block_content=".$block_content;}
if(isset($semantic_id) && $semantic_id!=""){echo "&semantic_id=".$semantic_id;}
if(isset($semanticname) && $semanticname!=""){echo "&semanticname=".$semanticname;}
if(isset($discipline) && $discipline!=""){echo "&discipline=".$discipline;}
if(isset($goal_id) && $goal_id!=""){echo "&goal_id=".$goal_id;}
if(isset($activity_id) && $activity_id!=""){echo "&activity_id=".$activity_id;}
if(isset($activitytype_id) && $activitytype_id!=""){echo "&activitytype_id=".$activitytype_id;}
			echo "' style='text-decoration:none;'>";
				echo "<img src='images/icon-plus.png' width='20' height='20' border='0'>";
			echo "</a>";
		}
	echo "</td>";
echo "</tr></table>";

$SQLp = "SELECT DISTINCT p.* 
		 FROM piece p
		 		LEFT JOIN layer_property lp ON lp.piece_id = p.id
		 WHERE p.activity_id = ".$activity_id." AND
		 		lp.screen = ".$screen." AND
		 	   p.father_id is null
		ORDER BY p.seq";
$resp = pg_query($SQLp);
echo "<table width='140'>";
if(pg_num_rows($resp)>0){
	while($linhap = pg_fetch_array($resp)){
		echo "<tr>";
		if((isset($piece_id) && $piece_id==$linhap['id']) && (!isset($element_id) || (isset($element_id) && $element_id==""))){
			echo "<td class='cinzaahover'>";
				echo "<h13>";
				echo $linhap['seq'].($linhap['name_varchar']!=""?" - ".$linhap['name_varchar']:"ª Questão");
		}elseif((isset($piece_id) && $piece_id==$linhap['id']) && (isset($element_id) && $element_id!="")){
				echo "<td class='cinza'>";
				echo "<h13>";
				echo "<a href='activity.php?";
				echo "newpieceelement=true&";
				echo "pieceseq=".$linhap['seq']."&";
				echo "piece_id=".$linhap['id']."&";
				echo "piecename=".$linhap['name_varchar']."&";
				echo "piecedescription=".$linhap['description']."&";
				echo "piecetype_id=".$linhap['piecetype_id'];
if(isset($screen) && $screen!=""){echo "&screen=".$screen;}
if(isset($blockname_varchar) && $blockname_varchar!=""){echo "&blockname_varchar=".$blockname_varchar;}
if(isset($block_content) && $block_content!=""){echo "&block_content=".$block_content;}
if(isset($semantic_id) && $semantic_id!=""){echo "&semantic_id=".$semantic_id;}
if(isset($semanticname) && $semanticname!=""){echo "&semanticname=".$semanticname;}
if(isset($discipline) && $discipline!=""){echo "&discipline=".$discipline;}
if(isset($goal_id) && $goal_id!=""){echo "&goal_id=".$goal_id;}
if(isset($activity_id) && $activity_id!=""){echo "&activity_id=".$activity_id;}
if(isset($activitytype_id) && $activitytype_id!=""){echo "&activitytype_id=".$activitytype_id;}				
				echo "'>";
				echo $linhap['seq'].($linhap['name_varchar']!=""?" - ".$linhap['name_varchar']:"ª Questão");
				echo "</a>";
		}else{
				echo "<td class='cinza'>";
				echo "<h13>";
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
if(isset($activitytype_id) && $activitytype_id!=""){echo "&activitytype_id=".$activitytype_id;}				echo "'>";
				echo $linhap['seq'].($linhap['name_varchar']!=""?" - ".$linhap['name_varchar']:"ª Questão");
				echo "</a>";
		}
		echo "</h13>";
		echo "</td>";
		echo "<td class='cinzadel'>";
			echo "<a href='#'  onClick=\"javascript:window.open('piece_ins.php?acao=2&activity_id=".$activity_id."&piece_id=".$linhap['id']."&";
			echo "piecetype_id=".$linhap['piecetype_id']."&nameupd=".$linhap['name_varchar']."&descriptionupd=".$linhap['description']."&sequpd=".$linhap['seq'];
			echo "','pieceins','statusbar=no,menubar=no,resizable=no,scrollbars=no,titlebar=no,toolbar=no,top=92, left=140, width=600, height=200')\">";
				echo "<img src='images/update.png' width='15' border='0'>";
			echo "</a>";
		echo "</td>";
		echo "<td class='cinzaupd'>";
			echo "<a href='#'  onClick=\"javascript:window.open('piece_ins.php?acao=3&activity_id=".$activity_id."&piece_id=".$linhap['id']."&";
			echo "piecetype_id=".$linhap['piecetype_id']."','pieceins','statusbar=no,menubar=no,resizable=no,scrollbars=no,titlebar=no,toolbar=no,top=92, left=140, width=600, height=200')\">";
				echo "<img src='images/delete.png' width='15' border='0'>";
			echo "</a>";
		echo "</td>";
		echo "</tr>";
	}
	if((isset($newpiece) && $newpiece==true) || (isset($newscreen) && $newscreen==true)){
		echo "<td class='cinzaahover'>";
				echo "<h13>".($totalpiece+1)."ª Questão</h13>";
		echo "</td>";
		echo "<td class='cinzadel'>";
		echo "</td>";
		echo "<td class='cinzaupd'>";
		echo "</td></tr>";
	}

}else{
	echo "<tr><td class='cinzaahover'>";
		echo "<h13>1ª Questão</h13>";
	echo "</td>";
	echo "<td class='cinzadel'></td>";
	echo "<td class='cinzaupd'></td></tr>";
}
echo "</tr>";
echo "</table>";
?>