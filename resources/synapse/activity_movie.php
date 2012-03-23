<?php
session_start();
$SQLm = "SELECT id, extension FROM movie WHERE id = ".$linhae['element_id']." ";
$resm = pg_query($SQLm);
$linham = pg_fetch_array($resm);
$movie = "activity/movie/".$linham['id'].".".$linham['extension']; 
echo '<div id="'.$i.'" class="div'.$i.'" onmousemove="LayerEvents(event, '.$i.')" onmousedown="LayerEvents(event, '.$i.')" onmouseup="LayerEvents(event,'.$i.')" style="width: '.($divwidth+16).'; height: '.($divheight+16).'; left: '.$divleft.'; top: '.$divtop.';">'; ?>
	<div style="position:absolute; left:0px; top:0px; width:16px; height:16px; background-image: url(images/cursor.gif); visibility: true;" id="cursor<?php echo $i; ?>"></div>
	<div style="position:absolute; left:16px; top:16px; width:<?php echo $divwidth; ?>px; height:<?php echo $divheight; ?>px;">
		<object type="application/x-shockwave-flash"
			data="<?php echo $movie; ?>"
			width="<?php echo $divwidth; ?>" height="<?php echo $divheight; ?>" id="VideoPlayback">
			<param name="movie" value="<?php echo $movie; ?>" />
			<param name="allowScriptAcess" value="sameDomain" />
			<param name="quality" value="best" />
			<param name="bgcolor" value="#FFFFFF" />
			<param name="scale" value="noScale" />
			<param name="salign" value="TL" />
			<param name="FlashVars" value="playerMode=embedded" />
		</object>
	</div>
	<div style="position:absolute; left: <?php echo $divwidth+16; ?>; top: <?php echo $divheight+16; ?>; width:16px; height:16px; visibility: true;" id="resize<?php echo $i; ?>">
<?php	echo "<a href='activity.php?acao=editar";
if(isset($blockname_varchar) && $blockname_varchar!=""){echo "&blockname_varchar=".$blockname_varchar;}
if(isset($block_content) && $block_content!=""){echo "&block_content=".$block_content;}
if(isset($discipline) && $discipline!=""){echo "&discipline=".$discipline;}
if(isset($semantic_id) && $semantic_id!=""){echo "&semantic_id=".$semantic_id;}
if(isset($semanticname) && $semanticname!=""){echo "&semanticname=".$semanticname;}
if(isset($screen) && $screen!=""){echo "&screen=".$screen;}
if(isset($totalscreen) && $totalscreen!=""){echo "&totalscreen=".$totalscreen;}
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
		echo "' style='text-decoration:none;'>"; ?>
		<img src="images/select.png" border="0"></a>
	</div>
	<div style="position:absolute; left: <?php echo $divwidth+16; ?>; top: 0; width:16px; height:16px; visibility: true;" id="delete<?php echo $i; ?>">
	<a href='activity.php?acao=excluir&screen=<?php echo $screen; ?>&totalscreen=<?php echo $totalscreen; ?>&activity_id=<?php echo $activity_id; ?>&piece_element=<?php echo $linhae['piece_element_id']; ?>&piece_id=<?php echo $linhae['piece_id']; ?>&semanticname=<?php echo $semanticname; ?>&goal_id=<?php echo $goal_id; ?>&peseq=<?php echo $peseq; ?>&piecename=<?php echo $piecename; ?>&activitytype_id=<?php echo $activitytype_id; ?>'>
		<img src="images/delete.png" border="0">
	</a>
	</div>
</div>