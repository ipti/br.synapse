<?php
    session_start();

       ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
       include("includes/conecta.php");
       ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

if(!(session_is_registered('person'))){
	echo "erro";
	header('Location: ' . "http://" . $_SERVER["SERVER_NAME"]."/synapse/index.php");	
}

if(isset($idiom) && $idiom=="7"){
$h1="Meu Cadastro";
$h2="Bem Vindo:";
}

if(isset($idiom) && $idiom=="16"){
$h1="My Regsiter";
$h2="Welcome:";
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
  	document.forms["actorins"].filtragem.value = cod;	
}
//-->
</script>

</head>
<body>
<?php
      ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
      include("includes/topo.php");
      ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
?>	  
<div id='col1'>

<?php
	ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
    include("includes/menu.php");//?idiom=".$idiom."
    ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
?>

</div>

<div id='coltripla'>
 <h1><?php echo $h1; ?></h1>
<?php
	echo "<h2>".$h2." ".$personagename." ".$personname."</h2>";
 	echo "<h3>".$organizationname.($unityname!=""?" - ".$unityname:"")."</h3>";
	echo "<hr>";

	echo '<form name="actorins" action="actorins.php" method="post" onSubmit="return check_form(actorins);">';

if(isset($filtragem) && $filtragem==2){
	
	//atualiza os registros de person, actor, human e user
	if(isset($actor_person) && $actor_person!=""){
	
		$SQLp = "UPDATE person SET name='".$person_name."', 
								  email=".$person_email.", 
								  phone=".($person_phone!=""?$person_phone:'NULL').", 
								  celphone=".($person_celphone!=""?$person_celphone:'NULL').", 
								  postalcode=".($person_postalcode!=""?$person_postalcode:'NULL').", 
								  number=".($person_number!=""?$person_number:'NULL').", 
								  complement='".$person_complement."', 
								  persontype=".$person_persontype."
				WHERE person = ".$actor_person."";
		$resp = pg_query($SQLp);
		
	}elseif($actor_person==""){
	
		$SQLp = "INSERT INTO person (name, email, phone, celphone, postalcode, number, complement, persontype) 
				VALUES ('$person_name', '$person_email', 
						".($person_phone!=""?$person_phone:'NULL').", 
						".($person_celphone!=""?$person_celphone:'NULL').", 
						".($person_postalcode!=""?$person_postalcode:'NULL').", 
						".($person_number!=""?$person_number:'NULL').", 
						'$person_complement', '$person_persontype')";
		$resp = pg_query($SQLp);

		$SQL = "SELECT * FROM person ORDER BY person DESC";	
		$res = pg_query($SQL);
		$linha = pg_fetch_array($res);
		$actor_person = $linha['person'];
	}
	
	if(isset($actor_human) && $actor_human!=""){
	
		$SQLh = "UPDATE human SET (person, sex, ethnicity, laterality)
				VALUES ('$actor_person', '$person_sex', '$person_ethnicity', '$person_laterality')
				WHERE human = ".$actor_human."";
		$resh = pg_query($SQLh);
	
	}elseif($actor_human==""){
	
		$SQLh = "INSERT INTO human (person, sex, ethnicity, laterality) 
					VALUES ('$actor_person', '$human_sex', '$human_ethnicity', '$human_laterality')";
		$resh = pg_query($SQLh);
	}
	
	if(isset($actor_cod) && $actor_cod!=""){
	
		$SQLa = "UPDATE actor SET (name, person_id, unity_id, personage_id)
				VALUES ('".$actor_name."', ".$actor_person.", ".$unity_son.", ".$actor_personage.")
				WHERE actor = ".$actor_cod."";
		$resa = pg_query($SQLa);
	
	}elseif($actor_human==""){
	
		$SQLa = "INSERT INTO actor (name, person_id, unity_id, personage_id)
				VALUES ('".$actor_name."', ".$actor_person.", ".$unitycod.", ".$actor_personage.")";
		$resa = pg_query($SQLa);
	
	}
	
	if(isset($actor_user) && $actor_user!=""){
	
		$SQLu = "UPDATE sysuser SET (person, userpass, login)
				VALUES ('$actor_person', '$user_password', '$user_login')
				WHERE sysuser = ".$actor_user."";
		$resu = pg_query($SQLu);
	
	}elseif($actor_user==""){
	
		$SQLu = "INSERT INTO sysuser (person, userpass, login)
			     VALUES ('$actor_person', '$user_password', '$user_login')";
		$resu = pg_query($SQLu);
	}

}

