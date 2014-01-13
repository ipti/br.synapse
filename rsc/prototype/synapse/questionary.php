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
$h1="Questionários";
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
$question="Questão";
$register="Gravar";
$update="Atualizar";
$forward="Avançar";
$realized="Realizado em:";
}

if(isset($idiom) && $idiom=="16"){
$h1="Questionaries";
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
$question="Question";
$register="Register";
$update="Update";
$forward="Forward";
$realized="Realized at:";
}

if(isset ($limpaquestpai) && $limpaquestpai==true){
unset($codQuestPai);
session_unregister('codQuest');
session_unregister('secprox');
session_unregister('UPDATE');
unset($codQuest);
unset($secprox);
unset($UPDATE);
}

if(isset ($limpaquest) && $limpaquest==true){
session_unregister('codQuest');
session_unregister('secprox');
session_unregister('UPDATE');
unset($codQuest);
unset($secprox);
unset($UPDATE);
}

if(isset ($limpasec) && $limpasec==true){
session_unregister('secprox');
$codSec=0;
}
     
?>

<script language="javascript"><!--
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
		if (document.forms["cadQuest"].filtragem.value!=1){
			
  		if (submitted == true) {
    		alert("Este formulário já foi enviado. Por favor pressione OK e aguarde o processo ser completado.");
    		return false;		
  		}
  		error = false;
  		form = form_name;
  		error_message = "Erros ocorreram durante o envio de seu formulário.\n\nPor favor, faça as seguintes correções:\n\n";

		check_input("txtDia", 1, "Informe o Dia em que o questionário foi aplicado");
  		check_input("txtMes", 1, "Informe o Mês em que o questionário foi aplicado");
  		check_input("txtAno", 1, "Informe o Ano em que o questionário foi aplicado");
		
  		if (error == true) {
    		alert(error_message);
    		return false;
  		} else {
    		submitted = true;
    		return true;
  		}
  		
  		//return false;
	//}
	}
}

function filtra(cod) {
  document.forms["cadQuest"].filtragem.value = cod;
  //window.alert(document.forms["cadQuest"].comp[45].value);
  //document.forms["cadQuest"].submit();
}
//-->
</script>

<html>
<head>
<title> :: ENSCER - Ensinando o c&eacute;rebro :: Assessoria </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="synapse.css" rel="stylesheet" type="text/css">
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
  <h1><?php echo $h1; ?></h1>
<?php 
	echo "<h2>".$h2.(isset($personagename)?$personagename:"").$personname."</h2>";
 	echo "<h3>".(isset($organizationname)?$organizationname:"").(isset($unityname)?" - ".$unityname:"")."</h3>";
	echo "<hr>";
		
if(!isset($codQuestPai) && !isset($arel)){

	$stmt="Select * from QUEST_FATHER_SEL(".$idiom.")"; 
	$query = pg_prepare($stmt);
	$perg = pg_execute($query);
	$rpai = pg_query($stmt);	
  	
	echo "<h3 align='center'>".$h3."</h3>";

  	while($lpai=pg_fetch_row($rpai)){
	
	$QuestPai = $lpai[0];
	
	if(isset($actor)){
	
		$stmt = "SELECT * FROM INTERVIEW_SEL(".$QuestPai.", ".$actor.", ".$idiom.")";
	
  		$res = pg_query($stmt);

  			echo "<table width='90%'>
	              <tr><td width='50%'><h3>".$lpai['1']."</h3></td>
					  <td width='30%'><h3>".$registered."</h3></td>
					  <td width='10%'><h3>".$options."</h3></td>
					  <td width='10%'></td></tr>";
			
  			while($linha=pg_fetch_row($res)){
  				echo "<tr><td>".$linha[1]."</a></td>
						  <td>".$linha[7]."</td>
						  <td><a href=# onclick=\"javascript:window.open('quest_view.php?anCod=".$linha[6]."&quResp=".$linha[10].  "','','menubar,scrollbars,resizable,width=790,height=600')\" class='link'>".$toview."</a></td><td>";

					if($linha[6]!="" && $linha[8]==$actor){
  						echo "<a href=questionary.php?arel=".$linha[6]."&codQuest=".$linha[10]."&questnome=".$linha[1]."&filtra=1 class='link'>".$toedit."</a>";
  					}
  				echo "</td></tr>";
			}
  			echo "</table><hr>";
  	}  	
	}
	echo "<h3>".$new."</h3>";

}

