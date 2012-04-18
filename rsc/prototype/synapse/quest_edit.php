<?php
	session_start();
  	
      ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
      require("includes/conecta.php");
      ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

if(!(session_is_registered('person'))){
	echo "erro";
	header('Location: ' . "http://" . $_SERVER["SERVER_NAME"]."/synapse/index.php");	
}
	  
if(isset($idiom) && $idiom=="7"){
$h1="Edição de Questionários";
$h2="Bem Vindo:";
$h3="Questionários Registrados";
$options="Opções";
$registered="Registrado";
$toview="Visualizar";
$toedit="Editar";
$new="Para registrar um novo questionário utilize o menu ao lado!";
$insert="Registrando um novo questionário de";
$edit="Editando o questionário já registrado de";
$menu1="Registrar um novo questionário de:";
$menu2="Questionários de";
$menu3="Sessões do Questionário:";
}

if(isset($idiom) && $idiom=="16"){
$h1="Edition of Questionaries";
$h2="Welcome:";
$h3="Registered Questionaries";
$options="Options";
$registered="Registered";
$toview="View";
$toedit="Edit";
$new="To register a new questionary use the menu on your right!";
$insert="Registering a new questionary of";
$edit="Updating the already registered questionary of";
$menu1="Register a new questionary of:";
$menu2="Questionary of:";
$menu3="Sessions of the Questionary:";
}
   
?>
<html>
<head>
<title>:: ENSCER - Ensinando o c&eacute;rebro :: Assessoria</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="synapse.css" rel="stylesheet" type="text/css">
<script language="javascript">
<!--
function filtra(cod) {
  document.forms["questedita"].filtragem.value = cod;
}
//-->
</script>
<?php if(isset ($limpa) && $limpa==true){
	session_unregister('codQuestPai');
	session_unregister('qpainome');
	session_unregister('codQuest');
	session_unregister('questnome');
	session_unregister('codSec');
	session_unregister('secprox');
	session_unregister('pergcod');
	unset($codQuestPai);
	unset($codQuest);
	unset($codSec);
	unset($pergcod);
} 

if(isset ($limpaquest) && $limpaquest==true){
	session_unregister('codQuestPai');
	session_unregister('qpainome');
	session_unregister('codQuest');
	session_unregister('questnome');
	session_unregister('codSec');
	session_unregister('secnome');
	unset($qpainome);
	unset($codQuest);
	unset($codSec);
	unset($pergcod);
	//$codQuestPai=$codQpai;
}

if(isset ($limpasec) && $limpasec){
	session_unregister('codQuest');
	session_unregister('codSec');
	session_unregister('pergcod');
	//$questcod=$codQuest;
	unset($codSec);
	unset($pergcod);
}

if(isset ($limpaperg) && $limpaperg){
	session_unregister('codSec');
	session_unregister('secnome');
	session_unregister('pergcod');
	unset($pergcod);
	//$seccod=$codSec;
}
?>
</head>
<body>
<?php 
    ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
    include("includes/topo.php");
    ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
?>
<div id="col1">
<?php
	ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
    include("includes/menu.php");//?idiom=".$idiom."
    ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
?>
</div>
<div id="coltripla">

<form name="questedita" action="quest_edit.php" method="post">

