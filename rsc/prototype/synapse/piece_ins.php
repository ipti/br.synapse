<?php
session_start();
ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
include("includes/conecta.php");
ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

?>
<head>
<title><?php echo $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="synapse.css" rel="stylesheet" type="text/css">
<script language="javascript">
<!--
var form = "";
var submitted = false;
var error = false;
var error_message = "";

function check_form(form_name) {
  if (submitted == true) {
    alert("Este formulário já foi enviado. Por favor pressione OK e aguarde o processo ser completado.");
    return false;
  }
}

function filtra(cod) {
  	document.forms["piece_ins"].filtragem.value = cod;	
}

//-->
</script>

</head>
<body>
<?php 

if((isset($filtragem) && $filtragem==1) || (isset($filtragem) && $filtragem==2)){
	if(!isset($piecetype_id) || (isset($piecetype_id) && $piecetype_id=="")){
		$piecetype_id = 'null';
	}
	if($filtragem==1){
		if(isset($father_id) && $father_id!=""){
			$SQLi = "INSERT INTO piece(activity_id, name_varchar, description, seq, father_id, actor_id, piecetype_id) 
					VALUES(".$activity_id.", '".$name_varchar."', '".$description."', ".$seq.", ".$father.", ".$actor.", ".$piecetype_id.")";
		}else{
			$SQLi = "INSERT INTO piece(activity_id, name_varchar, description, seq, actor_id, piecetype_id) 
					VALUES(".$activity_id.", '".$name_varchar."', '".$description."', ".$seq.", ".$actor.", ".$piecetype_id.")";
		}
	}elseif($filtragem==2){
		$SQLi = "UPDATE piece 
				SET name_varchar='".$name_varchar."', 
					description='".$description."', 
					seq=".$seq.",
					piecetype_id=".$piecetype_id."
				WHERE id=".$piece_id."";
	}
	$resi = pg_query($SQLi);
	echo "<script> window.opener.reloadPage(); </script>";
//	echo $SQLi;
//	exit;
	echo "<script> window.close(); </script>";
}

if((isset($acao) && $acao==1) || (isset($acao) && $acao==2)){

	if(isset($piecetype_id) && $piecetype_id!=""){
		$SQLpt = "SELECT name 
				 FROM activitytype 
				 WHERE id = ".$piecetype_id."";
		$respt = pg_query($SQLpt);
		$lpt = pg_fetch_array($respt);
	}

	echo '<form name="piece_ins" action="piece_ins.php" method="post" onSubmit="return check_form(piece_ins);">';
	echo "<p>Nome (Opcional): <input type='text' size='20' name='name_varchar' value='".(isset($nameupd) && $nameupd!=""?$nameupd:"")."'></p>";
	echo "<p>Descrição (Opcional): <input type='text' size='20' name='description' value='".(isset($descriptionupd) && $descriptionupd!=""?$descriptionupd:"")."'></p>";
	echo "<p>Pai(Opcional): <select name='father'>";
	echo "<option></option>";
	$SQL = "SELECT * FROM piece WHERE activity_id = ".$activity_id."";
	$res = pg_query($SQL);
	while($l = pg_fetch_array($res)){
		echo "<option value=".$l['id'].">".$l['name_varchar']."</option>";
	}
	echo "</select></p>";
	echo "<p>Escolha um Tipo: <select name='piecetype_id'>";
	echo "<option value='".(isset($piecetype_id) && $piecetype_id!=""?$piecetype_id:"")."'>".(isset($piecetype_id) && $piecetype_id!=""?$lpt['name']:"")."</option>";
	$SQL = "SELECT * FROM activitytype ORDER BY name";
	$res = pg_query($SQL);
	while($linha = pg_fetch_array($res)){
		echo "<option value=".$linha['id'].">".$linha['name']."</option>";
	}
	echo "</select></p>";
	echo "<p>Seq (Obrigatório): <input type='text' size='1' name='seq' value='".(isset($sequpd) && $sequpd!=""?$sequpd:"")."'></p>";
	echo "<input type='hidden' name='activity_id' value='".$activity_id."'>";
	echo "<input type='hidden' name='piece_id' value='".$piece_id."'>";
	echo "<input type='hidden' name='filtragem'>";
	if($acao==1){
		echo '<p><input type="submit" value="Ins" onClick=filtra(1)></p>';
	}elseif($acao==2){
		echo '<p><input type="submit" value="Upd" onClick=filtra(2)></p>';
	}
	echo "</form>";
}elseif(isset($acao) && $acao==3){
	$SQL = "SELECT id FROM piece_element WHERE piece_id = ".$piece_id."";
	$res = pg_query($SQL);
	if(pg_num_rows($res)==0){
		$SQL = "DELETE FROM piece WHERE id = ".$piece_id."";
		$res = pg_query($SQL);
		echo "<script> window.opener.reloadPage(); </script>";
		echo "<script> window.close(); </script>";
	}else{
		echo "<h3><font color='red'>Há elementos na peça!</font></h3>";
	}
}elseif(isset($acao) && $acao==4){
	$SQL = "DELETE FROM piece_element WHERE piece_id = ".$piece_id."";
	$res = pg_query($SQL);
	$SQL = "DELETE FROM piece WHERE id = ".$piece_id."";
	$res = pg_query($SQL);
	echo "<script> window.opener.reloadPage(); </script>";
	echo "<script> window.close(); </script>";
}
?>
</body>
</html>