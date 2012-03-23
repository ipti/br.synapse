<?php
    session_start();

       ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
       include("includes/conecta.php");
       ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

if(!(session_is_registered('person'))){
	echo "erro";
	header('Location: ' . "http://" . $_SERVER["SERVER_NAME"]."/synapse/index.php");	
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

function check_form(form_name) {
  if (submitted == true) {
    alert("Este formulário já foi enviado. Por favor pressione OK e aguarde o processo ser completado.");
    return false;
  }
}
function filtra(cod) {
  document.forms["paragraphform"].filtragem.value = cod;
}
//-->
</script>

</head>
<body>
<?php
if(isset($insert) && $insert==true){
?>
	<form name="paragraph_ins" action="paragraph.php" method="post" onSubmit="return check_form(paragraph_ins);">
	
	<?php
	if(isset ($acao) && $acao==1){
	
		//$stmt="EXECUTE PROCEDURE WORD_INS('".$name."', ".$word_father.", ".$word_root.", ".$word_category.", ".$word_morphology.", ".$description.", ".$word_idiom.")"; 
		//$query = pg_prepare($stmt);
		//$res=pg_execute($query);
		if(isset($semantic_id) && $semantic_id!=""){
		
		}else{
			$semantic_id = 'null';
		}
		$SQL = "INSERT INTO paragraph (data, idiom_id, semantic_id) VALUES('".$data."', ".$idiom_id.", ".$semantic_id.");";
		$res = pg_query($SQL);
		
		if(isset($piece) && $piece!=""){
			$SQL = "SELECT id FROM paragraph ORDER BY id DESC";
			$res = pg_query($SQL);
			$l = pg_fetch_array($res);
			
			$SQL = "INSERT INTO piece_element (piece, element_id, element_type) VALUES(".$piece.", ".$$l['id'].", 8);";
			$res = pg_query($SQL);
			
			$SQL = "SELECT id FROM piece_element ORDER BY id DESC";
			$res = pg_query($SQL);
			$pe = pg_fetch_array($res);
			
			$SQL = "INSERT INTO pieceprinted (pieceelement_id, piece_id, page, pos_x, pos_y, dim_x, dim_y, template_id)
					VALUES (".$pe['id'].", ".$piece.", 1, ".$PosX.", ".$PosY.", ".$DimX.", ".$DimY.", 1)";
			$res = pg_query($SQL);
		}
		
	}
	?>
	
	<h3>Name: <br><textarea name="data" cols="80" rows="15"></textarea></h3>
	<h3>
	Idiom:
	<select name='idiom_id'>
	<option value=''></option>
	<?php
		$SQL = "SELECT IDIOM.* FROM IDIOM ORDER BY NAME";
		$res = pg_query($SQL);
		while($linha = pg_fetch_array($res)){
			echo "<option value=".$linha['id'].">".$linha['name']."</option>";
		}
	?>
	</select>
	Tema: <select name='semantic_id' onChange=document.activity_ins.submit()>";
	<?php
		$SQLdb = "SELECT semantic.* FROM semantic ORDER BY name_varchar";
		$resdb = pg_query($SQLdb);
		echo "<option value='".(isset($semantic_id)?$semantic_id:"")."'>".(isset($semantic_idname)?$semantic_idname:"")."</option>";
		echo "<option value=''></option>";
		while($linhadb = pg_fetch_array($resdb)){
			echo "<option value='".$linhadb['id']."'>".$linhadb['name_varchar']."</option>";
		}
	?>
	</select>
	</h3>
	
	<input name="imgGravar" value="true" id="sub" type="image" title=" Gravar " src="images/gravar.gif" alt="Gravar" width="60" height="18" border="0">
	<input type="hidden" value="1" name="acao">
	</form>
	
	<?php

}else{
	
	echo "piece: ".$piece;
	
	if(isset($filtragem) && $filtragem==4){
		$SQL = "INSERT INTO piece_element (element_id, piece_id, element_type) 
				VALUES (".$element_id.", ".$piece.", ".$element_type.")";
		$res = pg_query($SQL);
		unset($element_id);
		
		$SQL = "SELECT id FROM piece_element ORDER BY id DESC";
		$res = pg_query($SQL);
		$pe = pg_fetch_array($res);
		
		$SQL = "INSERT INTO pieceprinted (pieceelement_id, piece_id, page, pos_x, pos_y, dim_x, dim_y, template_id)
				VALUES (".$pe['id'].", ".$piece.", 1, ".$PosX.", ".$PosY.", ".$DimX.", ".$DimY.", 1)";
		$res = pg_query($SQL);
		echo "<script> window.close(); </script>";
	}
	
	if(isset($acao1) && $acao1=="editar"){
		$SQL = "UPDATE pieceprinted
				SET pos_x=".$PosX.", pos_y=".$PosY.", dim_x=".$DimX.", dim_y=".$DimY."
				WHERE pieceelement_id = ".$piece_element."";
		echo $SQL;
		$res = pg_query($SQL);
	
		unset($element_id);
		echo "<script> window.close(); </script>";
	}
		
	echo '<form name="paragraphform" action="paragraph.php" method="post">';
	if(!isset($element_id)){
		echo "<p>Buscar: <input type='text' name='name'>							
			<input type='hidden' name='filtragem' value=''>
			<input type='hidden' name='limpa' value='true'>
			<input type='hidden' name='piece' value=".$piece.">
			<input type='hidden' name='pieceseq' value=".$pieceseq.">
			<input type='image' name='imgEnviar' src='images/enviar.gif' alt='Enviar' onClick='filtra(11)'></p>";
	}
	
	if(isset($element_id) || (isset($acao) && $acao=="editar")){
		echo "<p>".((!isset($acao) || (isset($acao) && $acao!="editar"))?"Inserindo":"Editando")." o Elemento:<br> ".(isset($textname)?$textname:'')."<br>
				  PosX: <input type='text' size='1' name='PosX'><br>
				  PosY: <input type='text' size='1' name='PosY'><br>
				  DimX: <input type='text' size='1' name='DimX'><br>
				  DimY: <input type='text' size='1' name='DimY'>";
		echo "<input type='hidden' name='piece' value=".$piece.">";
		echo "<input type='hidden' name='pieceseq' value=".$pieceseq.">";
		echo "<input type='hidden' name='piece_element' value='".$piece_element."'>";
		echo "<input type='hidden' name='element_id' value='".$element_id."'>";
		echo "<input type='hidden' name='element_type' value='".$element_type."'>";
		echo "<input type='hidden' name='filtragem' value=''>";
		if(!isset($acao) || (isset($acao) && $acao!="editar")){
			echo "<input type='image' name='imgGravar' src='images/gravar.gif' alt='Gravar' onClick=filtra(4)></p><hr>";
		}
		if(isset($acao) && $acao=="editar"){
			echo "<input type='hidden' name='acao1' value='editar'>";
			echo "<input type='image' name='imgGravar' src='images/atualizar.gif' alt='Editar'></p><hr>";
		}
	}//if(!isset($element_id)){
	echo "</form>";
	if((isset($filtragem) && $filtragem==11) && (isset($name))){
		$name = strtolower($name);
		$SQL = "SELECT id, data FROM paragraph WHERE lower(data) LIKE '%".$name."%'";
		$res = pg_query($SQL);
		while($linha = pg_fetch_array($res)){
			echo "<p><a href='paragraph.php?textname=".$linha['data']."&pieceseq=".$pieceseq."&element_id=".$linha['id']."&piece=".$piece."&element_type=10'>".$linha[1]."</a></p>";
		}
	}
}
?>
</body>
</html>