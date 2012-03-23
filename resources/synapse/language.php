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
$h2="Bem Vindo: ";
$newsa="Notícias Atuais da Organização";
$newsb="Notícias Atuais da Organização abaixo";
}

if(isset($idiom) && $idiom=="16"){
$h1="Home";
$h2="Welcome: ";
$newsa="Actual News of the Organization";
$newsb="Actual News of the Below Organization";
}

if(isset($idiom) && $idiom=="17"){
$h1="Haus";
$h2="Willkommen: ";
$newsa="Eigentlich Überblick von di Organisation";
$newsb="Eigentlich Überblick von die unten Organisation";
}

if(isset($upddescription)){
	$SQL = "UPDATE goal SET description = '".$txtdescription."' WHERE id = ".$idgoal."";
	$res = pg_query($SQL);
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
?> 
</div>

<div id='coltripla'>
<?php
function selectwordClass(){
	echo "<h2>Word Class</h2>";
	$SQLf = "SELECT * FROM wordClass where father_id is null ORDER BY name";
	$resf = pg_query($SQLf);
	echo "<ul>";
	while($linhaf = pg_fetch_array($resf)){
		echo "<li>".$linhaf['name']."</li>";
		$SQLs = "SELECT * FROM wordClass WHERE father_id = ".$linhaf['id']." ORDER BY name";
		$ress = pg_query($SQLs);
		echo "<ul>";
		//echo $SQLs;
		while($linhas = pg_fetch_array($ress)){
			echo "<li>".$linhas['name']."</li>";
			$SQLn = "SELECT * FROM wordClass WHERE father_id = ".$linhas['id']." ORDER BY name";
			$resn = pg_query($SQLn);
			echo "<ul>";
			//echo $SQLn;
			while($linhan = pg_fetch_array($resn)){
				echo "<li>".$linhan['name']."</li>";
				$SQLv = "SELECT * FROM wordClass WHERE father_id = ".$linhan['id']." ORDER BY name";
				$resv = pg_query($SQLv);
				echo "<ul>";
				//echo $SQLv;
				while($linhav = pg_fetch_array($resv)){
					echo "<li>".$linhav['name']."</li>";
				}
				echo "</ul>";
			}
			echo "</ul>";
		}
		echo "</ul>";
	}
	echo "</ul>";
}

function selectwordConjunction(){
	echo "<h2>Word Conjunction</h2>";
	$SQL = "SELECT * FROM wordConjunction ORDER BY name";
	$res = pg_query($SQL);
	echo "<ul>";
	while($linha = pg_fetch_array($res)){
		echo "<li>".$linha['name']."</li>";
	}
	echo "</ul>";
}
function selectphraseSyntax(){
	echo "<h2>Phrase Syntax</h2>";
	$SQLf = "SELECT * FROM phraseSyntax WHERE father_id is null ORDER BY name";
	$resf = pg_query($SQLf);
	echo "<ul>";
	//echo $SQLf;
	while($linhaf = pg_fetch_array($resf)){
		echo "<li>".$linhaf['name']."</li>";
		$SQLs = "SELECT * FROM phraseSyntax WHERE father_id = ".$linhaf['id']." ORDER BY name";
		$ress = pg_query($SQLs);
		echo "<ul>";
		//echo $SQLs;
		while($linhas = pg_fetch_array($ress)){
			echo "<li>".$linhas['name']."</li>";
			$SQLn = "SELECT * FROM phraseSyntax WHERE father_id = ".$linhas['id']." ORDER BY name";
			$resn = pg_query($SQLn);
			echo "<ul>";
			//echo $SQLn;
			while($linhan = pg_fetch_array($resn)){
				echo "<li>".$linhan['name']."</li>";
				$SQLv = "SELECT * FROM phraseSyntax WHERE father_id = ".$linhan['id']." ORDER BY name";
				$resv = pg_query($SQLv);
				echo "<ul>";
				//echo $SQLv;
				while($linhav = pg_fetch_array($resv)){
					echo "<li>".$linhav['name']."</li>";
				}
				echo "</ul>";
			}
			echo "</ul>";
		}
		echo "</ul>";
	}
	echo "</ul>";
}
function selectwordCase(){
	echo "<h2>Word Case</h2>";
	$SQL = "SELECT * FROM wordCase ORDER BY name";
	$res = pg_query($SQL);
	while($linha = pg_fetch_array($res)){
		echo "<li>".$linha['name']."</li>";
	}

}
function selectphraseClause(){
	echo "<h2>Phrase Clause</h2>";
	$SQL = "SELECT pc.*, (wc.name) as wcname, (ps.name) as psname, (cj.name) as cjname
			FROM phraseClause pc
					LEFT JOIN wordClass wc ON wc.id = pc.wordClass_id
					LEFT JOIN phraseSyntax ps ON ps.id = pc.phraseSyntax_id
					LEFT JOIN wordConjunction cj ON cj.id = pc.wordConjunction_id";
	if(isset($selectwordClass) || isset($selectphraseSyntax) || isset($selectwordConjunction)){
		$SQL.= "WHERE ";
		if(isset($selectwordClass) && $selectwordClass!=""){
			$SQL.= " pc.wordClass_id = ".$selectwordClass."";
		}
		if(isset($selectphraseSyntax) && $selectphraseSyntax!=""){
			$SQL.= " pc.phraseSyntax_id = ".$selectphraseSyntax."";
		}
		if(isset($selectwordConjunction) && $selectwordConjunction!=""){
			$SQL.= " pc.wordConjunction_id = ".$selectwordConjunction."";
		}
	}
	$SQL.= " ORDER BY number, relation, wcname, psname, cjname";
	$res = pg_query($SQL);
	echo "<ul>";
	while($linha = pg_fetch_array($res)){
		echo "<li>".$linha['number']." - ".$linha['relation']." - ".$linha['wcname']." - ".$linha['psname']." - ".$linha['cjname']."</li>";
	}
	echo "</ul>";

}
?>
<table><tr>
<?php 
echo "<td valign='top'>"; selectwordClass(); echo "</td>";
echo "<td valign='top'>"; selectphraseSyntax(); echo "</td>";
echo "<td valign='top'>"; selectwordConjunction(); echo "</td>";
?>
</tr></table>
</div>
<div id="colquadra">
<?php
selectphraseClause();
?>
</div>
<div id="base"><?php echo $base.date('Y');?> ::</div>
</body>
</html>