<?php
	
	if(isset($filtragem) && $filtragem==1){
		
		$SQL2 = "UPDATE ALTERNATIVE SET VIS_REL=0 WHERE QUESTION='".$pergcod."';";
		$res2 = pg_query ($SQL2);
		$SQL3 = "UPDATE ALTERNATIVE SET VIS_QUEST=0 WHERE QUESTION='".$pergcod."';";
		$res3 = pg_query ($SQL3);

		foreach($atopcrel as $cod => $l){
			//echo "\$atopcrel[$cod] => $l.\n";
			ksort($l);
			foreach($l as $grp => $v){
				//echo "\$l[$grp] => $v";
				if($v!=""){
					$grvgrp = $grp;
					if(strpos($v,"atopcrel[".$cod."][".$grp."]")>0){
						$v=	substr($v,0,strpos($v,"atopcrel[".$cod."][".$grp."]"));
					}
					$grvgrp = str_replace("'","\"",$grvgrp);
					$SQL = "UPDATE ALTERNATIVE SET VIS_REL='".$v."' WHERE QUESTION='".$cod."' AND GROUPING='".$grp."';";
					$res=pg_query($SQL);
				}
			}
		}
		foreach($atopcquest as $cod => $v){
		//	ksort($v);
				if($v!=""){
					$SQL = "UPDATE ALTERNATIVE SET VIS_QUEST='".$v."' WHERE ALTERNATIVE='".$cod."';";
					$res=pg_query($SQL);
				}
		}
		foreach($atopcleg as $cod => $v){
		//	ksort($v);
				if($v!=""){
					$SQL = "UPDATE ALTERNATIVE SET LEGEND='".$v."' WHERE ALTERNATIVE='".$cod."';";
					$res=pg_query($SQL);
				}
		}
		foreach($atopcvalor as $cod => $v){
		//	ksort($v);
				if($v!=""){
					$SQL = "UPDATE ALTERNATIVE SET VALUE_INT='".$v."' WHERE ALTERNATIVE='".$cod."';";
					$res=pg_query($SQL);
				}
		}
		foreach($atopcseq as $cod => $v){
		//	ksort($v);
				if($v!=""){
					$SQL4 = "UPDATE ALTERNATIVE SET SEQ='".$v."' WHERE ALTERNATIVE='".$cod."';";
					$res=pg_query($SQL4);
				}
		}
	}
	
	if(isset($filtragem) && $filtragem==2){
		$SQL1 ="SELECT * FROM QUEST_FATHER_SEL(".$idiom.");"; //SELECT QUESTIONARY.* FROM QUESTIONARY WHERE QUEST_FATHER IS NULL
		$res1 = pg_query($SQL1);
		while($linha = pg_fetch_row($res1)){
			$SQL2 = "UPDATE QUESTIONARY SET VIS_REL=0 WHERE QUESTIONARY='".$linha[0]."';";
			$res2 = pg_query ($SQL2);
			$SQL3 = "UPDATE QUESTIONARY SET VIS_QUEST=0 WHERE QUESTIONARY='".$linha[0]."';";
			$res3 = pg_query ($SQL3);
		}
		foreach($atqpairel as $cod => $v){
		//	ksort($v);
				if($v!=""){
					$SQL = "UPDATE QUESTIONARY SET VIS_REL='".$v."' WHERE QUESTIONARY='".$cod."';";
					$res=pg_query($SQL);
				}
		}
		foreach($atqpaiquest as $cod => $v){
		//	ksort($v);
				if($v!=""){
					$SQL = "UPDATE QUESTIONARY SET VIS_QUEST='".$v."' WHERE QUESTIONARY='".$cod."';";
					$res=pg_query($SQL);
				}
		}
		foreach($atqpaiseq as $cod => $v){
		//	ksort($v);
				if($v!=""){
					$SQL4 = "UPDATE QUESTIONARY SET SEQ='".$v."' WHERE QUESTIONARY='".$cod."';";
					$res=pg_query($SQL4);
				}
		}
	}
	
	if(isset($filtragem) && $filtragem==3){
		//echo "qpaicod ".$qpaicod;
		$SQL1 ="SELECT * FROM QUESTIONARY_SEL(".$codQuestPai.", ".$idiom.");"; //SELECT QUESTIONARY.* FROM QUESTIONARY WHERE QUEST_FATHER=".$qpaicod."
		$res1 = pg_query($SQL1);
		while($linha = pg_fetch_row($res1)){
			$SQL2 = "UPDATE QUESTIONARY SET VIS_REL=0 WHERE QUESTIONARY='".$linha[0]."';";
			$res2 = pg_query ($SQL2);
			$SQL3 = "UPDATE QUESTIONARY SET VIS_QUEST=0 WHERE QUESTIONARY='".$linha[0]."';";
			$res3 = pg_query ($SQL3);
		}
		foreach($atquestrel as $cod => $v){
		//	ksort($v);
				if($v!=""){
					$SQL = "UPDATE QUESTIONARY SET VIS_REL='".$v."' WHERE QUESTIONARY='".$cod."';";
					$res=pg_query($SQL);
				}
		}
		foreach($atquestquest as $cod => $v){
		//	ksort($v);
				if($v!=""){
					$SQL = "UPDATE QUESTIONARY SET VIS_QUEST='".$v."' WHERE QUESTIONARY='".$cod."';";
					$res=pg_query($SQL);
				}
		}
		foreach($atquestseq as $cod => $v){
		//	ksort($v);
				if($v!=""){
					$SQL4 = "UPDATE QUESTIONARY SET SEQ='".$v."' WHERE QUESTIONARY='".$cod."';";
					$res=pg_query($SQL4);
				}
		}
	}
	
	if(isset($filtragem) && $filtragem==4){
		$SQL = "INSERT INTO QUESTIONARY (NAME, NAME_TYPE, VIS_REL, VIS_QUEST, SEQ) 
				VALUES (".$insertname.", '".$nametype."', -1, -1, ".$nvqpaiseq.") ";
		$res = pg_query($SQL);
	}
	
	if(isset($filtragem) && $filtragem==5){
		$SQL = "INSERT INTO QUESTIONARY (NAME, NAME_TYPE, SEQ, QUEST_FATHER, VIS_REL, VIS_QUEST) 
			    VALUES (".$insertname.", '".$nametype."', ".$nvquestseq.", ".$codQuestPai.", -1, -1) ";
		$res = pg_query($SQL);
	}

	if(isset($filtragem) && $filtragem==6){
		$SQL = "INSERT INTO SECTION (NAME, NAME_TYPE, QUESTIONARY, SEQ, VIS_QUEST, VIS_REL) 
				VALUES (".$insertname.", '".$nametype."', ".$codQuest.", ".$nvsecseq.", -1, -1) ";
		$res = pg_query($SQL);
	}
	
	if(isset($filtragem) && $filtragem==8){
		$SQL = "INSERT INTO QUESTION (NAME, NAME_TYPE, SECTION, SEQ, VIS_QUEST, VIS_REL) 
				VALUES (".$insertname.", '".$nametype."', ".$codSec.", ".$nvpergseq.", -1, -1);";
		$res = pg_query($SQL);
	}
	
	if(isset($filtragem) && $filtragem==10){
		$nvopcnome = isset($_POST['nvopcnome'])?$_POST['nvopcnome']:'';
		$nvopcgrupo = isset($_POST['nvopcgrupo'])?$_POST['nvopcgrupo']:'';
		$nvopctipo = isset($_POST['nvopctipo'])?$_POST['nvopctipo']:'';
		$nvopcpai = isset($_POST['nvopcpai'])?$_POST['nvopcpai']:'';
		$nvopcleg = isset($_POST['nvopcleg'])?$_POST['nvopcleg']:'';
		$nvopcvalor = isset($_POST['nvopcvalor'])?$_POST['nvopcvalor']:'';
		$nvopcseq = isset($_POST['nvopcseq'])?$_POST['nvopcseq']:'';

		if(isset($nvopcnome)){
			$SQL = "INSERT INTO ALTERNATIVE (QUESTION, NAME, NAME_TYPE, LEGEND, SEQ, KIND, OPTION_FATHER, VALUE_INT, GROUPING, VIS_QUEST, VIS_REL) 
					VALUES (".$pergcod.", ".$insertname.", '".$nametype."', '".$nvopcleg."', ".$nvopcseq.", '".$nvopctipo."', ".$nvopcpai.", ".$nvopcvalor.", ".$nvopcgrupo.", -1, -1);";
			$res = pg_query($SQL);
		}
	}
	
	if(isset($filtragem) && $filtragem==7){
	$SQL1 ="SELECT * FROM SECTION_SEL(".$codQuest.", ".$idiom.");"; //SELECT SECTION.* FROM SECTION WHERE QUESTIONARY=".$codQuest."
		$res1 = pg_query($SQL1);
		while($linha = pg_fetch_row($res1)){
		
	$SQLs1 = "UPDATE SECTION SET VIS_REL=0 WHERE QUESTIONARY=".$codQuest.";";
	$ress1 = pg_query ($SQLs1);
	$SQLs2 = "UPDATE SECTION SET VIS_QUEST=0 WHERE QUESTIONARY=".$codQuest.";";
	$ress2 = pg_query ($SQLs2);
		}
	if($atsecrel){
	foreach($atsecrel as $cod => $v){
		//	ksort($v);
				if($v!=""){
					$SQL = "UPDATE SECTION SET VIS_REL='".$v."' WHERE SECTION='".$cod."';";
					$res=pg_query($SQL);
				}
	}
	}
	if($atsecquest){
	foreach($atsecquest as $cod => $v){
		//	ksort($v);
				if($v!=""){
					$SQL = "UPDATE SECTION SET VIS_QUEST='".$v."' WHERE SECTION='".$cod."';";
					$res=pg_query($SQL);
				}
	}
	}
	foreach($atsecseq as $cod => $v){
		//	ksort($v);
				if($v!=""){
					$SQL4 = "UPDATE SECTION SET SEQ='".$v."' WHERE SECTION='".$cod."';";
					$res=pg_query($SQL4);
				}
		}
}

	if(isset($filtragem) && $filtragem==9){
	$SQL1 ="SELECT * FROM QUESTION_SEL(".$codSec.", ".$idiom.");"; //SELECT QUESTION.* FROM QUESTION WHERE SECTION=".$codSec."
		$res1 = pg_query($SQL1);
		while($linha = pg_fetch_row($res1)){
		
	$SQLs1 = "UPDATE QUESTION SET VIS_REL=0 WHERE SECTION=".$codSec.";";
	$ress1 = pg_query ($SQLs1);
	$SQLs2 = "UPDATE QUESTION SET VIS_QUEST=0 WHERE SECTION=".$codSec.";";
	$ress2 = pg_query ($SQLs2);
		}
	if($atpergrel){
	foreach($atpergrel as $cod => $v){
		//	ksort($v);
				if($v!=""){
					$SQL = "UPDATE QUESTION SET VIS_REL='".$v."' WHERE QUESTION='".$cod."';";
					$res=pg_query($SQL);
				}
	}
	}
	if($atpergquest){
	foreach($atpergquest as $cod => $v){
		//	ksort($v);
				if($v!=""){
					$SQL = "UPDATE QUESTION SET VIS_QUEST='".$v."' WHERE QUESTION='".$cod."';";
					$res=pg_query($SQL);
				}
	}
	}
	foreach($atpergseq as $cod => $v){
		//	ksort($v);
				if($v!=""){
					$SQL4 = "UPDATE QUESTION SET SEQ='".$v."' WHERE QUESTION='".$cod."';";
					$res=pg_query($SQL4);
				}
		}
}

	if((!isset ($codQuestPai)) && (!isset ($codQuest)) && (!isset ($codSec))){
		echo "<h1>Edição de Questionários</h1>";				
		
		echo "<h2>Escolha um Tópico</h2><hr>";
		
		if(!isset($codname)){
			echo "<h3>Criar um novo Tópico <input type='text' name='name'>
					Word <input type='radio' name='radio_name' value='radio_word'> 
					Compound <input type='radio' name='radio_name' value='radio_compound'> 
					Phrase <input type='radio' name='radio_name' value='radio_phrase'>
					<input type='hidden' name='limpa' value='true'>
					<input type='image' name='imgEnviar' src='images/enviar.gif' alt='Enviar' onClick=filtra(11)></h3>";

			if((isset ($filtragem) && $filtragem==11) && (isset($name))){
			
				$name = strtolower($name);
			
				if (isset($radio_name) && $radio_name=="radio_phrase"){
					$SQL = "SELECT PHRASE, NAME FROM PHRASE WHERE lower(NAME) LIKE '%".$name."%'";
					$res = pg_query($SQL);
					while($linha = pg_fetch_row($res)){
						echo "<p><a href='quest_edit.php?limpa=true&codname=".$linha[0]."&questname=".$linha[1]."&nametype=PHRASE'>".$linha[1]."</a></p>";
					}
					echo "<p><a href='#' onclick=\"javascript:window.open('phrase_ins.php','',',,,width=450,height=150')\">Inserir</a> nova frase.</p>";
				}elseif(isset($radio_name) && $radio_name=="radio_compound"){
					$SQL = "SELECT WORD_COMPOUND, NAME FROM WORD_COMPOUND WHERE lower(NAME) LIKE '%".$name."%'";
					$res = pg_query($SQL);
					while($linha = pg_fetch_row($res)){
						echo "<p><a href='quest_edit.php?limpa=true&codname=".$linha[0]."&questname=".$linha[1]."&nametype=COMPOUND'>".$linha[1]."</a></p>";
					}
					echo "<p><a href='#' onclick=\"javascript:window.open('compound_ins.php','',',,,width=450,height=150')\">Inserir</a> novo nome.</p>";
				}elseif(isset($radio_name) && $radio_name=="radio_word"){
					$SQL = "SELECT WORD, NAME FROM WORD WHERE lower(NAME) LIKE '%".$name."%'";
					$res = pg_query($SQL);
					while($linha = pg_fetch_row($res)){
						echo "<p><a href='quest_edit.php?limpa=true&codname=".$linha[0]."&questname=".$linha[1]."&nametype=WORD'>".$linha[1]."</a></p>";
					}
					echo "<p><a href='#' onclick=\"javascript:window.open('word_ins.php','',',,,width=450,height=150')\">Inserir</a> nova palavra.</p>";
				}
			}
			echo "<hr>";
		
		}else{
			echo "<h3>Criar um novo Tópico: ".(isset($questname)?$questname:'')."				  
					  Sequência: <input type='text' size='1' name='nvqpaiseq'>
					  <input type='image' name='imgGravar' src='images/gravar.gif' alt='Gravar' onClick=filtra(4)></h3><hr>";
			echo "<input type='hidden' name='insertname' value='".$codname."'>";
			echo "<input type='hidden' name='nametype' value='".$nametype."'>";						
		}
		
		echo "<table><tr><td><h3>Nome</h3></td><td><h3>Rel</h3></td><td><h3>Quest</h3></td><td><h3>Seq</h3></td></tr>";
		
		$SQL = "SELECT * FROM QUEST_FATHER_SEL(".$idiom.");";
		$res = pg_query($SQL);
		
		while($linha = pg_fetch_row($res)){
			$qpaivisiquest=$linha[6];
			$qpaivisirel=$linha[7];
			$qpaiseq=$linha[3];
			echo "<tr>";
			echo "<td><h3><a href=quest_edit.php?codQuestPai=".$linha[0]."&qpainome=".$linha[1].">".$linha[1]."</a></h3></td>";
			echo "<td><input type='checkbox' name='atqpairel[".$linha[0]."]' value='-1'  ".($qpaivisirel==1 || $qpaivisirel==-1?'checked':'')."></td>";
			echo "<td><input type='checkbox' name='atqpaiquest[".$linha[0]."]' value='-1'  ".($qpaivisiquest==1 || $qpaivisiquest==-1?'checked':'')."></td>";
			echo "<td><input type='text' size='1' name='atqpaiseq[".$linha[0]."]' value='".($qpaiseq!=""?$qpaiseq:'')."'></td>";
			echo "</tr>";
		}
		
		echo "</table>";
		echo '<h3><input name="imgAtualizar" id="botaoatua" type="image" title=" Atualizar " src="images/atualizar.gif" alt="Atualizar" width="60" height="18" border="0" onClick=filtra(2)></h3>';		
	}

	if((isset($codQuestPai) && $codQuestPai>0) && ((!isset($codQuest)) && (!isset ($codSec)))){
		$SQL = "SELECT * FROM QUEST_FATHER1_SEL(".$codQuestPai.", ".$idiom.")";
		$res = pg_query($SQL);
		$linhaq=pg_fetch_row($res);
		$qpainome=$linhaq[1];

		echo "<h1>Edição de Questionários</h1>";
		echo "<h2>Questionários de ".$qpainome."</h2><hr>";
		
		if(!isset($codname)){
				echo "<h3>Criar um novo Questionário <input type='text' name='name'>
					Word <input type='radio' name='radio_name' value='radio_word'> 
					Compound <input type='radio' name='radio_name' value='radio_compound'> 
					Phrase <input type='radio' name='radio_name' value='radio_phrase'>
					<input type='hidden' name='limpaquest' value='true'>
					<input type='image' name='imgEnviar' src='images/enviar.gif' alt='Enviar' onClick=filtra(11)></h3>";

			if((isset ($filtragem) && $filtragem==11) && (isset($name))){
			
				$name = strtolower($name);
			
				if (isset($radio_name) && $radio_name=="radio_phrase"){
					$SQL = "SELECT PHRASE, NAME FROM PHRASE WHERE lower(NAME) LIKE '%".$name."%'";
					$res = pg_query($SQL);
					while($linha = pg_fetch_row($res)){
						echo "<p><a href='quest_edit.php?limpaquest=true&codname=".$linha[0]."&questname=".$linha[1]."&nametype=PHRASE'>".$linha[1]."</a></p>";
					}
					echo "<p><a href='#' onclick=\"javascript:window.open('phrase_ins.php','',',,,width=450,height=150')\">Inserir</a> nova frase.</p>";
				}elseif(isset($radio_name) && $radio_name=="radio_compound"){
					$SQL = "SELECT WORD_COMPOUND, NAME FROM WORD_COMPOUND WHERE lower(NAME) LIKE '%".$name."%'";
					$res = pg_query($SQL);
					while($linha = pg_fetch_row($res)){
						echo "<p><a href='quest_edit.php?limpaquest=true&codname=".$linha[0]."&questname=".$linha[1]."&nametype=COMPOUND'>".$linha[1]."</a></p>";
					}
					echo "<p><a href='#' onclick=\"javascript:window.open('compound_ins.php','',',,,width=450,height=150')\">Inserir</a> novo nome.</p>";
				}elseif(isset($radio_name) && $radio_name=="radio_word"){
					$SQL = "SELECT WORD, NAME FROM WORD WHERE lower(NAME) LIKE '%".$name."%'";
					$res = pg_query($SQL);
					while($linha = pg_fetch_row($res)){
						echo "<p><a href='quest_edit.php?limpaquest=true&codname=".$linha[0]."&questname=".$linha[1]."&nametype=WORD'>".$linha[1]."</a></p>";
					}
					echo "<p><a href='#' onclick=\"javascript:window.open('word_ins.php','',',,,width=450,height=150')\">Inserir</a> nova palavra.</p>";
				}
			}
			echo "<hr>";
		
		}else{
			echo "<h3>Criar um novo Questionário: ".(isset($questname)?$questname:'')."				  
					  Sequência: <input type='text' size='1' name='nvquestseq'>
					  <input type='image' name='imgGravar' src='images/gravar.gif' alt='Gravar' onClick=filtra(5)></h3><hr>";
			echo "<input type='hidden' name='insertname' value='".$codname."'>";
			echo "<input type='hidden' name='nametype' value='".$nametype."'>";
			echo "<input type='hidden' name='codQuestPai' value='".$codQuestPai."'>";						
		}		

		session_register('qpainome');
		session_register('codQuestPai');

		$SQL = "SELECT * FROM QUESTIONARY_SEL(".$codQuestPai.", ".$idiom.")";
		$res = pg_query($SQL);
		
		echo "<h3>Escolha um Questionário</h3>";
		echo "<table><tr><td><h3>Nome</h3></td><td><h3>Rel</h3></td><td><h3>Quest</h3></td><td><h3>Seq</h3></td></tr>";

		while($linha=pg_fetch_row($res)){
			$questvisiquest=$linha[6];
			$questvisirel=$linha[7];
			$questseq=$linha[3];
			echo "<tr>";			
			echo "<td><h3><a href=quest_edit.php?codQuest=".$linha[0]."&questnome=".$linha[1].">".$linha[1]."</a></h3></td>";
			echo "<td><input type='checkbox' name='atquestrel[".$linha[0]."]' value='-1'  ".($questvisirel==1 || $questvisirel==-1?'checked':'')."></td>";
			echo "<td><input type='checkbox' name='atquestquest[".$linha[0]."]' value='-1'  ".($questvisiquest==1 || $questvisiquest==-1?'checked':'')."></td>";
			echo "<td><input type='text' size='1' name='atquestseq[".$linha[0]."]' value='".($questseq!=""?$questseq:'')."'></td>";
			echo "</tr>";
		}
		echo "</table>";
		echo '<h3><input name="imgAtualizar" id="botaoatua" type="image" title=" Atualizar " src="images/atualizar.gif" alt="Atualizar" width="60" height="18" border="0" onClick=filtra(3)></h3>';
	}
	
	if((isset($codQuest) && $codQuest>0) && (!isset($codSec))){
		echo "<h1>Edição de Questionários de " . $qpainome."</h1>";
    
			 $SQL = "SELECT * FROM SECTION_SEL(".$codQuest.", ".$idiom.")"; 
	  	     $sec=pg_query($SQL);
	  	     
			 echo "<h2>Questionário: ". $questnome ."</h2>";
			 echo "<hr>";
			 
			 if(!isset($codname)){
				echo "<h3>Criar uma nova Sessão <input type='text' name='name'>
					Word <input type='radio' name='radio_name' value='radio_word'> 
					Compound <input type='radio' name='radio_name' value='radio_compound'> 
					Phrase <input type='radio' name='radio_name' value='radio_phrase'>
					<input type='hidden' name='limpasec' value='true'>
					<input type='hidden' name='codQuest' value='".$codQuest."'>
					<input type='hidden' name='questnome' value='".$questnome."'>
					<input type='image' name='imgEnviar' src='images/enviar.gif' alt='Enviar' onClick=filtra(11)></h3>";

			if((isset ($filtragem) && $filtragem==11) && (isset($name))){
			
				$name = strtolower($name);
			
				if (isset($radio_name) && $radio_name=="radio_phrase"){
					$SQL = "SELECT PHRASE, NAME FROM PHRASE WHERE lower(NAME) LIKE '%".$name."%'";
					$res = pg_query($SQL);
					while($linha = pg_fetch_row($res)){
						echo "<p><a href='quest_edit.php?limpasec=true&codQuest=".$codQuest."&questnome=".$questnome."&codname=".$linha[0]."&secname=".$linha[1]."&nametype=PHRASE'>".$linha[1]."</a></p>";
					}
					echo "<p><a href='#' onclick=\"javascript:window.open('phrase_ins.php','',',,,width=450,height=150')\">Inserir</a> nova frase.</p>";
				}elseif(isset($radio_name) && $radio_name=="radio_compound"){
					$SQL = "SELECT WORD_COMPOUND, NAME FROM WORD_COMPOUND WHERE lower(NAME) LIKE '%".$name."%'";
					$res = pg_query($SQL);
					while($linha = pg_fetch_row($res)){
						echo "<p><a href='quest_edit.php?limpasec=true&codQuest=".$codQuest."&questnome=".$questnome."&codname=".$linha[0]."&secname=".$linha[1]."&nametype=COMPOUND'>".$linha[1]."</a></p>";
					}
					echo "<p><a href='#' onclick=\"javascript:window.open('compound_ins.php','',',,,width=450,height=150')\">Inserir</a> novo nome.</p>";
				}elseif(isset($radio_name) && $radio_name=="radio_word"){
					$SQL = "SELECT WORD, NAME FROM WORD WHERE lower(NAME) LIKE '%".$name."%'";
					$res = pg_query($SQL);
					while($linha = pg_fetch_row($res)){
						echo "<p><a href='quest_edit.php?limpasec=true&codQuest=".$codQuest."&questnome=".$questnome."&codname=".$linha[0]."&secname=".$linha[1]."&nametype=WORD'>".$linha[1]."</a></p>";
					}
					echo "<p><a href='#' onclick=\"javascript:window.open('word_ins.php','',',,,width=450,height=150')\">Inserir</a> nova palavra.</p>";
				}
			}
			echo "<hr>";
		
		}else{
			echo "<h3>Criar uma nova Sessão: ".(isset($secname)?$secname:'')."				  
					  Sequência: <input type='text' size='1' name='nvsecseq'>
					  <input type='image' name='imgGravar' src='images/gravar.gif' alt='Gravar' onClick=filtra(6)></h3><hr>";
			echo "<input type='hidden' name='insertname' value='".$codname."'>";
			echo "<input type='hidden' name='nametype' value='".$nametype."'>";
			echo "<input type='hidden' name='codQuest' value='".$codQuest."'>";
			echo "<input type='hidden' name='questnome' value='".$questnome."'>";
		}
			 			 
			 echo "<h3>Escolha uma Sessão do Questionário</H3>";
			 echo "<table><tr><td><h3>Nome</h3></td><td><h3>Rel</h3></td><td><h3>Quest</h3></td><td><h3>Seq</h3></td></tr>";
		
			while($linha=pg_fetch_row($sec)){
			
				$secvisiquest=$linha[4];
				$secvisirel=$linha[5];
				$secseq=$linha[3];
				$secnome=$linha[1];

				echo "<tr>";
				echo "<td><h3><a href=quest_edit.php?codSec=".$linha[0]."&secnome=".$secnome."&codQuest=".$codQuest."&questnome=".$questnome.">".$secnome."</a></h3></td>";
				echo "<td><input type='checkbox' name='atsecrel[".$linha[0]."]' value='-1'  ".($secvisirel==1 || $secvisirel==-1?'checked':'')."></td>";
				echo "<td><input type='checkbox' name='atsecquest[".$linha[0]."]' value='-1'  ".($secvisiquest==1 || $secvisiquest==-1?'checked':'')."></td>";
				echo "<td><input type='text' size='1' name='atsecseq[".$linha[0]."]' value='".($secseq!=""?$secseq:'')."'>Sequência</td>";
				echo "</tr>";
			}
		echo "</table>";
		echo '<h3><input name="imgAtualizar" id="botaoatua" type="image" title=" Atualizar " src="images/atualizar.gif" alt="Atualizar" width="60" height="18" border="0" onClick=filtra(7)></h3>';
	}
	
	if((isset($codSec) && $codSec>0) && (!isset($pergcod))){
	
		$SQL = "SELECT * FROM QUESTION_SEL(".$codSec.", ".$idiom.")";

		$perg=pg_query($SQL);
		$secn=pg_query($SQL);
		$lsecn=pg_fetch_row($secn);
		session_register('codSec');
		echo "<h1>Edição de Questionários de " . $qpainome."</h1>";
		echo "<h2>Questionário: ". $questnome ."</h2>";
		echo "<h3>Sessão: ". $secnome."</h3><hr>";
				
		if(!isset($codname)){
			echo "<h3>Criar uma nova Questão <input type='text' name='name'>
			Word <input type='radio' name='radio_name' value='radio_word'> 
			Compound <input type='radio' name='radio_name' value='radio_compound'> 
			Phrase <input type='radio' name='radio_name' value='radio_phrase'>
			<input type='hidden' name='limpaperg' value='true'>
			<input type='hidden' name='codQuest' value='".$codQuest."'>
			<input type='hidden' name='questnome' value='".$questnome."'>
			<input type='hidden' name='codSec' value='".$codSec."'>
			<input type='hidden' name='secnome' value='".$secnome."'>
			<input type='image' name='imgEnviar' src='images/enviar.gif' alt='Enviar' onClick=filtra(11)></h3>";

			if((isset ($filtragem) && $filtragem==11) && (isset($name))){
			
				$name = strtolower($name);
			
				if (isset($radio_name) && $radio_name=="radio_phrase"){
					$SQL = "SELECT PHRASE, NAME FROM PHRASE WHERE lower(NAME) LIKE '%".$name."%'";
					$res = pg_query($SQL);
					while($linha = pg_fetch_row($res)){
						echo "<p><a href='quest_edit.php?limpaperg=true&codQuest=".$codQuest."&questnome=".$questnome."&codSec=".$codSec."&secnome=".$secnome."&codname=".$linha[0]."&pergname=".$linha[1]."&nametype=PHRASE'>".$linha[1]."</a></p>";
					}
					echo "<p><a href='#' onclick=\"javascript:window.open('phrase_ins.php','',',,,width=450,height=150')\">Inserir</a> nova frase.</p>";
				}elseif(isset($radio_name) && $radio_name=="radio_compound"){
					$SQL = "SELECT WORD_COMPOUND, NAME FROM WORD_COMPOUND WHERE lower(NAME) LIKE '%".$name."%'";
					$res = pg_query($SQL);
					while($linha = pg_fetch_row($res)){
						echo "<p><a href='quest_edit.php?limpaperg=true&codQuest=".$codQuest."&questnome=".$questnome."&codSec=".$codSec."&secnome=".$secnome."&codname=".$linha[0]."&pergname=".$linha[1]."&nametype=COMPOUND'>".$linha[1]."</a></p>";
					}
					echo "<p><a href='#' onclick=\"javascript:window.open('compound_ins.php','',',,,width=450,height=150')\">Inserir</a> novo nome.</p>";
				}elseif(isset($radio_name) && $radio_name=="radio_word"){
					$SQL = "SELECT WORD, NAME FROM WORD WHERE lower(NAME) LIKE '%".$name."%'";
					$res = pg_query($SQL);
					while($linha = pg_fetch_row($res)){
						echo "<p><a href='quest_edit.php?limpaperg=true&codQuest=".$codQuest."&questnome=".$questnome."&codSec=".$codSec."&secnome=".$secnome."&codname=".$linha[0]."&pergname=".$linha[1]."&nametype=WORD'>".$linha[1]."</a></p>";
					}
					echo "<p><a href='#' onclick=\"javascript:window.open('word_ins.php','',',,,width=450,height=150')\">Inserir</a> nova palavra.</p>";
				}
			}
			echo "<hr>";
		
		}else{
			echo "<h3>Criar uma nova Questão: ".(isset($pergname)?$pergname:'')."				  
					  Sequência: <input type='text' size='1' name='nvpergseq'>
					  <input type='image' name='imgGravar' src='images/gravar.gif' alt='Gravar' onClick=filtra(8)></h3><hr>";
			echo "<input type='hidden' name='insertname' value='".$codname."'>";
			echo "<input type='hidden' name='nametype' value='".$nametype."'>";
			echo "<input type='hidden' name='codQuest' value='".$codQuest."'>";
			echo "<input type='hidden' name='questnome' value='".$questnome."'>";
			echo "<input type='hidden' name='codSec' value='".$codSec."'>";
			echo "<input type='hidden' name='secnome' value='".$secnome."'>";
		}
			    
			    echo "<h3>Escolha uma Questão da Sessão</h3>";
			    echo "<table><tr><td><h3>Nome</h3></td><td><h3>Rel</h3></td><td><h3>Quest</h3></td><td><h3>Seq</h3></td></tr>";
				  
				while($p=pg_fetch_row($perg)){
			        $pergnome=$p[1];
			        $pergseq=$p[3];					
			        $pergvisiquest = $p[5];
			    	$pergvisirel = $p[5];
				 	echo "<tr>";
					echo "<td><h3><a href=quest_edit.php?pergcod=".$p[0]."&pergnome=".$pergnome."&codQuest=".$codQuest."&questnome=".$questnome."&codSec=".$codSec."&secnome=".$secnome.">".$pergseq."-".$pergnome."</a></h3></td>";
				 	echo "<td><input type='checkbox' name='atpergrel[".$p[0]."]' value='-1'  ".($pergvisirel==1 || $pergvisirel==-1?'checked':'')."></td>";
					echo "<td><input type='checkbox' name='atpergquest[".$p[0]."]' value='-1'  ".($pergvisiquest==1 || $pergvisiquest==-1?'checked':'')."></td>";     		  		echo "<td><input type='text' size='1' name='atpergseq[".$p[0]."]' value='".($pergseq!=""?$pergseq:'')."'>Sequência</td>";
			  		echo "</tr>";
			 	}
				
				echo "</table>";
				echo '<h3><input name="imgAtualizar" id="botaoatua" type="image" title=" Atualizar " src="images/atualizar.gif" alt="Atualizar" width="60" height="18" border="0" onClick=filtra(9)></h3>';
	}
			
	if(isset($pergcod) && $pergcod>0){
		session_register('pergcod');
					
		$SQL = "SELECT * FROM ALTERNATIVE_SEL(".$pergcod.", ".$idiom.")";
							   
		$opc=pg_query($SQL);			        
		$linha = pg_fetch_row(pg_query($SQL));
					   
		$opccod=$linha[0];
		$opcpai=$linha[7];
				     
		if($opcpai==""){
			$visible=true;
			           
			$SQL1 = "SELECT ALTERNATIVE.*
					 FROM ALTERNATIVE
					 WHERE OPTION_FATHER is null";
			$opc1=pg_query($SQL1); 
			$count1 = 0;
			while ($row[$count1] = pg_fetch_assoc($opc1)){
				$count1++;
			}
							
		}elseif($count1>0){
			$visible=true;
								
			$SQL2 = "SELECT ALTERNATIVE.*
					 FROM ALTERNATIVE
					 WHERE OPTION_FATHER like '%%' ";
			$opc2=pg_query($SQL2);
			$count2 = 0;
			while ($row[$count2] = pg_fetch_assoc($opc2)){
				$count2++;
			}
								
		}elseif($count2>0 && $checked==true){
			$visible=true;
		}else{
			$visible=false;
		}
			           
		$grp = -1;
		$pri=0;

		echo "<h1>Edição de Questionários de " . $qpainome."</h1>";
		echo "<h2>Questionário: ". $questnome ."</h2>";
		echo "<h3>Sessão: ". $secnome."</h3><hr>";
		
		if(!isset($codname)){
			echo "<h3>Criar uma nova Opção <input type='text' name='name'>
			Word <input type='radio' name='radio_name' value='radio_word'> 
			Compound <input type='radio' name='radio_name' value='radio_compound'> 
			Phrase <input type='radio' name='radio_name' value='radio_phrase'>
			<input type='hidden' name='codQuest' value='".$codQuest."'>
			<input type='hidden' name='questnome' value='".$questnome."'>
			<input type='hidden' name='codSec' value='".$codSec."'>
			<input type='hidden' name='secnome' value='".$secnome."'>
			<input type='hidden' name='pergcod' value='".$pergcod."'>
			<input type='hidden' name='pergnome' value='".$pergnome."'>
			<input type='image' name='imgEnviar' src='images/enviar.gif' alt='Enviar' onClick=filtra(11)></h3>";

			if((isset ($filtragem) && $filtragem==11) && (isset($name))){
				
				$name = strtolower($name);
			
				if (isset($radio_name) && $radio_name=="radio_phrase"){
					$SQL = "SELECT PHRASE, NAME FROM PHRASE WHERE lower(NAME) LIKE '%".$name."%'";
					$res = pg_query($SQL);
					while($linha = pg_fetch_row($res)){
						echo "<p><a href='quest_edit.php?codQuest=".$codQuest."&questnome=".$questnome."&codSec=".$codSec."&secnome=".$secnome."&pergcod=".$pergcod."&pergnome=".$pergnome."&codname=".$linha[0]."&opcname=".$linha[1]."&nametype=PHRASE'>".$linha[1]."</a></p>";
					}
					echo "<p><a href='#' onclick=\"javascript:window.open('phrase_ins.php','',',,,width=450,height=150')\">Inserir</a> nova frase.</p>";
				}elseif(isset($radio_name) && $radio_name=="radio_compound"){
					$SQL = "SELECT WORD_COMPOUND, NAME FROM WORD_COMPOUND WHERE lower(NAME) LIKE '%".$name."%'";
					$res = pg_query($SQL);
					while($linha = pg_fetch_row($res)){
						echo "<p><a href='quest_edit.php?codQuest=".$codQuest."&questnome=".$questnome."&codSec=".$codSec."&secnome=".$secnome."&pergcod=".$pergcod."&pergnome=".$pergnome."&codname=".$linha[0]."&opcname=".$linha[1]."&nametype=COMPOUND'>".$linha[1]."</a></p>";
					}
					echo "<p><a href='#' onclick=\"javascript:window.open('compound_ins.php','',',,,width=450,height=150')\">Inserir</a> novo nome.</p>";
				}elseif(isset($radio_name) && $radio_name=="radio_word"){
					$SQL = "SELECT WORD, NAME FROM WORD WHERE lower(NAME) LIKE '%".$name."%'";
					$res = pg_query($SQL);
					while($linha = pg_fetch_row($res)){
						echo "<p><a href='quest_edit.php?codQuest=".$codQuest."&questnome=".$questnome."&codSec=".$codSec."&secnome=".$secnome."&pergcod=".$pergcod."&pergnome=".$pergnome."&codname=".$linha[0]."&opcname=".$linha[1]."&nametype=WORD'>".$linha[1]."</a></p>";
					}
					echo "<p><a href='#' onclick=\"javascript:window.open('word_ins.php','',',,,width=450,height=150')\">Inserir</a> nova palavra.</p>";
				}
			}
			echo "<hr>";
		
		}else{
			echo "<h3>Criar uma nova Opção: ".(isset($opcname)?$opcname:'');
			echo "&nbsp&nbspGrupo: <input type='text' size='1' name='nvopcgrupo' value='0'>";
			echo "&nbsp&nbspTipo: <select name='nvopctipo'><option value=NULL></option><option value=label>Label</option><option value=radio>Radio</option><option value=checkbox>Checkbox</option><option value=text>Texto</option><option value=textarea>Area</option></select><br>";
			echo "OpcPai: <select name='nvopcpai'>";
			echo "<option value='NULL'></option>\n";
					  
			$SQL = "SELECT A.*, Q.NAME, Q.SEQ 
					FROM ALTERNATIVE A 
							LEFT JOIN QUESTION Q ON A.QUESTION=Q.QUESTION
					WHERE (((A.QUESTION)=".$pergcod.")) 
					ORDER BY A.SEQ";
							   
			$opcpai=pg_query($SQL);
			while($opai=pg_fetch_row($opcpai)){						
				echo "<option value=" . $opai[0] .">".$opai[0]."</option>\n";
			}
							
			echo "</select>";
			echo "&nbsp&nbspLegenda: <input type='text' maxlength='8' size='7' name='nvopcleg'>";
			echo "&nbsp&nbspValor: <input type='text' size='1' name='nvopcvalor' value='0'>";
			echo "&nbsp&nbspSequência: <input type='text' size='1' name='nvopcseq'>";
			echo "<input type='hidden' name='insertname' value='".$codname."'>";
			echo "<input type='hidden' name='nametype' value='".$nametype."'>";
			echo "<input type='hidden' name='codQuest' value='".$codQuest."'>";
			echo "<input type='hidden' name='questnome' value='".$questnome."'>";
			echo "<input type='hidden' name='codSec' value='".$codSec."'>";
			echo "<input type='hidden' name='secnome' value='".$secnome."'>";
			echo "<input type='hidden' name='pergcod' value='".$pergcod."'>";
			echo "<input type='hidden' name='pergnome' value='".$pergnome."'>";
			echo "&nbsp&nbsp<input type='image' name='imgGravar' src='images/gravar.gif' alt='Gravar' onClick=filtra(10)></h3><hr>";
		}

		echo "<h2>Questão ".$pergnome." - ".$pergcod."</h2>";
			   
		echo "<table width='99%'>";
		echo "<tr><td width='10%'><h3>Cod</h3></td><td width='5%'><h3>Gr</h3></td><td width='40%'><h3>Opção</h3></td><td><h3>Pai</h3></td><td width='5%'><h3>Rel</h3></td><td width='5%'><h3>Que</h3></td><td width='15%'><h3>Legenda</h3></td><td width='10%'><h3>Valor</h3></td><td width='10%'><h3>Seq</h3></td></tr>"; 
		while($o=pg_fetch_row($opc)){
		//Selecionar se tem pergunta cadastrada
			$opccod = $o[0];
			$opcnome = $o[1];
			$opcobs = $o[4];
			$opcseq = $o[5];
			$opctipo = $o[6];
			$opcpai = $o[7];
			$opcvalor = $o[8];
			$opcgrupo = $o[9];
			$opcvisirel = $o[11];
			$opcvisiquest = $o[10];
			$opcleg = $o[3];
			                
			if($opctipo=="label"){
																
				echo "<tr>";
							
			    echo "<td><b>".$opccod."</b></td><td></td><td><a href=# onclick=\"javascript:window.open('questalert.php?edita=true&opcnome=".$opcnome."&&opccod=".$opccod."','',',,,width=600,height=200')\"><label>".$opcnome."</label></a></td><td><b>".$opcpai."</b></td>";
							
			    echo "<td><input type='checkbox' name='atopcrel[".$pergcod."][".$opcgrupo."]' value='-1'  ".($opcvisirel==1 || $opcvisirel==-1?'checked':'')."></td>";
			    echo "<td><input type='checkbox' name='atopcquest[".$opccod."]' value='-1'  ".($opcvisiquest==1 || $opcvisiquest==-1?'checked':'')."></td>";
			    echo "<td><input type='text' size='7' maxlength='8' name='atopcleg[".$opccod."]' value='".($opcleg!=""?$opcleg:'')."'></td>";
			    echo "<td><input type='text' maxlength='3' size='2' name='atopcvalor[".$opccod."]' value='".($opcvalor!=""?$opcvalor:'')."'></td>";
			    echo "<td><input type='text' align='rigth' size='1' name='atopcseq[".$opccod."]' value='".($opcseq!=""?$opcseq:'')."'></td></tr>";
			                
			}else if($opctipo=="radio" || $opctipo=="checkbox"){
			                	
		    	if($grp!=$opcgrupo || $grp==-1){
		        	$grp=$opcgrupo;
		        }
		        echo "<tr>";
		        echo "<td><b>".$opccod."</b></td><td><b>".$opcgrupo."</b></td><td>&nbsp&nbsp&nbsp<input type=" . $opctipo . " readonly='true'>" . $opcnome . "</td><td><b>".$opcpai."</b></td>";
		        echo "<td><input type='checkbox' name='atopcrel[".$pergcod."][".$opcgrupo."]' value='-1'  ".($opcvisirel==1 || $opcvisirel==-1?'checked':'')."></td>";
		        echo "<td><input type='checkbox' name='atopcquest[".$opccod."]' value='-1'  ".($opcvisiquest==1 || $opcvisiquest==-1?'checked':'')."></td>";
		        echo "<td><input type='text' size='7' maxlength='8' name='atopcleg[".$opccod."]' value='".($opcleg!=""?$opcleg:'')."'></td>";
		        echo "<td><input type='text' maxlength='3' size='2' name='atopcvalor[".$opccod."]' value='".($opcvalor!=""?$opcvalor:'')."'></td>";
		        echo "<td><input type='text' size='1' name='atopcseq[".$opccod."]' value='".($opcseq!=""?$opcseq:'')."'></td></tr>";
		                   	    	
			}else if($opctipo=="text" || $opctipo==""){
				if($opcobs=="" && $opctipo=="text"){
			    	echo "<tr>";
			        echo "<td><b>".$opccod."</b></td><td><b>".$opcgrupo."</b></td><td>&nbsp&nbsp&nbsp". $opcnome ."&nbsp<input type='". $opctipo ."' size='2' readonly='true'></td><td><b>".$opcpai."</b></td>";
			        echo "<td><input type='checkbox' name='atopcrel[".$pergcod."][".$opcgrupo."]' value='-1'  ".($opcvisirel==1 || $opcvisirel==-1?'checked':'')."></td>";
		            echo "<td><input type='checkbox' name='atopcquest[".$opccod."]' value='-1'  ".($opcvisiquest==1 || $opcvisiquest==-1?'checked':'')."></td>";
		            echo "<td><input type='text' size='7' maxlength='8' name='atopcleg[".$opccod."]' value='".($opcleg!=""?$opcleg:'')."'></td>";
		            echo "<td><input type='text' maxlength='3' size='2' name='atopcvalor[".$opccod."]' value='".($opcvalor!=""?$opcvalor:'')."'></td>";
		            echo "<td><input type='text' size='1' name='atopcseq[".$opccod."]' value='".($opcseq!=""?$opcseq:'')."'></td></tr>";

				}else{
			    	$op1 = substr(stristr($opcobs,"|"), 1);
			    	$op2 = substr($opcobs,0,strpos($opcobs,"|"));
					
					if(($opcobs!="" && $opctipo=="text")){
			    		
						if(strtolower($op1)=="mês"){
			        		echo "<tr>";
				       		echo("<td><b>".$opccod."</b></td><td><b>".$opcgrupo."</b></td><td>&nbsp&nbsp". $op2 . '&nbsp&nbsp&nbsp&nbsp<input type="' . $opctipo . '" size=2>')."<td></td><b>".$opcpai."</b></td>";
			           		echo "<td><input type='checkbox' name='atopcrel[".$pergcod."][".$opcgrupo."]' value='-1'  ".($opcvisirel==1 || $opcvisirel==-1?'checked':'')."></td>";
			        		echo "<td><input type='checkbox' name='atopcquest[".$opccod."]' value='-1'  ".($opcvisiquest==1 || $opcvisiquest==-1?'checked':'')."></td>";
			            	echo "<td><input type='text' size='7' maxlength='8' name='atopcleg[".$opccod."]' value='".($opcleg!=""?$opcleg:'')."'></td>";
			            	echo "<td><input type='text' maxlength='3' size='2' name='atopcvalor[".$opccod."]' value='".($opcvalor!=""?$opcvalor:'')."'></td>";
			            	echo "<td><input type='text' size='1' name='atopcseq[".$o['opccod']."]' value='".($opcseq!=""?$opcseq:'')."'></td></tr>";
				                 		
				 		}elseif(strtoupper($op1)=="SEMANA"){
				 			echo "<tr>";
				            echo("<td><b>".$opccod."</b></td><td><b>".$opcgrupo."</b></td><td>&nbsp&nbsp". $op2 . '&nbsp&nbsp&nbsp&nbsp<input type="' . $opctipo . '" size=2>')."<td></td><b>".$opcpai."</b></td>";
				            echo "<td><input type='checkbox' name='atopcrel[".$pergcod."][".$opcgrupo."]' value='-1'  ".($opcvisirel==1 || $opcvisirel==-1?'checked':'')."></td>";
			            	echo "<td><input type='checkbox' name='atopcquest[".$opccod."]' value='-1'  ".($opcvisiquest==1 || $opcvisiquest==-1?'checked':'')."></td>";
			            	echo "<td><input type='text' size='7' maxlength='8' name='atopcleg[".$opccod."]' value='".($opcleg!=""?$opcleg:'')."'></td>";
			            	echo "<td><input type='text' maxlength='3' size='2' name='atopcvalor[".$opccod."]' value='".($opcvalor!=""?$opcvalor:'')."'></td>";
			            	echo "<td><input type='text' size='1' name='atopcseq[".$o['opccod']."]' value='".($opcseq!=""?$opcseq:'')."'></td></tr>";

			            }elseif(strtoupper($op1)=="GRAMAS"){
			                echo "<tr>";
				            echo("<td><b>".$opccod."</b></td><td><b>".$opcgrupo."</b></td><td>&nbsp&nbsp". $op2 . '&nbsp&nbsp&nbsp&nbsp<input type="' . $opctipo . '" size=2>')."<td></td><b>".$opcpai."</b></td>";
				            echo "<td><input type='checkbox' name='atopcrel[".$pergcod."][".$opcgrupo."]' value='-1'  ".($opcvisirel==1 || $opcvisirel==-1?'checked':'')."></td>";
			            	echo "<td><input type='checkbox' name='atopcquest[".$opccod."]' value='-1'  ".($opcvisiquest==1 || $opcvisiquest==-1?'checked':'')."></td>";
			            	echo "<td><input type='text' size='7' maxlength='8' name='atopcleg[".$opccod."]' value='".($opcleg!=""?$opcleg:'')."'></td>";
			            	echo "<td><input type='text' maxlength='3' size='2' name='atopcvalor[".$opccod."]' value='".($opcvalor!=""?$opcvalor:'')."'></td>";
			            	echo "<td><input type='text' size='1' name='atopcseq[".$o['opccod']."]' value='".($opcseq!=""?$opcseq:'')."'></td></tr>";

				        }
			        
					}elseif($opcobs=="" && $opctipo==""){ 
			        	echo "<tr>";
					    echo("<td><b>".$opccod."</b></td><td><b>".$opcgrupo."</b></td><td>&nbsp&nbspProx". $op1 . '&nbsp&nbsp&nbsp&nbsp<input type="' . $opctipo . '" size=3>')."</td><td><b>".$opcpai."</b></td>";
						echo "<td><input type='checkbox' name='atopcrel[".$pergcod."][".$opcgrupo."]' value='-1'  ".($opcvisirel==1 || $opcvisirel==-1?'checked':'')."></td>";
					    echo "<td><input type='checkbox' name='atopcquest[".$opccod."]' value='-1'  ".($opcvisiquest==1 || $opcvisiquest==-1?'checked':'')."></td>";
					    echo "<td><input type='text' size='7' maxlength='8' name='atopcleg[".$opccod."]' value='".($opcleg!=""?$opcleg:'')."'></td>";
					    echo "<td><input type='text' maxlength='3' size='2' name='atopcvalor[".$opccod."]' value='".($opcvalor!=""?$opcvalor:'')."'></td>";
					    echo "<td><input type='text' size='1' name='atopcseq[".$o['opccod']."]' value='".($opcseq!=""?$opcseq:'')."'></tr>";
			        }
				}
			}else if($opctipo=="textarea"){
		 		echo "<td><b>".$opccod."</b></td><td><b>".$opcgrupo."</b></td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp". $opcnome ."<center><textarea cols='42' rows='15'></textarea></center></td><td><b>".$opcpai."</b></td>";
		 		echo "<td><input type='checkbox' name='atopcrel[".$pergcod."][".$opcgrupo."]' value='-1'  ".($opcvisirel==1 || $opcvisirel==-1?'checked':'')."></td>";
	            echo "<td><input type='checkbox' name='atopcquest[".$opccod."]' value='-1'  ".($opcvisiquest==1 || $opcvisiquest==-1?'checked':'')."></td>";
	           echo "<td><input type='text' size='7' maxlength='8' name='atopcleg[".$opccod."]' value='".($opcleg!=""?$opcleg:'')."'></td>";	
	           echo "<td><input type='text' size='1' name='atopcseq[".$o['opccod']."]' value='".($opcseq!=""?$opcseq:'')."'></td></tr>";
	        }      			
		}
		echo "</table>";
		echo '<h3><input name="imgAtualizar" id="botaoatua" type="image" title=" Atualizar " src="images/atualizar.gif" alt="Atualizar" width="60" height="18" border="0" onClick=filtra(1)>';
		echo '<input name="imgAvancar" id="botaoavanca" type="image" title=" Avancar " src="images/avancar.gif" alt="Avançar" width="60" height="18" border="0" onClick=filtra(0)></h3>';
	}
			      
  	echo "<input type='hidden' name='filtragem'>";
	echo "</form>\n";
