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
  	document.forms["orgins"].filtragem.value = cod;	
}
//-->
</script>

</head>
<body>
<form name="orgins" action="org_ins.php" method="post" onSubmit="return check_form(orgins);">

<?php
if($acao==1){
	$SQL = "INSERT INTO organization (name, org_father, org_level) 
			VALUES ('$name', '$orgfather', '$orglevel')";
	$res = mysql_query($SQL) or die($SQL ."#". mysql_error());
	
	$SQL = "SELECT organization FROM organization ORDER BY organization DESC";
	$res = mysql_query($SQL);
	$linha = mysql_fetch_array($res);
	$org_cod = $linha['organization'];
	
	$SQL = "INSERT INTO unity (name, organization, unity_father, unit_level)
			VALUES ('$unity_name', '$org_cod', '$unityfather', '$unitylevel')";
	$res = mysql_query($SQL);
	
}
?>

<h3>Nome: <input name='name' type='text'></h3>
<h3>Nível: <input name='orglevel' type='text'></h3>
<h3>
<select name='orgfather'>
<option value=''></option>
<?php
	$SQL = "SELECT organization.* FROM organization ORDER BY org_level";
	$res = mysql_query($SQL);
	while($linha = mysql_fetch_array($res)){
		echo "<option value=".$linha['organization'].">".$linha['name']." - ".$linha['org_level']."</option>";
	}
?>
</select>
</h3>

<h3>Nome da Unidade: <input name='unity_name' type='text'></h3>
<h3>Nível da Unidade: <input name='unitylevel' type='text'></h3>

<h3>Unidade Pai
<select name='unityfather'>
<option value=''></option>
<?php
	$SQL = "SELECT unity.* FROM unity ORDER BY unity_level";
	$res = mysql_query($SQL);
	while($linha = mysql_fetch_array($res)){
		echo "<option value='".$linha['unity']."'>".$linha['name']." - ".$linha['unity_level']."</option>";
	}
?>
</select>
</h3>

<input name="imgGravar" value="true" id="sub" type="image" title=" Gravar " src="../../../../imagens/gravar.gif" alt="Gravar" width="60" height="18" border="0">

<input type="hidden" value="1" name="acao">

</form>
</body>
</html>