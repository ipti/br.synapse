<?php
    session_start();

       ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
       include("includes/conecta.php");
       ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);


       ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
       require("includes/funcoes.php");
       ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
	   
if(!(session_is_registered('person'))){
	echo "erro";
	header('Location: ' . "http://" . $_SERVER["SERVER_NAME"]."/synapse/index.php");	
}
?>
	
<head>
<title><?php echo $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="<?php echo 'http://' . $_SERVER['SERVER_NAME']; ?>/synapse.css" rel="stylesheet" type="text/css">

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
  	document.forms["unityins"].filtragem.value = cod;	
}
//-->
</script>

</head>
<body>
<form name="unityins" action="unity_ins.php" method="post" onSubmit="return check_form(unityins);">

<?php
if($filtragem==1){
	
	if(isset($person_name) && $person_name!=""){
	$SQL = "INSERT INTO person (name, email, phone, celphone, postalcode, number, complement, persontype) 
			VALUES ('$person_name', '$person_email', '$person_phone', '$person_celphone', 
					'$person_postalcode', '$person_number', '$person_complement', '$person_persontype')";
	$res = mysql_query($SQL) or die($SQL ."#". mysql_error());
	
	$SQL = "SELECT person FROM person ORDER BY person DESC";
	$res = mysql_query($SQL);
	$linha = mysql_fetch_array($res);
	$unity_person = $linha['person'];
	}
	
	$SQL = "INSERT INTO unity (name, organization, unity_father, unity_level, person)
			VALUES ('$unity_name', '$org_cod', '$unityfather', '$unitylevel', ".($unity_person!=""?'$unity_person':"0").")";
	$res = mysql_query($SQL);
}

if($filtragem==2){

	if(isset($unity_person) && $unity_person!=""){
		$SQL = "UPDATE person SET name='".$person_name."', 
								  email=".($person_mail!=""?$person_email:'NULL').", 
								  phone=".($person_phone!=""?$person_phone:'NULL').", 
								  celphone=".($person_celphone!=""?$person_celphone:'NULL').", 
								  postalcode=".($person_postalcode!=""?$person_postalcode:'NULL').", 
								  number=".($person_number!=""?$person_number:'NULL').", 
								  complement='".$person_complement."', 
								  persontype=".$person_persontype."
				WHERE person = ".$unity_person."";
		$res = mysql_query($SQL);
echo $SQL;
	}elseif($unity_person==""){
		$SQL = "INSERT INTO person (name, email, phone, celphone, postalcode, number, complement, persontype) 
				VALUES ('$person_name', 
						".($person_mail!=""?$person_email:'NULL').", 
						".($person_phone!=""?$person_phone:'NULL').", 
						".($person_celphone!=""?$person_celphone:'NULL').", 
						".($person_postalcode!=""?$person_postalcode:'NULL').", 
						".($person_number!=""?$person_number:'NULL').", 
						".($person_complement!=""?$person_complement:'NULL').", 
						'$person_persontype')";
		$res = mysql_query($SQL);

		$SQL = "SELECT * FROM person ORDER BY person DESC";	
		$res = mysql_query($SQL);
		$linha = mysql_fetch_array($res);
		$unity_person = $linha['person'];
	}

	$SQLu = "UPDATE unity SET name='".$unity_name."', unity_father=".$unityfather.", unity_level=".$unitylevel.", person=".$unity_person."
			WHERE unity = ".$unity_cod."";
	$resu = mysql_query($SQLu);

}

if($unity_cod!=""){

	$SQL = "SELECT * FROM unity WHERE unity=".$unity_cod."";
	$res = mysql_query($SQL);
	$l_unity = mysql_fetch_array($res);
	
	$SQLf = "SELECT * FROM unity WHERE unity=".$l_unity['unity_father']."";
	$resf = mysql_query($SQLf);
	if(mysql_num_rows($resf)>0){
		$l_father = mysql_fetch_array($resf);
	}
	
	$SQLp = "SELECT * FROM person WHERE person=".$l_unity['person']."";
	$resp = mysql_query($SQLp);
	if(mysql_num_rows($resp)>0){
		$l_person = mysql_fetch_array($resp);
	}
}
?>
<h2>Dados da Unidade</h2>
<h3>Nome: <input name='unity_name' type='text' value='<?php if(isset($l_unity['name'])){ echo $l_unity['name']; }?>'></h3>
<h3>Nível: <input name='unitylevel' type='text' value='<?php if(isset($l_unity['unity_level'])){ echo $l_unity['unity_level']; }?>'></h3>

<h3>Unidade Pai
<select name='unityfather'>
<option value='<?php if(isset($l_unity['unity_father'])){ echo $l_unity['unity_father']; }?>'><?php if(isset($l_father['name'])){ echo $l_father['name']; }?></option>
<?php
	$SQL = "SELECT unity.* FROM unity ORDER BY unity_level";
	$res = mysql_query($SQL);
	while($linha = mysql_fetch_array($res)){
		echo "<option value='".$linha['unity']."'>".$linha['name']." - ".$linha['unity_level']."</option>";
	}
?>
</select>
</h3>

<input type='hidden' name= 'unity_cod' value='<?php echo $l_unity['unity']; ?>'>
<input type='hidden' name= 'org_cod' value='<?php echo $organization_cod; ?>'>

<h2>Dados da Pessoa</h2>
<h3>Nome: <input name='person_name' size='30' type='text' value='<?php if(isset($l_person['name'])){ echo $l_person['name']; }?>'></h3>
<h3>Email: <input name='person_email' size='30' type='text' value='<?php if(isset($l_person['email'])){ echo $l_person['email']; }?>'></h3>
<h3>Fone: <input name='person_phone' type='text' value='<?php if(isset($l_person['phone'])){ echo $l_person['phone']; }?>'></h3>
<h3>Celular: <input name='person_celphone' type='text' value='<?php if(isset($l_person['celphone'])){ echo $l_person['celphone']; }?>'></h3>
<h3>Postal: <input name='person_postalcode' type='text' value='<?php if(isset($l_person['postalcode'])){ echo $l_person['postalcode']; }?>'></h3>
<h3>Número: <input name='person_number' type='text' value='<?php if(isset($l_person['number'])){ echo $l_person['number']; }?>'></h3>
<h3>Complemento: <input name='person_complement' type='text' value='<?php if(isset($l_person['complement'])){ echo $l_person['complement']; }?>'></h3>
<h3>Tipo: <input name='person_persontype' type='text' value='<?php if(isset($l_person['persontype'])){ echo $l_person['persontype']; }?>'></h3>

<input type='hidden' name= 'unity_person' value='<?php if(isset($l_person['person'])){ echo $l_person['person']; }?>'>

<input type=hidden value=0 name=filtragem>

<?php
if($unity_cod==""){
	echo '<input name="imgGravar" value="true" id="sub" type="image" title=" Gravar " src="../../../../imagens/gravar.gif" alt="Gravar" width="60" height="18" border="0" onClick=filtra(1)>';
}elseif($unity_cod!=""){
	echo '<input name="imgAtualizar" value="true" id="sub" type="image" title=" Atualizar " src="../../../../imagens/atualizar.gif" alt="Atualizar" width="60" height="18" border="0" onClick=filtra(2)>';
}
?>
</form>
</body>
</html>