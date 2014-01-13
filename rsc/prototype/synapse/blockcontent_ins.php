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

//-->
</script>
<?php 

//_________________________________________________________________________________________ INSERT block
if(isset($acao) && $acao==10){//grava novo conteudo
	if(isset($blockFather) && $blockFather!=""){
		$SQLi = "INSERT INTO blockcontent(name_varchar, father_id) 
									  VALUES('".$newblock."',".$blockFather.")";
	}else{
		$SQLi = "INSERT INTO blockcontent(name_varchar) 
									  VALUES('".$newblock."')";
	}
	$resi = pg_query($SQLi);
	$blockins = 1;
}
//_________________________________________________________________________________________ //INSERT block

//_________________________________________________________________________________________ FORM block
if(isset($acao) && ($acao>=0 && $acao<=9)){//exibe formulario para insercao de novo conteudo
	echo '<form name="blockcontent_ins" action="block.php" method="post">';
	echo '<p><input type="text" size="8" name="newblock">';
	echo "<input type='hidden' name='blockFather' value='".$blockFather."'>";
	echo "<input type='hidden' name='blockcontentname' value='".$blockcontentname."'>";
	echo "<input type='hidden' name='acao' value='10'>";
	echo "<input type='hidden' name='blockins' value=0>";
	echo '<input type="submit" name="OK" value="OK" id="sub" width="4"></p>'; 	
	echo "</form>";
}
//_________________________________________________________________________________________ //FORM block	
?>