<?php
session_start();
$SQLet = "SELECT * FROM layer_text WHERE layer_property_id = ".$linhae['layer_property_id']."";
$reset = pg_query($SQLet);
if(pg_num_rows($reset)>0){
	$linhaet = pg_fetch_array($reset);
	if (isset($linhaet['color']) && $linhaet['color']==-16777208){ 
		$fontcolor="#000000"; 
	}elseif(isset($linhaet['color']) && $linhaet['color']==32768){
		$fontcolor="#00FF00"; 
	}
	if (isset($linhaet['weight']) && $linhaet['weight']==1){
		$fontweight="700";
	}elseif(isset($linhaet['weight']) && $linhaet['weight']==0){
		$fontweight="400";
	}
}else{
	$fontcolor = "#000000";
	$fontweight="400";
}
$fontfamily = "arial, helvetica, serif";
$fontsize = "14px";				
$j=$i;
echo '<STYLE type="text/css">
		t'.$j.'{
			font-family: '.$fontfamily.';
			font-size: '.$fontsize.';
			color: '.$fontcolor.';
			font-weight: '.$fontweight.';
			line-height: 1.5em;
			text-align:justify;
		}
	</STYLE>';
$SQL = "SELECT name";
if($linhae['elementtype_id']!=13){
	$SQL .= ", idiom_id ";
}
$SQL .= " FROM ".$radio_name." where id = ".$linhae['element_id']."";
$res = pg_query($SQL);
$linha = pg_fetch_array($res);

