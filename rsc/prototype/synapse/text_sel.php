<?php
session_start();

ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
include("includes/conecta.php");
ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

//________________________________________________________________________________________________________________________________VAR

//------------------------------------------------------------------------------------------------------------------------------//VAR
if(isset($delete) && $delete==true){
	$SQL = "SELECT a.name, a.goal_id
			FROM piece_element pe
					LEFT JOIN piece p ON p.id = pe.piece_id
					LEFT JOIN activity a ON a.id = p.activity_id
			WHERE element_id = ".$element_id." AND
					elementtype_id = ".$elementtype_id."";
	$res = pg_query($SQL);
	if(pg_num_rows($res)==0){
		$SQL = "DELETE FROM ".$radio_name." WHERE id = ".$element_id."";
		$res = pg_query($SQL);
		echo "delete";
	}else{
		echo "<h3><font color='red'>Esse ".$radio_name." está sendo utilizado nas seguintes atividades: </font></h3>";
		while($l = pg_fetch_array($res)){
			$SQL1 = "SELECT g.description FROM goal g WHERE g.id = ".$l['goal_id']."";
			$res1 = pg_query($SQL1);
			$l1 = pg_fetch_array($res1);
			echo "<p>".$l1['description']." ".$l['name']."</p>";
		}
	}
}

if(isset($pieceelement_ins) && $pieceelement_ins==true){
	ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
	include("element.php");
	ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
//	echo "<script> window.opener.reloadPage(); </script >";
	exit;
	echo "<script>window.close()</script >";
}

$SQL = "SELECT id, name FROM ".$radio_name." WHERE name LIKE '%".$text."%'";
$res = pg_query($SQL);
if(pg_num_rows($res)>0){

	$SQLet = "SELECT id FROM elementtype WHERE name = '".$radio_name."'";
	$reset = pg_query($SQLet);
	$let = pg_fetch_array($reset);
	$elementtype_id = $let['id'];

	echo "<h2>".$radio_name." associados ao texto digitado: <font color='red'>".$text."</font></h2>";
	echo "<table width='900'>";
	while($l = pg_fetch_array($res)){
		echo "<tr><td><a href='text_sel.php?";
											echo "activity_id=".$activity_id;
											echo "&activitytype_id=".$activitytype_id;
											echo "&screen=".$screen;
											echo "&radio_name=".$radio_name;
											if(isset($piece_id) && $piece_id!=""){
												echo "&piece_id=".$piece_id;
											}
											echo "&element_id=".$l['id'];
											echo "&elementtype_id=".$elementtype_id;
											echo "&event_id=".$event_id;
											echo "&peseq=".$peseq;
											echo "&lpseq=".$lpseq;
											echo "&grouping=".$grouping;
											echo "&layertype_id=".$layertype_id;
											if(isset($newscreen) && $newscreen!=""){
												echo "&newscreen=".$newscreen;
											}
											if(isset($totalscreen) && $totalscreen!=""){
												echo "&totalscreen=".$totalscreen;
											}
											if(isset($acao) && $acao!=""){
												echo "&acao=".$acao;
											}
											if(isset($text) && $text!=""){
												echo "&text=".$text;
											}
											echo "&pieceelement_ins=true";
											echo "&DimX=".(strlen($l['name'])*3)."";
											echo "&DimY=".(strlen($l['name'])/3)."";
											echo "'>".$l['name']."</a>";

		echo "<a href='text_sel.php?delete=true&activity_id=".$activity_id;
											echo "&activitytype_id=".$activitytype_id;
											echo "&screen=".$screen;
											echo "&radio_name=".$radio_name;
											if(isset($piece_id) && $piece_id!=""){
												echo "&piece_id=".$piece_id;
											}
											echo "&element_id=".$l['id'];
											echo "&elementtype_id=".$elementtype_id;
											echo "&event_id=".$event_id;
											echo "&peseq=".$peseq;
											echo "&lpseq=".$lpseq;
											echo "&grouping=".$grouping;
											echo "&layertype_id=".$layertype_id;
											if(isset($newscreen) && $newscreen!=""){
												echo "&newscreen=".$newscreen;
											}
											if(isset($totalscreen) && $totalscreen!=""){
												echo "&totalscreen=".$totalscreen;
											}
											if(isset($acao) && $acao!=""){
												echo "&acao=".$acao;
											}
											if(isset($text) && $text!=""){
												echo "&text=".$text;
											}
		echo "'> - Del</a>";
		echo "</td></tr>";
	}
	echo "</table>";
}else{
	echo "<h3><font color='red'>Não há ".$radio_name." com essa busca!</font></h3>";
}
?>
<form name="text" action="element.php">
<textarea rows="7" cols="80" name="textins"><?php echo $text; ?></textarea>
Rw: <input type="text" name="rows" size="1">
	<input type='hidden' name='activity_id' value='<?php echo $activity_id; ?>'> 
	<input type='hidden' name='activitytype_id' value='<?php echo $activitytype_id; ?>'> 
	<input type="hidden" name="screen" value="<?php echo $screen; ?>">
	<input type="hidden" name="radio_name" value="<?php echo $radio_name; ?>">
	<?php if(isset($piece_id) && $piece_id!=""){ ?>
		<input type="hidden" name="piece_id" value="<?php echo $piece_id; ?>">
	<?php } ?>
	<?php if(isset($piece_element) && $piece_element!=""){ ?>
		<input type='hidden' name='piece_element' value='<?php echo $piece_element; ?>'>
		<input type='hidden' name='element_id' value='<?php echo $element_id; ?>'>
		<input type='hidden' name='elementtype_id' value='<?php echo $elementtype_id; ?>'>
		<input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
		<input type="hidden" name="layertype_id" value="<?php echo $layertype_id; ?>">
		<input type="hidden" name="grouping" value="<?php echo $grouping; ?>">
		<input type="hidden" name="lpseq" value="<?php echo $lpseq; ?>">
		<input type="hidden" name="peseq" value="<?php echo $peseq; ?>">
	<?php } ?>
	<?php if(isset($newscreen) && $newscreen!=""){ ?>
		<input type="hidden" name="newscreen" value="<?php echo $newscreen; ?>">
	<?php } ?>
	<?php if(isset($totalscreen) && $totalscreen!=""){ ?>
		<input type="hidden" name="totalscreen" value="<?php echo $totalscreen; ?>">
	<?php } ?>
	<?php if(isset($acao) && $acao!=""){ ?>
		<input type="hidden" name="acao" value="<?php echo $acao; ?>">
	<?php } ?>
	<input type="hidden" name="pieceelement_ins" value="true">
	<input type="hidden" name="word_id" value="<?php echo $word_id; ?>">
	<input type="hidden" name="filtragem" value="1">
	<input type="submit" value="Inserir" style="border: 1pt solid #222222; background-color:#444444; color: #EEEEEE; width: 60px; height:20px;">
</form>