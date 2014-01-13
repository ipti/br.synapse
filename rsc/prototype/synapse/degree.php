<?php
session_start();

ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
include("includes/conecta.php");
ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
include("includes/funcoes.php");
ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

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
<head>
<title>:: ENSCER - Ensinando o c&eacute;rebro :: Portal Enscer</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="synapse.css" rel="stylesheet" type="text/css">
<script language="javascript">
<!--
var form = "";
var submitted = false;
var error = false;
var error_message = "";

function check_form(form) {
  if (submitted == true) {
    alert("Este formulário já foi enviado. Por favor pressione OK e aguarde o processo ser completado.");
    return false;
  }
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
    include("includes/menu.php");
    ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

	$SQLd = "SELECT * FROM discipline ORDER BY id";
	$resd = pg_query($SQLd);
	while($linhad = pg_fetch_array($resd)){
		echo "<h3>".$linhad['name']."</h3>";
		$SQLs = "SELECT * FROM degree_stage ORDER BY grade";
		$ress = pg_query($SQLs);
		echo "<ul>";
		while($linhas=pg_fetch_array($ress)){
			echo "<li><a href='degree.php?discname=".$linhad['name']."&discipline=".$linhad['id']."&stagename=".$linhas['name']."&degreestage=".$linhas['id']."'>".$linhas['name']."</a></li>";
		}
		echo "</ul>";
	}
?> 
</div>

<div id='coltripla'>
  <h1><?php echo $h1; ?></h1>
<?php 

	echo "<h2>".$h2.(isset($personagename)?$personagename:"").$personname."</h2>";
 	echo "<h3>".(isset($organizationname)?$organizationname:"").(isset($unityname)?" - ".$unityname:"")."</h3>";
	echo "<hr>";
	
	if(isset($degreestage) && $degreestage!=""){
		echo "<h1>".$discname." - ".$stagename."</h1>";	
		$SQLb = "SELECT * FROM degree_block WHERE degree_stage = ".$degreestage." ORDER BY grade";
		$resb = pg_query($SQLb);
		while($linhab = pg_fetch_array($resb)){
			echo "<h3>".$linhab['name']."</h3>";
			$SQL = "SELECT * FROM goal WHERE degreeblock_id = ".$linhab['id']." AND discipline_id = ".$discipline." ORDER BY grade ";
			$res = pg_query($SQL);
			echo "<ul>";
			while($linha = pg_fetch_array($res)){
				echo "<li><strong>".$linha['id']." - ".$linha['name_varchar']." - Grau: ".$linha['grade']."</strong></li>";
			}
			echo "</ul>";
		}
	}
?>
</div>
<div id="base">:: ENSCER - Ensinando o Cérebro :: <?php echo date('Y');?> ::</div>
</body>
</html>