if(isset($actor_cod) && $actor_cod!=""){

	$SQL = "SELECT * FROM actor WHERE id=".$actor_cod."";
	$res = pg_query($SQL);
	$l_actor = pg_fetch_array($res);
	
	$SQLpg = "SELECT * FROM personage WHERE id=".$l_actor['personage_id']."";
	$respg = pg_query($SQLpg);
	$l_personage = pg_fetch_array($respg);
	
	$SQLp = "SELECT * FROM person WHERE id=".$l_actor['person_id']."";
	$resp = pg_query($SQLp);
	$l_person = pg_fetch_array($resp);
	
	$SQLh = "SELECT * FROM human WHERE person_id=".$l_actor['person_id']."";
	$resh = pg_query($SQLh);
	$l_human = pg_fetch_array($resh);
	
	$SQLu = "SELECT * FROM login WHERE person_id=".$l_actor['person_id']."";
	$resu = pg_query($SQLu);
	$l_user = pg_fetch_array($resu);
}
?>

<h2>Dados do Ator</h2>
<h3>Nome: <input name='actor_name' size='50' type='text' value='<?php if(isset($l_actor['name'])){ echo $l_actor['name']; }?>'></h3>

<h3>Personagem:
<select name='actor_personage'>
<option value='<?php if(isset($l_personage['0'])){ echo $l_personage['id']; }?>'><?php if(isset($l_personage['name'])){ echo $l_personage['name']; }?></option>
<?php
	$SQL = "SELECT organization FROM unity WHERE unity=".$unity_son."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$organization_cod=$linha['0'];
	
	$SQL = "SELECT personage.* FROM personage WHERE organization_id=".$organization_cod."";
	$res = pg_query($SQL);
	while($linha = pg_fetch_array($res)){
		echo "<option value='".$linha['id']."'>".$linha['name']."</option>";
	}
?>
</select>
</h3>

<input type='hidden' name= 'actor_cod' value='<?php echo $l_actor['id']; ?>'>
<input type='hidden' name= 'unitycod' value='<?php echo $unity_son; ?>'>

<h2>Dados da Pessoa</h2>
<h3>Nome: <input name='person_name' size='50' type='text' value='<?php if(isset($l_person['name'])){ echo $l_person['name']; }?>'></h3>
<h3>Email: <input name='person_email' size='30' type='text' value='<?php if(isset($l_person['email'])){ echo $l_person['email']; }?>'></h3>
<h3>Fone: <input name='person_phone' type='text' value='<?php if(isset($l_person['phone'])){ echo $l_person['phone']; }?>'></h3>
<h3>Celular: <input name='person_celphone' type='text' value='<?php if(isset($l_person['celphone'])){ echo $l_person['celphone']; }?>'></h3>
<h3>Postal: <input name='person_postalcode' type='text' value='<?php if(isset($l_person['postalcode'])){ echo $l_person['postalcode']; }?>'></h3>
<h3>Número: <input name='person_number' type='text' value='<?php if(isset($l_person['number'])){ echo $l_person['number']; }?>'></h3>
<h3>Complemento: <input name='person_complement' type='text' value='<?php if(isset($l_person['complement'])){ echo $l_person['complement']; }?>'></h3>
<h3>Tipo: <input name='person_persontype' type='text' value='<?php if(isset($l_person['person_type'])){ echo $l_person['person_type']; }?>'></h3>

<input type='hidden' name= 'actor_person' value='<?php echo $l_person['id'] ?>'>

<h2>Dados do Humano</h2>
<h3>Sexo: <input name='human_sex' type='text' value='<?php if(isset($l_human['sex'])){ echo $l_human['sex']; }?>'></h3>
<h3>Etnia: <input name='human_ethnicity' type='text' value='<?php if(isset($l_human['ethnicity'])){ echo $l_human['ethnicity']; }?>'></h3>
<h3>Lateralidade: <input name='human_laterality' type='text' value='<?php if(isset($l_human['laterality'])){ echo $l_human['laterality']; }?>'></h3>

<input type='hidden' name= 'actor_human' value='<?php echo $l_human['id'] ?>'>

<h2>Dados do Usuário</h2>
<h3>Login: <input name='user_login' type='text' value='<?php if(isset($l_user['login'])){ echo $l_user['login']; }?>'></h3>
<h3>Password: <input name='user_password' type='text' value='<?php if(isset($l_user['password'])){ echo $l_user['password']; }?>'></h3>

<input type='hidden' name= 'actor_user' value='<?php echo $l_user['id'] ?>'>

<input type=hidden value=0 name=filtragem>

<?php
if(isset($actor_cod) && $actor_cod!=""){
	echo '<input name="imgAtualizar" value="true" id="sub" type="image" title=" Atualizar " src="images/atualizar.gif" alt="Atualizar" width="60" height="18" border="0" onClick=filtra(2)>';
}
?>
</form>
</div>
<div id="base"><?php echo $base.date('Y');?> ::</div>
</body>
</html>