echo "<t".$j.">";
if(isset($piece_element) && ($piece_element==$linhae['piece_element_id'])){ // ?>
	<div id="<?php echo $i; ?>" class="div<?php echo $i; ?>" style="width: <?php echo $divwidth; ?>; height: <?php echo $divheight; ?>; left: <?php echo $divleft ?>; top: <?php echo $divtop; ?>;"><?php 
		echo "<table><tr>";
		echo "<td><textarea name='data' cols='".($divwidth/8.3)."' rows='".($divheight/15)."'>";
}else{ ?>
	<div id="<?php echo $i; ?>" class="div<?php echo $i; ?>" onmousemove="LayerEvents(event, <?php echo $i; ?>)" onmousedown="LayerEvents(event, <?php echo $i; ?>)" onmouseup="LayerEvents(event, <?php echo $i; ?>)" onMouseOver="MM_showHideLayers('cursor<?php echo $i; ?>','','show');MM_showHideLayers('delete<?php echo $i; ?>','','show');MM_showHideLayers('resize<?php echo $i; ?>','','show')" onMouseOut="MM_showHideLayers('cursor<?php echo $i; ?>','','hide');MM_showHideLayers('delete<?php echo $i; ?>','','hide');MM_showHideLayers('resize<?php echo $i; ?>','','hide')" style="width: <?php echo $divwidth; ?>; height: <?php echo $divheight; ?>; left: <?php echo $divleft ?>; top: <?php echo $divtop; ?>;">
		<div style="position:absolute; left:0px; top:0px; width:16px; height:16px; background-image: url(images/cursor.gif); visibility:hidden;" id="cursor<?php echo $i; ?>"></div><?php
		if(isset($linhae['layertype_id']) && $linhae['layertype_id']==5){ ?>
			<input type="radio" name="<?php echo $linhae['piece_id'].$linhae['grouping']; ?>"> <?php 
		}elseif(isset($linhae['layertype_id']) && $linhae['layertype_id']==6){ ?>
			<input type="checkbox" name="<?php echo $linhae['piece_element_id']; ?>"> <?php 
		}
		echo "<a href='activity.php?acao=editar";
if(isset($blockname_varchar) && $blockname_varchar!=""){echo "&blockname_varchar=".$blockname_varchar;}
if(isset($block_content) && $block_content!=""){echo "&block_content=".$block_content;}
if(isset($discipline) && $discipline!=""){echo "&discipline=".$discipline;}
if(isset($semantic_id) && $semantic_id!=""){echo "&semantic_id=".$semantic_id;}
if(isset($semanticname) && $semanticname!=""){echo "&semanticname=".$semanticname;}
if(isset($screen) && $screen!=""){echo "&screen=".$screen;}
if(isset($goal_id) && $goal_id!=""){echo "&goal_id=".$goal_id;}
if(isset($activity_id) && $activity_id!=""){echo "&activity_id=".$activity_id;}
if(isset($activitytype_id) && $activitytype_id!=""){echo "&activitytype_id=".$activitytype_id;}
		echo "&piece_id=".$linhae['piece_id'];
		echo "&piecename=".$linhae['piecename'];
		echo "&piece_element=".$linhae['piece_element_id'];
		echo "&element_id=".$linhae['element_id'];
		echo "&elementtype_id=".$linhae['elementtype_id'];
		echo "&typename=".$linhae['typename'];
		echo "&layertype_id=".$linhae['layertype_id'];
		echo "&layer_property_id=".$linhae['layer_property_id'];
		echo "' style='text-decoration:none; color:black;'>";
}
if($linhae['layertype_id']==8 || $linhae['layertype_id']==9){
	echo "<input type='".$linhae['layername']."' value='";
}
if(($linha['idiom_id']==$idiom) || $linhae['elementtype_id']==13){ 
	echo $linhaet['name'];//." - ".$linhae['layertype_id']
}else{ 		
	$SQLi = "SELECT w.id, w.name FROM ".$radio_name." w LEFT JOIN ".$radio_name."_".$radio_name." ww on (ww.".$radio_name."1_id=w.id) or (ww.".$radio_name."2_id=w.id)
			WHERE (((ww.".$radio_name."1_id=".$linhae['element_id'].") or (ww.".$radio_name."2_id=".$linhae['element_id'].")) and w.idiom_id=".$idiom.")";
	$resi = pg_query($SQLi);
	$linhai = pg_fetch_array($resi);
	if($linhai['name']!=""){
		echo $linhai['name'];
	}else{
		echo $linhaet['name'];
	}
}
if($linhae['layertype_id']==8 || $linhae['layertype_id']==9){
	echo "'>";
}
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-TXT-UPD
if(isset($piece_element) && ($piece_element==$linhae['piece_element_id'])){
	echo "</textarea></td>";
	ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
	include("activity_form.php");
	ini_set("allow_url_fopen",0); ini_set("allow_url_include",0); ?>
	<input type='hidden' name='filtragem' value='0'>
	<td><input type='submit' value='Upd' onClick='filtra4(4)'></td></tr></table>
	<?php
	echo "</div>";
}else{
	echo "</a>";
	if(isset($linhae['layertype_id']) && $linhae['layertype_id']==4){ ?>
		<input type="text" name="<?php echo $linhae['piece_element_id']; ?>"> <?php 
	}elseif(isset($linhae['layertype_id']) && $linhae['layertype_id']==7){ ?>
		<textarea name="<?php echo $linhae['piece_element_id']; ?>" style="width:<?php echo $divwidth; ?>; height:<?php echo $divheight-22; ?>;"></textarea> <?php 
	} ?>
	
	<div style="position:absolute; left: <?php echo $divleft1; ?>; top: 0; width:16px; height:16px; visibility: hidden;" id="delete<?php echo $i; ?>">
		<a href='activity.php?acao=excluir&screen=<?php echo $screen; ?>&totalscreen=<?php echo $totalscreen; ?>&activity_id=<?php echo $activity_id; ?>&piece_element=<?php echo $linhae['piece_element_id']; ?>&piece_id=<?php echo $linhae['piece_id']; ?>&semanticname=<?php echo $semanticname; ?>&goaldescription=<?php echo $goaldescription; ?>&pieceseq=<?php echo $pieceseq; ?>&piecename=<?php echo $piecename; ?>&activitytype_id=<?php echo $activitytype_id; ?>'>
			<img src="images/delete.png" border="0">
		</a>
	</div> 
	<div style="position:absolute; left: <?php echo $divleft1; ?>; top: <?php echo $divtop1; ?>; width:16px; height:16px; background-image: url(images/cursor.gif); visibility: hidden;" id="resize<?php echo $i; ?>"></div><?php
	echo "</div>";
}
echo "</t".$j.">";
?>