if(isset($codQuest)){

echo '<form name="cadQuest" action="quest_register.php" method="post" onSubmit="return check_form(cadQuest);">';

	if(isset($arel) && $arel>0){
		
		$SQL = "SELECT * FROM ANSWER WHERE INTERVIEW = ".$arel;
		$fanam = pg_query($SQL);
		while($l=pg_fetch_row($fanam)){
			$Resp[$l[3]][$l[4]]=$l[5];
		}
		
		$UPDATE = $arel;
		session_register('UPDATE');		
			
		$SQLq = "SELECT * FROM QUEST_FATHER_QUEST_SEL(".$codQuest.", ".$idiom.")";
		$resQ = pg_query($SQLq);
		$linhaq = pg_fetch_row($resQ);
		
		$questpainome = $linhaq[4];
		 
		$txt = "<font color='red'>".$edit." ".$questpainome.":</font>";
			
		$SQLa = "SELECT INTERVIEW_DATE FROM INTERVIEW WHERE INTERVIEW=".$arel;
		$ranam = pg_query($SQLa);
		$lanam = pg_fetch_row($ranam);
			list($alano, $almes, $aldia) = split("-",$lanam[0]);
		
	}else{
	
		$txt = "<font color='red'>".$insert." ".$questpainome.":</font>";
	}
	
	if(isset ($filtra) && $filtra==1){
		$secprox="";
	    session_unregister('UPDATE');
	    session_unregister('ANCOD');
	    session_unregister('alano');
	    session_unregister('almes');
	    session_unregister('aldia');
	    session_unregister('annome');
	}
			
	echo "<h3>" . $txt . "</h3>";
		
	if(isset($codSecMenu) && $codSecMenu>0){
	  	$SQL1 = "SELECT SEQ FROM SECTION WHERE SECTION=".$codSecMenu.";";
	  	$res1 = pg_query($SQL1);
	  	$lcod = pg_fetch_row($res1);
	  	$secprox=$lcod[0];
		session_register('secprox');
	}else{
		$secprox = $secprox+1;
		session_register('secprox');
	}

	$SQLc = "SELECT Q.QUESTIONARY, S.*
			 FROM (QUESTIONARY Q 
				  		LEFT JOIN SECTION S ON S.QUESTIONARY = Q.QUESTIONARY) 
			 WHERE ((Q.QUESTIONARY)=".$codQuest.") AND 
			       (((S.VIS_QUEST)=-1) or ((S.VIS_QUEST)=1)) AND
				   ((S.SEQ)=".$secprox.")";
	//echo "SQLc: ".$SQLc."<br>";
	$resc = pg_query($SQLc);
	$count = 0;

	while ($row[$count] = pg_fetch_assoc($resc)){
		$count++;
	}

	if($count>0){
					     
		$stmt="Select * from SECPROX_SEL(".$codQuest.", ".$secprox.", ".$idiom.")";
		$query = pg_prepare($stmt);
		$sec=pg_execute($query);
		$linha = pg_fetch_row(pg_query($stmt));
	 	$secnome = $linha[1];
		$codSec = $linha[0];
		//echo "stmt: ".$stmt."<br>";							  
		echo "<h2><center>".$questnome." - ".$secnome."</center></h2>\n";
		echo "<hr>";
				 
?>	  
<h3>
<?php echo $realized; ?> <input name="txtDia" type="text" id="txtDia" size="1" maxlength="2" <?php if(isset($aldia)){ echo " value='".$aldia."'";} ?>>
/ 
<input name="txtMes" type="text" id="txtMes" size="1" maxlength="2" <?php if(isset($almes)){ echo " value='".$almes."'";}  ?>>
/ 
<input name="txtAno" type="text" id="txtAno" size="2" maxlength="4" <?php if(isset($alano)){ echo " value='".$alano."'";}  ?>> 
</h3>    		        
<?php			
		$stmt="Select * from QUESTION_SEL(".$codSec.", ".$idiom.")"; 
		$query = pg_prepare($stmt);
		$perg = pg_execute($query);
		$res = pg_query($stmt);	
			  
			  while($p=pg_fetch_row($res)){
				
				   $pergcod = $p[0];
				   $pergdescricao = $p[1];
					   
				   $stmt="Select * from ALTERNATIVE_SEL(".$pergcod.", ".$idiom.")";
					   
				   $query = pg_prepare($stmt);
				   $opc=pg_execute($query);
				   $linha = pg_fetch_row(pg_query($stmt));
	
				   $opccod=$linha[0];
				   $opcpai=$linha[7];
								
				   echo "<hr><h3>".$question." " . $p[4] . "-" . $pergdescricao . "</h3>";
				   $grp = -1;
				   $pri=0;
				   while($o=pg_fetch_row($opc)){
						//Selecionar se tem pergunta cadastrada
						$opccod = $o[0];
						$opcnome = $o[1];
						$opcobs = $o[4];
						$opcsequencia = $o[5];
						$opctipo = $o[6];
						$opcpai = $o[7];
						$opcvalor = $o[8];
						$opcgrupo = $o[9];
								
						if($opctipo=="text" && stristr($opcobs,"|")!=""){
							$opcgrupo = $opcgrupo + 1;
						}
								
						if($opctipo=="label"){
								if($pri==0){
								$pri=1;
							}else{
								echo "<br>";
							}
						
							echo "<br>";
							echo "&nbsp&nbsp<a href=# onclick=\"javascript:window.open('questalert.php','',',,,width=600,height=200')\"><label>".$opcnome."</label></a>";
							echo "<br>";
							
						}else if($opctipo=="radio"){

							echo "\n";

							echo('&nbsp&nbsp&nbsp&nbsp&nbsp
								<input type="'.$opctipo.'" 
							   name="Perg['.$opctipo.']['.$pergcod.']['.$opcgrupo.']" 
							   value="'.$opcnome.'" '.(isset($Resp[$pergcod][$opcgrupo])?($Resp[$pergcod][$opcgrupo]==$opcnome?"checked":""):"").'> '.$opcnome);
	
						}else if($opctipo=="checkbox"){
									
							if($grp!=$opcgrupo || $grp==-1){
								 $grp=$opcgrupo;
										 
								 if($pri==0){
									$pri=1;
								 }else{
									echo "<br>";
								 }
										 
							}
							echo "\n";
							echo('&nbsp&nbsp&nbsp&nbsp&nbsp<input type="'.$opctipo.'" name="Perg['.$opccod.']['.$pergcod.']['.$opcgrupo.']" id="" value="'.$opcnome.'" '.(isset($Resp[$pergcod][$opcgrupo])?($Resp[$pergcod][$opcgrupo]==$opcnome?"checked":""):"").'> '.$opcnome);
									
						}else if($opctipo=="text"){
									
							if($opcobs==""){
								if(isset($Resp[$pergcod][$opcgrupo]) && ($Resp[$pergcod][$opcgrupo]!="")){
									echo("&nbsp&nbsp&nbsp&nbsp&nbsp".$opcnome . '&nbsp<input type="' . $opctipo . '" size="1" value="'.$Resp[$pergcod][$opcgrupo].'" name="Perg['.$opccod.']['.$pergcod.']['.$opcgrupo.']"' . '>');
								}else{
									echo("&nbsp&nbsp&nbsp&nbsp&nbsp".$opcnome . '&nbsp<input type="' . $opctipo . '" size="1" value="" name="Perg['.$opccod.']['.$pergcod.']['.$opcgrupo.']"' . '>');
								}
							}else{
	
								$op1 = substr(stristr($opcobs,"|"), 1);
								$op2 = substr($opcobs,0,strpos($opcobs,"|"));
								if(strtolower($op1)=="mês"){
									echo "\n";
									echo("&nbsp&nbsp&nbsp&nbsp". $op2 . '&nbsp&nbsp&nbsp&nbsp<input type="' . $opctipo . '" name="Perg['.$opccod.']['.$pergcod.']['.($opcgrupo - 1).']"' . (isset($Resp)?($Resp[$pergcod][$opcgrupo]!=""?"value=".intval($Resp[$pergcod][$opcgrupo]/12):""):"") . ' size=2>');
									echo("&nbsp&nbsp&nbsp&nbsp". $op1 . '&nbsp&nbsp&nbsp&nbsp<input type="' . $opctipo . '" name="Perg['.$opccod.']['.$pergcod.']['.($opcgrupo).']"' . (isset($Resp)?($Resp[$pergcod][($opcgrupo)]!=""?"value=".intval($Resp[$pergcod][$opcgrupo]%12):""):"") . ' size=2><BR>');
								}elseif(strtoupper($op1)=="SEMANA"){
									echo "\n";
									echo("&nbsp&nbsp&nbsp&nbsp". $op2 . '&nbsp&nbsp&nbsp&nbsp<input type="' . $opctipo . '" name="Perg['.$opccod.']['.$pergcod.']['.($opcgrupo - 1).']"' . (isset($Resp)?($Resp[$pergcod][$opcgrupo]!=""?"value=".intval($Resp[$pergcod][$opcgrupo]/4):""):"") . ' size=2>');
									echo("&nbsp&nbsp&nbsp&nbsp". $op1 . '&nbsp&nbsp&nbsp&nbsp<input type="' . $opctipo . '" name="Perg['.$opccod.']['.$pergcod.']['.($opcgrupo).']"' . (isset($Resp)?($Resp[$pergcod][($opcgrupo)]!=""?"value=".intval($Resp[$pergcod][$opcgrupo]%4):""):"") . ' size=2><BR>');
								}elseif(strtoupper($op1)=="GRAMAS"){
									echo "\n";
									echo("&nbsp&nbsp&nbsp&nbsp". $op2 . '&nbsp&nbsp&nbsp&nbsp<input type="' . $opctipo . '" name="Perg['.$opccod.']['.$pergcod.']['.($opcgrupo - 1).']"' . (isset($Resp)?($Resp[$pergcod][$opcgrupo]!=""?"value=".intval($Resp[$pergcod][$opcgrupo]/1000):""):"") . ' size=2>');
									echo("&nbsp&nbsp&nbsp&nbsp". $op1 . '&nbsp&nbsp&nbsp&nbsp<input type="' . $opctipo . '" name="Perg['.$opccod.']['.$pergcod.']['.($opcgrupo).']"' . (isset($Resp)?($Resp[$pergcod][($opcgrupo)]!=""?"value=".intval($Resp[$pergcod][$opcgrupo]%1000):""):"") . ' size=5><BR>');
								}
							}
									
						}else if($opctipo=="textarea"){
							echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp" . $opcnome. '<center><textarea cols="42" rows="15" name="Perg['.$opccod.']['.$pergcod.']['.$opcgrupo.']">' . (isset($Resp)?($Resp[$pergcod][$opcgrupo]!=""?$Resp[$pergcod][$opcgrupo]:""):"") . '</textarea></center><br>';
						}
				   }
			  }
			  session_register('ancod');
	 }else{
		session_unregister('secprox');
		echo "<script> window.location='questionary.php?limpaquestpai=true&limpaquest=true&limpasec=true'; </script>";
	 }
	  	

  	if(isset($arel) && $arel>0){

		echo "<input type='hidden' name='UPAREL' value='" .$arel. "'>";

  		$UPDATE = $arel;
  		session_register('UPDATE');
		$arel = 0;

  		//echo '<p><input name="imgAtualizar" type="image" id="sub" src="images/atualizar.gif" border="0" onClick=filtra(0)>';		
		echo '<p><input name="imgAtualizar" type="submit" value='.$update.' align="left" width="60" height="15" onClick=filtra(0)>';		

		echo '<a href="questionary.php?arel='.$UPDATE.'&codQuest='.$codQuest.'&questnome='.$questnome.'"><img src="images/avancar.gif" border="0"></a></p>';
		
  	}else{

  		echo "<input type='hidden' name='UPAREL' value='0'>";

		echo '<p><input name="imgGravar" type="submit" value='.$register.' align="left" width="60" height="15" onClick=filtra(0)></p>';		

  	}
  	echo "<input type='hidden' name='filtragem'>";
	?>
    <input type='hidden' name='codQuestPai' value='<?php echo $codQuestPai; ?>'>
    <input type='hidden' name='codQuest' value='<?php echo $codQuest; ?>'>
    <input type='hidden' name='questpainome' value='<?php echo $questpainome; ?>'>
    <input type='hidden' name='questnome' value='<?php echo $questnome; ?>'>
    <?php
	echo "</form>";
}
?>

</div>
<div id="col5">
<div id="menu2acesso">
  <ul>
  <strong>
  <?php
		echo "<li class=titdest>".$menu1."</li>";
		
		$stmtqf="Select * from QUEST_FATHER_SEL(".$idiom.")"; 
		$queryqf = pg_prepare($stmtqf);
		$resqf=pg_execute($queryqf);
		while($linhaqf=pg_fetch_row($resqf)){
			echo "<li><a href=questionary.php?codQuestPai=" . $linhaqf[0]. "&questpainome=".$linhaqf[1]."&limpaquest=true&limpasec=true>" . $linhaqf[1]. "</a></li>";
		}

if(isset($codQuestPai)){

		echo "<li></li>";
		$SQL = "SELECT QUESTIONARY.*
				FROM QUESTIONARY
				Where QUESTIONARY=".$codQuestPai."";

		$res = pg_query($SQL);
		$linha=pg_fetch_row($res);
		echo "<li class=titdest>".$menu2." ".$questpainome.":</li>";
		
		$stmtq="Select * from QUESTIONARY_SEL(".$codQuestPai.", ".$idiom.")"; 
		$queryq = pg_prepare($stmtq);
		$resq=pg_execute($queryq);
		while($linhaq=pg_fetch_row($resq)){
			echo "<li><a href=questionary.php?codQuestPai=".$codQuestPai."&questpainome=".$questpainome."&codQuest=" . $linhaq[0]. "&questnome=".$linhaq[1]."&filtra=1&limpasec=true>" . $linhaq[1]. "</a></li>";
		}
}

if(isset($codQuest)){

		echo "<li></li>";
		echo "<li class=titdest>".$menu3." ".$questnome.":</li>";
		$stmt="Select * from SECTION_SEL(".$codQuest.", ".$idiom.")"; 
		$query = pg_prepare($stmt);
		$res=pg_execute($query);
		while($linha=pg_fetch_row($res)){
			if(isset($UPDATE) && $UPDATE>0){
				echo "<li><a href=questionary.php?arel=".$UPDATE."&codQuest=".$codQuest."&questnome=".$questnome."&codSecMenu=" . $linha[0]. "&filtra=1>" . $linha[1]. "</a></li>";
			}else{
				echo "<li><a href=# onclick=\"javascript:window.open('questalert.php','',',,,width=450,height=100')\">" . $linha[1]. "</a></li>";
			}
		} 
}
?>
</strong>
</ul>
</div>
</div>
<div id="base"><?php echo $base.date('Y');?> ::</div>
</body>
</html>