?>
</div>
<div id=col5>
<div id="menu2acesso">
  <ul>
  <strong>
  <?php
 		echo "<li class=titdest>Editar um Questionário de:</li>";
		$SQL = "SELECT * FROM QUEST_FATHER_SEL(".$idiom.");"; //SELECT QUESTIONARY, NAME FROM QUESTIONARY WHERE QUEST_FATHER IS NULL
		$res=pg_query($SQL);
		while($linha=pg_fetch_row($res)){
				echo "<li><a href=quest_edit.php?limpa=true&limpaquest=true&codQuestPai=".$linha[0].">".$linha[1]."</a></li>";
		}
?>
<li></li>
<?php	if(isset($codQuestPai) && $codQuestPai>0){
		echo "<li class=titdest>Questionários de ".$qpainome.":</li>";
		
		$SQL = "SELECT * FROM QUESTIONARY_SEL(".$codQuestPai.", ".$idiom.");";
		
		$res=pg_query($SQL);
		while($linha=pg_fetch_row($res)){
				echo "<li><a href=quest_edit.php?limpasec=true&codQuest=".$linha[0]."&questnome=".$linha[1].">".$linha[1]."</a></li>";
		}
	}
?>
<li></li>
  
<?php
	if(isset($codQuest) && $codQuest>0){
		echo "<li class=titdest>Sessões do Questionário ".$questnome.":</li>";

		$SQL = "SELECT * FROM SECTION_SEL(".$codQuest.", ".$idiom.");";
				
		$res=pg_query($SQL);
		while($linha=pg_fetch_row($res)){
				echo "<li><a href=quest_edit.php?limpaperg=true&codQuest=".$codQuest."&questnome=".$questnome."&codSec=".$linha[0]."&secnome=".$linha[1].">".$linha[1]."</a></li>";
		} 
	}
?>
</strong>
  </ul>
    </div>
</div>
<div id="base"><?php echo $base.date('Y');?> ::</div>
