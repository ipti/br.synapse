<?php
session_start();
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

function check_select(field_name, field_default, message) {
  if (form.elements[field_name] && (form.elements[field_name].type != "hidden")) {
    var field_value = form.elements[field_name].value;

    if (field_value == field_default) {
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

	check_select("degreegrade", "", "Selecione um Grau");
	check_input("description", 1, "Digite a Descrição\n");
		
	if (error == true) {
		alert(error_message);
		submitted = false;
		return false;
	}else{
		submitted = true;
		return true;
	}
}

function filtra(cod) {
  	document.forms["goal_ins"].acao.value = cod;
}

function filtraanexo(cod) {
  	document.forms["anexo"].anexar.value = cod;	
}
//-->
</script>

<?php
if(isset($editar) && $editar==true){
	if(isset($msg) && $msg!=""){
		echo $msg;
	}else{
		echo "<h3 align='center'><font color='red'>Editando o objetivo: ".$goal_id."-".$description." <br>| ".$activitycontent." | ".$modalidade."</font></h3>";
	}
}

if(isset($msggoal_ins) && $msggoal_ins!=""){
	echo $msggoal_ins;
}

echo '<form name="goal_ins" action="goal.php" method="post" onSubmit="return check_form(goal_ins);">';
	echo "<table border='1' width='100%'>";	
		if(isset($degreestage) && $degreestage!=""){
			$SQL = "SELECT ds.name as degreestagename FROM degreestage ds WHERE ds.id = ".$degreestage."";
			$res = pg_query($SQL);
			$linha = pg_fetch_array($res);
			$degreestagename = $linha['degreestagename'];
		}
		if(isset($degreeblock) && $degreeblock!=""){
			$SQL = "SELECT db.name as degreeblockname FROM degreeblock db WHERE db.id = ".$degreeblock."";
			$res = pg_query($SQL);
			$linha = pg_fetch_array($res);
			$degreeblockname = $linha['degreeblockname'];
		}
		if(isset($degreegrade) && $degreegrade!=""){
			$SQL = "SELECT dg.name as degreegradename FROM degreegrade dg WHERE dg.id = ".$degreegrade."";
			$res = pg_query($SQL);
			$linha = pg_fetch_array($res);
			$degreegradename = $linha['degreegradename'];
		}
		echo "<tr><td><h3>Estágio: <select name='degreestage' onchange='document.goal_ins.submit()'>";
			if(isset($degreestage) && $degreestage!=""){
				echo "<option value='".$degreestage."'>".$degreestagename." Estágio</option>";
			}
			$SQLds = "SELECT degreestage.* FROM degreestage ORDER BY grade";
			$resds = pg_query($SQLds);
			echo "<option></option>";
			while($linhads = pg_fetch_array($resds)){
				echo "<option value='".$linhads['id']."'>".$linhads['name']." Estágio</option>";
			}
		echo "</select></h3></td>";
		
		echo "<td><h3>Bloco: <select name='degreeblock' onchange='document.goal_ins.submit()'>";
			if((isset($degreestage) && $degreestage!="") && (isset($degreeblock) && $degreeblock!="")){
				echo "<option value='".$degreeblock."'>".$degreeblockname." Bloco</option>";
			}
			if(isset($degreestage) && $degreestage!=""){
				$SQLdb = "SELECT degreeblock.* FROM degreeblock WHERE degreestage_id = ".$degreestage." ORDER BY grade";
				$resdb = pg_query($SQLdb);
				echo "<option></option>";
				while($linhadb = pg_fetch_array($resdb)){
					echo "<option value='".$linhadb['id']."'>".$linhadb['name']." Bloco</option>";
				}
			}else{
				$degreeblock="";
				$degreegrade="";
			}
		echo "</select></h3></td>";
		echo "<td><h3>Grau: <select name='degreegrade' onchange='document.goal_ins.submit()'>";
			if((isset($degreestage) && $degreestage!="") && (isset($degreeblock) && $degreeblock!="") && (isset($degreegrade) && $degreegrade!="")){
				echo "<option value='".$degreegrade."'>".$degreegradename."º Grau</option>";
			}
			if((isset($degreestage) && $degreestage!="") && (isset($degreeblock) && $degreeblock!="")){
				$SQLdg = "SELECT degreegrade.* FROM degreegrade WHERE degreeblock_id = ".$degreeblock." ORDER BY grade";
				$resdg = pg_query($SQLdg);
				echo "<option></option>";
				while($ldg = pg_fetch_array($resdg)){
					echo "<option value='".$ldg['id']."'>".$ldg['name']."º Grau</option>";
				}
			}else{
				$degreeblock="";
				$degreegrade="";
			}
		echo "</select>";
		if(!isset($editar) && isset($goal_id)){
			echo "<input type='submit' value='Upd' onClick='filtra(4)'>";
		}
		echo "</h3></td>";

		echo "<td>";
			if(((!isset($filtrocontent) || (isset($filtrocontent) && $filtrocontent==false)) && (!isset($goal_id)) && (!isset($editar)))){
				echo "<a href='goal.php?filtrocontentadd=true";
				echo (isset($degreestage)?"&degreestage=".$degreestage."&degreestagename=".$degreestagename:"");
				echo (isset($degreeblock)?"&degreeblock=".$degreeblock."&degreeblockname=".$degreeblockname:"");
				echo (isset($degreegrade)?"&degreegrade=".$degreegrade."&degreegradename=".$degreegradename:"");
				echo "&discipline=".$discipline."'>";
				echo "Filtrar por Conteúdo ou Inserir Novo</a>";
			}elseif((isset($filtrocontent) && $filtrocontent==true) && (!isset($goal_id)) && (!isset($editar))){
				echo "<a href='goal.php?filtrocontentremove=true";
				echo (isset($degreestage)?"&degreestage=".$degreestage."&degreestagename=".$degreestagename:"");
				echo (isset($degreeblock)?"&degreeblock=".$degreeblock."&degreeblockname=".$degreeblockname:"");
				echo (isset($degreegrade)?"&degreegrade=".$degreegrade."&degreegradename=".$degreegradename:"");
				echo "&discipline=".$discipline."'>";
				echo "Remover Filtro</a>";
			}elseif((isset($goal_id)) && (!isset($editar))){
				echo "<a href='goal.php?discipline=".$discipline."";
				ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
				include('goal/content_link.php');
				ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
				echo "'>Voltar</a>";
			}elseif(isset($editar)){
				echo "<a href='goal.php?goal_id=".$goal_id."";
				ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
				include('goal/content_link.php');
				ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
				echo "'>Voltar</a>";
			}
		echo "</td>";
		echo "</tr>";
		echo "<input type='hidden' name='discipline' value='".$discipline."'>";
		if(isset($goal_id) && $goal_id!=""){
			echo "<input type='hidden' name='goal_id' value='".$goal_id."'>";
		}
		if(isset($editar) && $editar==true){
			echo "<input type='hidden' name='editar' value='true'>";
		}
		if(isset($filtrocontent) && $filtrocontent==true){
			echo "<input type='hidden' name='filtrocontent' value='true'>";
		}
		echo "<input type='hidden' name='acao' value=''>";
	echo "</table>";
	
	if(((isset($filtrocontent) && $filtrocontent==true) && (!isset($goal_id)) || (isset($editar)))){
		echo "<hr>";
		echo "<table width='100%' border='1'><tr valign='top'>";
		
			ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
			include("goal_form_hability.php");
			ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
			
			if(isset($discipline) && $discipline==1){
				ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
				include("goal_form_port.php");
				ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
			}//if($discipline==1)
			
			if(isset($discipline) && $discipline==2){
				ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
				include("goal_form_mat.php");
				ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
			}//if(isset($discipline) && $discipline==2){
		
			if(isset($discipline) && $discipline==3){
				ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
				include("goal_form_scie.php");
				ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
			}//if(isset($discipline) && $discipline==3){
			
			if(isset($discipline) && $discipline==6){
				ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
				include("goal_form_neu.php");
				ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
			}//if(isset($discipline) && $discipline==6){
			
			if(isset($discipline) && ($discipline==3 || $discipline==6)){
				ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
				include("goal_form_scieneu.php");
				ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);						
			}
		echo "</tr>";
		echo "<tr><td colspan='4'><h3>Desc: <input type='text' name='description' value='".(isset($description)?$description:"")."' size='100%'>";
			if(isset($editar) && $editar==true){
				echo '<input type="submit" value="Upd" onClick="filtra(2)">';
			}else{
				echo '<input type="submit" value="Ins" onClick="filtra(3)">';
				//echo '<input type="submit" value="Sel" onClick=filtra(1)>';
			}
		echo "</h3></td></tr>";
	
		echo "</table>";
	}
echo "</form>";
?>