<?php
session_start();
ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
include("includes/conecta.php");
ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

if(isset($semantic_id) && $semantic_id!=""){
	$SQL = "SELECT name_varchar FROM semantic WHERE id = ".$semantic_id."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$semantic_idname = $linha['name_varchar'];
}
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

function check_select(field_name, field_default, message) {
  if (form.elements[field_name] && (form.elements[field_name].type != "hidden")) {
    var field_value = form.elements[field_name].value;

    if (field_value == field_default) {
      error_message = error_message + "* " + message + "\n";
      error = true;
    }
  }
}

function check_form(form_name) {
	if (submitted == true) {
		alert("Este formulário já foi enviado. Por favor pressione OK e aguarde o processo ser completado.");
		return false;
	}  
	error = false;
	form = form_name;
	error_message = "Erros ocorreram durante o envio de seu formulário.\n\nPor favor, faça as seguintes correções:\n\n";

	check_select("activitytype_id", "", "Selecione o Tipo da Atividade");
	
	if (error == true) {
		alert(error_message);
		return false;
	}else{
		submitted = true;
		return true;
	}
}
function filtra(cod) {
  	document.forms["activity_ins"].filtragem.value = cod;	
}
//-->
</script>
</head>
<body>
<?php 

if(isset($filtragem) && ($filtragem==1 || $filtragem==2)){

	if($filtragem==1){
		
		$SQL = "INSERT INTO activity (";
		if(isset($goal_id) && $goal_id!=""){
			$SQL .= "goal_id, ";
		}
		if(isset($father_id) && $father_id!=""){
			$SQL .= "father_id, ";
		}
		if(isset($semantic_id) && $semantic_id!=""){
			$SQL .= "semantic_id, ";
		}
		$SQL .= "name_varchar, description, activitytype_id, actor_id) VALUES (";
		if(isset($goal_id) && $goal_id!=""){
			$SQL .= $goal_id.", ";
		}
		if(isset($father_id) && $father_id!=""){
			$SQL .= $father_id.", ";
		}
		if(isset($semantic_id) && $semantic_id!=""){
			$SQL .= $semantic_id.", ";
		}
		$SQL .= "'".$name_varchar."', '".$description."', ".$activitytype_id.", ".$actor.")";

		$res = pg_query($SQL);
		$SQL = "SELECT id FROM activity ORDER BY id DESC";
		$res = pg_query($SQL);
		$l = pg_fetch_array($res);
		$SQL = "INSERT INTO activity_owner (activity_id, actor_id) VALUES (".$l['id'].", ".$actor.")";
		$res = pg_query($SQL);
	}
	
	if($filtragem==2){
		$SQL = "UPDATE block_activity SET seq=".$seq." WHERE id = ".$blockactivity_id."";
		$res = pg_query($SQL);
		$SQL = "UPDATE activity 
				SET name_varchar='".$name_varchar."', 
					description='".$description."', 
					activitytype_id=".$activitytype_id."";
		if(isset($semantic_id) && $semantic_id!=""){
			$SQL .= ", semantic_id=".$semantic_id."";
		}
		$SQL .= " WHERE id = ".$activity_id."";
	}
	echo "<script> window.opener.reloadPage(); </script>";
	echo "<script> window.close(); </script>";
}

if(isset($acao) && $acao==1){
	echo '<form name="activity_ins" action="activity_ins.php" method="post" onSubmit="return check_form(activity_ins);">';
	echo "<p>Nome: <input type='text' name='name_varchar' size='30' value='".(isset($editar) && $editar ==true?$activityname:"")."'></p>";
	echo "<p>Desc: <input type='text' name='description' size='60' value='".(isset($editar) && $editar ==true?$activitydescription:"")."'></p>";
	echo "<p>Tema: <select name='semantic_id' onChange=document.activity_ins.submit()>";
	$SQLdb = "SELECT semantic.* FROM semantic ORDER BY name_varchar";
	$resdb = pg_query($SQLdb);
	echo "<option value='".(isset($semantic_id)?$semantic_id:"")."'>".(isset($semantic_idname)?$semantic_idname:"")."</option>";
	echo "<option value=''></option>";
	while($linhadb = pg_fetch_array($resdb)){
		echo "<option value='".$linhadb['id']."'>".$linhadb['name_varchar']."</option>";
	}
	echo "</select></p>";

	if(isset($semantic_id) && $semantic_id!=""){
		echo "<p>Pai: <select name='father_id'>";
		$SQLdb = "SELECT activity.id, goal.name_varchar
				  FROM activity 
						LEFT JOIN goal ON goal.id = activity.goal_id
				  WHERE activity.semantic_id = ".$semantic_id." AND
				  		goal.degreeblock_id = ".$degreeblock."";
		$resdb = pg_query($SQLdb);
		echo "<option value=''></option>";
		while($linhadb = pg_fetch_array($resdb)){
			echo "<option value='".$linhadb['id']."'>".$linhadb['id']." - ".$linhadb['name_varchar']."</option>";
		}
		echo "</select></p>";
	}

	echo "<p>Tipo*: <select name='activitytype_id'>";
	echo "<option value='".(isset($editar) && $editar==true?$activitytype_id:"")."'>".(isset($editar) && $editar==true?$typename:"")."</option>";
	$SQL = "SELECT * FROM activitytype ORDER BY name";
	$res = pg_query($SQL);
	while($linha = pg_fetch_array($res)){
		echo "<option value=".$linha['id'].">".$linha['name']."</option>";
	}
	echo "</select></p>";

	if(isset($blockactivity_id) && $blockactivity_id!=""){
		echo "<input type='hidden' name='blockactivity_id' value='".$blockactivity_id."'>";
		echo "<p>Seq: <input type='text' name='seq' value='".$seq."' size='1'></p>";
	}
	
	echo "<input type='hidden' name='goal_id' value='".$goal_id."'>";
	echo "<input type='hidden' value='0' name='filtragem'>";
	echo "<input type='hidden' value='1' name='acao'>";
	
	if(isset($editar) && $editar==true){
		echo "<input type='hidden' value='".$activity_id."' name='activity_id'>";
		echo "<p><input type='submit' value='Upd' onClick=filtra(2)></p>";
	}else{
		echo '<p><input type="submit" value="Ins" onClick=filtra(1)></p>';
	}
	echo "</form>";
}
?>
</body>
</html>