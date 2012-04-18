<?php
    session_start();

    ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
    include("includes/conecta.php");
    ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
	   
	ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
	require("includes/funcoes.php");
	ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);


if(isset($idiom) && $idiom=="7"){
$h1="Meu Cadastro";
$h2="Bem Vindo:";
}

if(isset($idiom) && $idiom=="16"){
$h1="My Regsiter";
$h2="Welcome:";
}

unset($insert);
unset($update);
?>

<script language="javascript">
<!--
var form = "";
var submitted = false;
var error = false;
var error_message = "";

function check_input(field_name, field_size, message) {
  if (form.elements[field_name] && (form.elements[field_name].type != "hidden")) {
  var field_value = form.elements[field_name].value;
    if (field_value == '' || field_value.length < field_size) {
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
	check_input("txtemail", 5, "Preencha o seu e-mail");
	check_input("txtlogin", 5, "Seu Login deve ter no mínimo 5 caracteres");
	check_input("txtpassword", 5, "Sua Senha deve ter entre 5 e 20 caracteres");
	if (error == true) {
		alert(error_message);
		return false;
	}

}
  
function filtra(cod) {
  	document.forms["person_ins"].filtragem.value = cod;	
}
//-->
</script>

<?php
if(isset($filtragem) && $filtragem==1){

	//insere um novo registro de person, human, actor e user

	//$stmt="EXECUTE PROCEDURE PERSON_INS('".$name."', '".$email."', '".$phone."', '".$celphone."', ".$postalcode.", ".$number.", '".$complement."', ".$persontype.")"; 
	//$query = pg_prepare($stmt);
	//$res=pg_execute($query);
	
	$SQL = "SELECT id FROM person WHERE email = '".$txtemail."'";
	$res = pg_query($SQL);
	
	if(pg_num_rows($res)>0){
		$msg = "<h3><font color='red'>Já existe um usuário com o e-mail informado!</font></h3>";
		redireciona("http://". $_SERVER['SERVER_NAME'] . "/synapse/index.php?msg=".$msg."");
	}else{
		
		$SQLip = "INSERT INTO person (name, email, phone, celphone, addresstype, address, number, complement, state_id, city_id, country_id, nationality_id, birthday, postalcode) 
				  VALUES ('".($txtname!=""?$txtname:"''")."', '".$txtemail."', '".($txtphone!=""?$txtphone:"''")."', '".($txtcelphone!=""?$txtcelphone:"''")."', '".($txtaddresstype!=""?$txtaddresstype:"''")."', '".($txtaddress!=""?$txtaddress:"''")."', '".($txtnumber!=""?$txtnumber:"''")."', '".($txtcomplement!=""?$txtcomplement:"''")."', '".($txtstate!=""?$txtstate:"''")."', ".($txtcity!=""?$txtcity:"0").", '".($txtcountry!=""?$txtcountry:"''")."', '".($txtnationality!=""?$txtnationality:"''")."', '".($txtbirthday!=""?$txtbirthday:"''")."', '".($txtpostalcode!=""?$txtpostalcode:"''")."')";
		if($resip = pg_query($SQLip)){
			$insertp = true;
		}
		
		if(isset($insertp)){
			$SQL = "SELECT id FROM person ORDER BY id DESC";
			$res = pg_query($SQL);
			$linha = pg_fetch_row($res);
			
			$person = $linha[0];
			session_register('person');
			$horas = date("Y-m-d H:i:s");
			
			$SQLia = "INSERT INTO actor (person_id, unity_id, personage_id, activated) VALUES (".$person.", 1, 2, '".$horas."')";
			
			$SQLil = "INSERT INTO login (person_id, login, password, accountdate, loginnumber) VALUES (".$person.", '".$txtlogin."', '".$txtpassword."', '".$horas."', 1)";
			
			if(($resia = pg_query($SQLia)) && ($resil = pg_query($SQLil))){
				$insert = true;

				$SQLa = "SELECT id FROM actor ORDER BY id DESC";
				$resa = pg_query($SQLa);
				$linhaa = pg_fetch_row($resa);
				$actor = $linhaa['id'];
				session_register('actor');
				$unity = 1;
				session_register('unity');
				$organization = 1;
				session_register('organization');
				$org_level = 1;
				session_register('org_level');
				$personage = 2;
				session_register('personage');
			}
		}//if(isset($insertp)){
	}//if(pg_num_rows($res)>0){SELECT FROM person
}//if($filtragem==1)

//atualiza os registros de person, actor, human e user
if(isset($filtragem) && $filtragem==2){

	if(isset($person) && $person!=""){
	
		$SQLp = "UPDATE person SET name='".($txtname!=""?$txtname:"''")."', 
								  email='".($txtemail!=""?$txtemail:"''")."', 
								  phone='".($txtphone!=""?$txtphone:"''")."', 
								  celphone='".($txtcelphone!=""?$txtcelphone:"''")."', 
								  address='".($txtaddress!=""?$txtaddress:"''")."', 
								  number='".($txtnumber!=""?$txtnumber:"''")."', 
								  birthday='".($txtbirthday!=""?$txtbirthday:"''")."', 
								  nationality_id='".($txtnationality!=""?$txtnationality:"''")."', 
								  state_id='".($txtstate!=""?$txtstate:"''")."', 
								  city_id=".($txtcity!=""?$txtcity:"''").", 
								  country_id='".($txtcountry!=""?$txtcountry:"''")."', 
								  addresstype='".($txtaddresstype!=""?$txtaddresstype:"''")."', 
								  postalcode='".($txtpostalcode!=""?$txtpostalcode:"''")."', 
								  complement='".$txtcomplement."'
				WHERE id = ".$person."";
		
		$SQLl = "UPDATE login SET login='".($txtlogin!=""?$txtlogin:'NULL')."', 
								password='".($txtpassword!=""?$txtpassword:'NULL')."'
				WHERE person_id = ".$person."";
		
		if(($resp = pg_query($SQLp)) && ($resl = pg_query($SQLl))){
			$update = true;
		}
	}//if(isset($person) && $person!=""){
}//if(isset($filtragem) && $filtragem==2){

if((isset($insert) && $insert==true) || (isset($update) && $update==true)){
		$personname = $txtname;
		session_register('personname');
		$email = $txtemail;
		session_register('email');
		$birthday = $txtbirthday;
		session_register('birthday');
		$nationality = $txtnationality;
		session_register('nationality');
		$addresstype = $txtaddresstype;
		session_register('addresstype');
		$address = $txtaddress;
		session_register('address');
		$number = $txtnumber;
		session_register('number');
		$complement = $txtcomplement;
		session_register('complement');
		$postalcode = $txtpostalcode;
		session_register('postalcode');
		$city = $txtcity;
		session_register('city');
		$cityname = $cityname;
		session_register('cityname');
		$state = $txtstate;
		session_register('state');
		$country = $txtcountry_id;
		session_register('country');
		$phone = $txtphone;
		session_register('phone');
		$celphone = $txtcelphone;
		session_register('celphone');

		if(isset($pedido)){
			redireciona("http://". $_SERVER['SERVER_NAME'] . "/synapse/fechapedido.php");
		}
		
}
?>

<head>
<title><?php echo $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="synapse.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
      ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
      include("includes/topo.php");
      ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
?>	  
<div id='col1'>

<?php
	if(isset($person) && $person!=""){
		ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
		include("includes/menu.php");//?idiom=".$idiom."
		ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
	}
?>

</div>

<div id='coltripla'>
 <h1><?php echo $h1; ?></h1>
<?php
	echo "<h2>".$h2.(isset($personagename)?$personagename:"").$personname."</h2>";
 	echo "<h3>".(isset($organizationname)?$organizationname:"").(isset($unityname)?" - ".$unityname:"")."</h3>";
	echo "<hr>";

if(isset($msg)){
	echo $msg;
}
if(!isset($insert) && !isset($update)){
?>

<form name="person_ins" action="person_ins.php" method="post" onSubmit="return check_form(person_ins);">
<table>
<tr>
	<td colspan="2"><h2>Dados da Pessoa</h2></td>
</tr>
<tr>
	<td><h3>Nome: <input name='txtname' size='40' type='text' maxlength="120" value='<?php if(isset($txtname)){ echo $txtname; }elseif(isset($personname)){ echo $personname;}?>'></h3></td>
	<td><h3>Nasc: <input name='txtbirthday' size='20' type='text' maxlength="10" value='<?php if(isset($txtbirthday)){ echo $txtbirthday; }elseif(isset($birthday)){ echo $birthday;}?>'></h3></td>
</tr>
<tr>
	<td><h3>Email: <input name='txtemail' size='30' type='text' maxlength="60" value='<?php if(isset($txtemail)){ echo $txtemail; }elseif(isset($email)){ echo $email;}?>'></h3></td>
</tr>
<tr>
	<td><h3>Fone: <input name='txtphone' type='text' maxlength="120" value='<?php if(isset($txtphone)){ echo $txtphone; }elseif(isset($phone)){ echo $phone;}?>'></h3></td>
	<td><h3>Celular: <input name='txtcelphone' type='text' maxlength="20" value='<?php if(isset($txtcelphone)){ echo $txtcelphone; }elseif(isset($celphone)){ echo $celphone;}?>'></h3></td>
</tr>
<tr>
	<td><h3>
	<select name="txtaddresstype">
	<option value="rua">Rua</option>
	<option value="avenida">Avenida</option>
	<option value="praca">Praça</option>
	<option value="alameda">Alameda</option>
	</select>
	:<input name='txtaddress' type='text' maxlength="120" value='<?php if(isset($txtaddress)){ echo $txtaddress; }elseif(isset($address)){ echo $address;}?>'>
	</h3></td>
	<td><h3>Número: <input name='txtnumber' type='text' maxlength="40" value='<?php if(isset($txtnumber)){ echo $txtnumber; }elseif(isset($number)){ echo $number;}?>'></h3></td>
</tr>
<tr>
	<td><h3>Complemento: <input name='txtcomplement' type='text' maxlength="45" value='<?php if(isset($txtcomplement)){ echo $txtcomplement; }elseif(isset($complement)){ echo $complement;}?>'></h3></td>
	<td><h3>Postal: <input name='txtpostalcode' type='text' maxlength="20" value='<?php if(isset($txtpostalcode)){ echo $txtpostalcode; }elseif(isset($postalcode)){ echo $postalcode;}?>'></h3></td>
</tr>
<tr>
	<td colspan="2"><h3>Estado: 
	<select name="txtstate" onChange=document.person_ins.submit()>
	<?php 
	if(isset($txtstate)){
		echo "<option value=".$txtstate." selected>".$txtstate."</option>";
	}elseif(isset($state)){
		echo "<option value=".$state." selected>".$state."</option>";
	}else{
		echo "<option value=''></option>";
	}
	$SQL = "SELECT * FROM state"; 
	$res = pg_query($SQL);
	while($linha=pg_fetch_array($res)){
		echo "<option value=".$linha['uf'].">".$linha['uf']."</option>";
	}
	?>
	</select>

	Cidade: 
	<select name="txtcity">
	<?php
	if(isset($txtcity)){
		echo "<option value=".$txtcity." selected>".$txtcity."</option>";
	}elseif(isset($city)){
		echo "<option value=".$city." selected>".$cityname."</option>";
	}else{
		echo "<option value=''></option>";
	}
	$SQL = "SELECT * FROM city WHERE uf = '".$txtstate."'"; 
	$res = pg_query($SQL);
	while($linha=pg_fetch_array($res)){
		echo "<option value=".$linha['id'].">".$linha['name']."</option>";
	}
	?>
	</select>
	</h3></td>
</tr>
<tr>
	<td colspan="2"><h3>País: 
	<select name="txtcountry">
	<?php 
	if(isset($txtcountry)){
		echo "<option value=".$txtcountry." selected>".$txtcountry."</option>";
	}elseif(isset($country)){
		echo "<option value=".$country." selected>".$country."</option>";
	}else{
		echo "<option value='BR' selected>Brasil</option>";
	}
	$SQL = "SELECT * FROM country"; 
	$res = pg_query($SQL);
	while($linha=pg_fetch_array($res)){
		echo "<option value=".$linha['iso'].">".$linha['name']."</option>";
	}
	?>
	</select>
	</h3></td>
</tr>
<tr>
	<td colspan="2"><h3>Nacionalidade: 
	<select name="txtnationality">
	<?php 
	if(isset($txtnationality)){
		echo "<option value=".$txtnationality." selected>".$txtnationality."</option>";
	}elseif(isset($nationality)){
		echo "<option value=".$nationality." selected>".$nationality."</option>";
	}else{
		echo "<option value='BR' selected>Brasil</option>";
	}
	$SQL = "SELECT * FROM country"; 
	$res = pg_query($SQL);
	while($linha=pg_fetch_array($res)){
		echo "<option value=".$linha['iso'].">".$linha['name']."</option>";
	}
	?>
	</select>
	</h3></td>
</tr>
<tr>
	<td><h3>Login: <input name='txtlogin' type='text' maxlength="120" value='<?php if(isset($txtlogin)){ echo $txtlogin; }elseif(isset($login)){ echo $login;}?>'></h3></td>
	<td><h3>Password: <input name='txtpassword' type='text' maxlength="20" value='<?php if(isset($txtpassword)){ echo $txtpassword; }elseif(isset($password)){ echo $password;}?>'></h3></td>
</tr>
</table>
<input type='hidden' value='0' name='filtragem'>
<h3>
<?php
if(!isset($person)){
	echo '<input name="imgGravar" value="true" id="sub" type="image" title=" Gravar " src="images/gravar.gif" alt="Gravar" width="60" height="18" border="0" onClick=filtra(1)>';
}elseif(isset($person) && $person!=""){
	echo '<input name="imgAtualizar" value="true" id="sub" type="image" title=" Atualizar " src="images/atualizar.gif" alt="Atualizar" width="60" height="18" border="0" onClick=filtra(2)>';
}
?>
</h3>
</form>
<?php
}else{
	echo "<script> window.location='sysuser.php'; </script>";
}//if(!isset($insert) && !isset($update)){
?>
</div>
<div id="base"><?php echo $base.date('Y');?> ::</div>
</body>
</html>