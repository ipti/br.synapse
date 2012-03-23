<?php

ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
include("includes/conecta.php");
ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

if(!(session_is_registered('person'))){
	echo "erro";
	header('Location: ' . "http://" . $_SERVER["SERVER_NAME"]."/synapse/index.php");	
}
?>
<script language="javascript">
<!--
var form = "";
var submitted = false;
var error = false;
var error_message = "";

function filtra(cod) {
  	document.forms["content_ins"].filtragem.value = cod;	
}
//-->
</script>
<?php 

//_________________________________________________________________________________________ INSERT CONTENT
if(isset($acao) && $acao==10){//grava novo conteudo
	if($disc==""){
		$type = 1;
		$disc = "null";
	}else{
		$type = 2;
	}
	
	if(isset($contentFather) && $contentFather!=""){
		$SQLi = "INSERT INTO activitycontent(name_varchar, discipline_id, father_id, type_id) 
									  VALUES('".$newgoal."',".$disc.",".$contentFather.", ".$type.")";
	}else{
		$SQLi = "INSERT INTO activitycontent(name_varchar, discipline_id, type_id) 
									  VALUES('".$newgoal."',".$disc.",".$type.")";	
	}
	$resi = pg_query($SQLi);

	if($disc==""){
		$SQLs = "SELECT id FROM activitycontent DESC";
		$ress = pg_query($SQLs);
		$linhas = pg_fetch_array($ress);
		$SQLih = "INSERT INTO activityhability (id, name, father_id) VALUES ('".$linhas['id'].", ".$newgol."', ".$contentFather.")";
		$resih = pg_query($SQLih);
	}
	$goalins = 1;
}
//_________________________________________________________________________________________ //INSERT CONTENT

//_________________________________________________________________________________________ FORM CONTENT
if(isset($acao) && ($acao>=1 && $acao<=9)){//exibe formulario para insercao de novo conteudo
	echo '<form name="content_ins" action="content.php" method="post">';
	echo "Nome: <input type='text' name='newgoal'>";
	echo "<input type='hidden' name='content_father' value='".$content_father."'>";
	echo "<input type='hidden' name='contentname' value='".$contentname."'>";
	echo "<input type='hidden' name='contentFather' value='".$contentFather."'>";
	echo "<input type='hidden' name='discname' value='".$discname."'>";

	if(isset($content2) && $content2!=""){
		echo "<input type='hidden' name='content2' value='".$content2."'>";
		echo "<input type='hidden' name='contentname2' value='".$contentname2."'>";
	}
	if(isset($content3) && $content3!=""){
		echo "<input type='hidden' name='content3' value='".$content3."'>";
		echo "<input type='hidden' name='contentname3' value='".$contentname3."'>";
	}
	if(isset($content4) && $content4!=""){
		echo "<input type='hidden' name='content4' value='".$content4."'>";
		echo "<input type='hidden' name='contentname4' value='".$contentname4."'>";
	}
	if(isset($content5) && $content5!=""){
		echo "<input type='hidden' name='content5' value='".$content5."'>";
		echo "<input type='hidden' name='contentname5' value='".$contentname5."'>";
	}
	if(isset($content6) && $content6!=""){
		echo "<input type='hidden' name='content6' value='".$content6."'>";
		echo "<input type='hidden' name='contentname6' value='".$contentname6."'>";
	}
	if(isset($content7) && $content7!=""){
		echo "<input type='hidden' name='content7' value='".$content7."'>";
		echo "<input type='hidden' name='contentname7' value='".$contentname7."'>";
	}
	if(isset($content8) && $content8!=""){
		echo "<input type='hidden' name='content8' value='".$content8."'>";
		echo "<input type='hidden' name='contentname8' value='".$contentname8."'>";
	}
	echo "<input type='hidden' name='disc' value='".$disc."'>";
	echo "<input type='hidden' name='acao' value='10'>";
	echo "<input type='hidden' name='goalins' value=0>";
	echo '<input name="imgGravar" value="true" id="sub" type="image" title="Gravar" src="images/gravar.gif" alt="Gravar" width="60" height="18" border="0">'; 	
	echo "</form>";
}
//_________________________________________________________________________________________ //FORM CONTENT	

?>