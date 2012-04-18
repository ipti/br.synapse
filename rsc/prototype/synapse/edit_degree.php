<?php
session_start();

ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
include("includes/conecta.php");
ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
include("includes/funcoes.php");
ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

if(!(session_is_registered('person'))){
	echo "erro";
	header('Location: ' . "http://" . $_SERVER["SERVER_NAME"]."/synapse/index.php");	
}

if(isset($idiom) && $idiom=="7"){
$h1="Início";
$h2="Bem Vindo:";
}

if(isset($idiom) && $idiom=="16"){
$h1="Home";
$h2="Welcome:";
}

if(isset($idiom) && $idiom=="17"){
$h1="Haus";
$h2="Willkommen:";
}
?>
<html>
<head>
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
	
	check_select("degreegrade_id", "", "Escolha um Grau");

	if (error == true) {
		alert(error_message);
		return false;
	}else{
		submitted = true;
		return true;
	}
}

function filtra(cod) {
  	document.forms["degreegrade"].filtragem.value = cod;	
}
//-->
</script>
</head>
<?php
if(isset($degreeblock_id)){
	$SQL = "SELECT db.id, db.name as blockname, ds.name as stagename 
			FROM degreeblock db 
					LEFT JOIN degreestage ds ON ds.id = db.degreestage_id
			WHERE db.id = ".$degreeblock_id."";
	$res= pg_query($SQL);
	$l = pg_fetch_array($res);
	$stagename = $l['stagename'];
	$blockname = $l['blockname'];
}
	
if(isset($filtragem) && $filtragem==1){
	$SQL = "UPDATE goal SET degreegrade_id = ".$degreegrade_id." WHERE id = ".$goal_id."";
	$res = pg_query($SQL);
	echo "<script>window.opener.reloadPage(); </script >";
	echo "<script>window.close()</script >";
}
?>
<body>
<form name="degreegrade" action="edit_degree.php" method="POST" onSubmit="return check_form(degreegrade);">
<table>
<tr><td>Nível: </td><td>
	<select name='degreeblock_id' onChange="document.degreegrade.submit()"><?
	$SQLds = "SELECT degreestage.* FROM degreestage ORDER BY grade";
	$resds = pg_query($SQLds);
	while($lds = pg_fetch_array($resds)){
		$SQLdb = "SELECT degreeblock.* 
				  FROM degreeblock WHERE degreestage_id = ".$lds['id']." ORDER BY grade";
		$resdb = pg_query($SQLdb);
		echo "<option value='";
		if(isset($editdegreeblock) && !isset($degreeblock_id)){
			echo $editdegreeblock;
		}elseif(isset($degreeblock_id)){
			echo $degreeblock_id;
		}
		echo "'>";
		if(isset($editblockname) && !isset($degreeblock_id)){
			echo $editstagename." Estágio - ".$editblockname." Bloco";
		}elseif(isset($degreeblock_id)){
			echo $stagename." Estágio - ".$blockname." Bloco";
		}
		echo "</option>";

		while($linhadb = pg_fetch_array($resdb)){
			echo "<option value='".$linhadb['id']."'>".$lds['name']." Estágio - ".$linhadb['name']." Bloco</option>";
		}
	}?>
	</select>
	</td><?php
	echo "<td>Grau: </td><td><select name='degreegrade_id'>";
	if((isset($editdegreeblock) && $editdegreeblock!="") && !isset($degreeblock_id)){
		$SQLdg = "SELECT degreegrade.* FROM degreegrade WHERE degreeblock_id = ".$editdegreeblock." ORDER BY grade";
	}elseif(isset($degreeblock_id) && $degreeblock_id!=""){
		$SQLdg = "SELECT degreegrade.* FROM degreegrade WHERE degreeblock_id = ".$degreeblock_id." ORDER BY grade";
	}
	$resdg = pg_query($SQLdg);
	echo "<option value='".(isset($editdegreegrade)?$editdegreegrade:"")."'>".(isset($editgradename)?$editgradename." Grau":"")."</option>";
	while($ldg = pg_fetch_array($resdg)){
		echo "<option value='".$ldg['id']."'>".$ldg['name']."º Grau</option>";
	}
	echo "</select></td>";
	//echo $SQLdg;
/*
<input type="hidden" name="editdegreeblock" value="<? echo $editdegreeblock; ? >">
<input type="hidden" name="editblockname" value="<? echo $editblockname; ? >">
<input type="hidden" name="editstagename" value="<? echo $editstagename; ? >">
<input type="hidden" name="editdegreegrade" value="<? echo $editdegreegrade; ? >">
<input type="hidden" name="editgradename" value="<? echo $editgradename; ?>">
*/
?>
<input type="hidden" name="goal_id" value="<? echo $goal_id; ?>">
<input type="hidden" name="filtragem" value="">
<td><input name="imgGravar" value="true" id="sub" type="image" title="Atualizar" src="images/gravar.gif" alt="Atualizar" width="60" height="18" border="0" onClick="filtra(1)"></td>	
</form>

</body>
</html>