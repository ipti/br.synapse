<?php
// admcont = visualiza lista de contatos
// viewcont = busca lista de contatos do e-mail inserido no input name="txtemailviewcont"

session_start();
ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
require("includes/conecta.php");
ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
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
	if (submitted == true) {
    	alert("Este formulário já foi enviado. Por favor pressione OK e aguarde o processo ser completado.");
  	 	return false;
  	}
    error = false;
    form = form_name;
    error_message = "Erros ocorreram durante o envio de seu formulário.\n\nPor favor, faça as seguintes correções:\n\n";
    check_input("txtsubject", 2, "Falta descrever o Assunto");
	check_input("txttext", 2, "Falta descrever a Mensagem");
	check_input("txtemail", 5, "Preencha o seu e-mail");
    if (error == true) {
      alert(error_message);
	  return false;
    }
}
//--></script>

<?php

if(isset($idioma)){
	$idiom=$idioma;
	session_register('idiom');
}elseif(!isset($idiom)){
	$idiom="7";
	session_register('idiom');
}

if(isset($idiom) && $idiom=="7"){
$h1="<h1>Meus Contatos</h1>";
$h2="Contatos de:";
$h3="<h3>Ver meu <a href='contact.php?admcont=true' class='link'>Hist&oacute;rico de Contatos!</a></h3>";
$button="Enviar";
$subj="Assunto";
$attach="Anexar";
$look="Procurar";
$insert="Inserir";
}

if(isset($idiom) && $idiom=="16"){
$h1="My Contacts";
$h2="Contacts of:";
$h3="See my <a href='contact.php?admcont=true' class='link'>historic!</a>";
$button="Send";
$subj="Subject";
$attach="Attach";
$look="Look";
$insert="Insert";
}

if(isset($viewcont) && isset($person)){
	unset($viewcont);
	$admcont=true;
}

if(isset($personage) && $personage==1){
	$admcont=true;
}
//---------------------------------------------------------------------------------------------------------- GRAVA A RESPOSTA
if(isset($acao) && $acao==2){ //envia a resposta preenchida pela acao 1

	if(isset($relatu) && $relatu!=""){

		$SQL = "UPDATE communication SET answer=1 WHERE id=".$relatu.";";
		$r = pg_query($SQL);
		pg_query("COMMIT");

		$SQL = "SELECT DISTINCT communication.*, person.email, person.name
				FROM communication
						LEFT JOIN person ON person.id = communication.person_id
				WHERE (((communication.id)=".$relatu."));";
		$rp = pg_query($SQL);
		$l = pg_fetch_array($rp);
		$email=$l['email'];
		$name=$l['name'];
		$subject=$l['subject'];
		$horas = date("Y-m-d");

		$SQL = "INSERT INTO communication(person_id, date, subject, text, type, answer, father_id) 
				VALUES (".$l['person_id'].", '".$horas."', '".$l['subject']."', '".$textrelatu."', 'Resposta', '1', ".$l['id'].")";

		$r = pg_query($SQL);
				
		$headers  = "MIME-Version: 1.0\n";
		$headers .= "Content-Type: text/html; charset=iso-8859-1\n";
		$headers .= "From: Contato Enscer <contato@enscer.com.br>\n";
		$headers .= "Return-Path: Contato Enscer <contato@enscer.com.br>\n"; 
		$emailsender = "contato@enscer.com.br";

		if(mail($email, urldecode($subject), "Prezado(a) ".$name.",\r\n".urldecode($txttext)."\r\nAtenciosamente: Equipe do ENSCER.\r\n\r\n\nATENÇÃO: Não responda esse e-mail.\r\nAcesse sua área em www.enscer.com.br/synapse", $headers)){
			echo "<h3>Mensagem Registrada e Enviada com Sucesso.&nbsp;<a href=javascript:window.close()>Fechar</a></h3>";
		}else{
			echo "<h3>Erro no servidor de Mensagem.&nbsp;<BR>Mensagem Registrada Mas Não Enviada.&nbsp;<a href=javascript:window.close()>Fechar</a></h3>";
		}

		echo $email;
		echo "<br>".$name;
		echo "<br>".$headers;
		exit;
	}
//---------------------------------------------------------------------------------------------------------- // GRAVA A RESPOSTA

//---------------------------------------------------------------------------------------------------------- PREENCHER A RESPOSTA
}elseif(isset($acao) && $acao==1){ //preenche a resposta
?>
	<form name="frmContato" method="post" action="contact.php">
	<table width="510" border="0" cellpadding="2" cellspacing="0">
		<?php
		if(!isset($codrel)){ ?>
			<tr><td><h3>Assunto: <input type="text" name="subject"></h3></td></tr>
  <?php } ?>
		<tr><td height="66" colspan="2"><textarea name="textrelatu" cols="60" rows="10" id="text"></textarea></td></tr>
		<tr>
		<input type="hidden" value="2" name="acao">
		<input type="hidden" value="true" name="contemail">
		<input type="hidden" value="<? echo $codrel ?>" name="relatu">
		<td width="60"><input name="sub" type="image" src="../../../../imagens/enviar.gif" align="left" width="60" height="18"></td>
		</tr>
	</table>
	</form>
<?
	exit;
}
//---------------------------------------------------------------------------------------------------------- // PREENCHER A RESPOSTA

//---------------------------------------------------------------------------------------------------------- GRAVA O CONTATO
if(isset($txttext) && $txttext!=""){ //contato enviado

	$horas = date("Y-m-d");

//	if(!isset($communication)){

		if(!isset($person) || (isset($person) && $person=="")){
		
			$SQL = "SELECT person.*
					FROM person 
					WHERE email = '".$txtemail."'";
			$res = pg_query($SQL);

			if(pg_num_rows($res)>0){
			
				$l = pg_fetch_array($res);
				$person = $l['id'];
				session_register('person');
				$personname = $l['name'];
				session_register('personname');
				$email = $l['email'];
				session_register('email');
				
			}else{
				$SQLip = "INSERT INTO person (name, email)
						  VALUES ('".$txtname."', '".$txtemail."')";
				$resip = pg_query($SQLip);

				$SQLsip = "SELECT id, name FROM person WHERE email = '".$txtemail."' ORDER BY id DESC";
				$ressip = pg_query($SQLsip);
				$lsip = pg_fetch_array($ressip);				
				$person = $lsip['id'];
				$personname = $lsip['name'];
				session_register('person');
				session_register('personname');
				$horas = date("Y-m-d H:i:s");
				
				$SQLia = "INSERT INTO actor (person_id, personage_id, unity_id, activated)
						  VALUES (".$person.", 2, 1, '".$horas."')";
				$resia = pg_query($SQLia);
					
				$SQLil = "INSERT INTO login (person_id, login, password, accountdate, loginnumber) VALUES (".$person.", '".$txtemail."', 'synapse', '".$horas."', 1)";
				$res = pg_query($SQLil);
					
				$newperson=true;
			}
		}//if(!isset($person) || (isset($person) && $person=="")){

		$SQL = "INSERT INTO communication (person_id, subject, text, date, type, answer, father_id)
				VALUES (".$person.", '".$txtsubject."', '".$txttext."', '".$horas."', 'Pergunta', 0, 0)";
		$res = pg_query($SQL);

	/*}elseif(isset($communication)){

		$SQL = "UPDATE communication SET subject='".urlencode($txtsubject)."', text='".urlencode($txttext)."' 
				WHERE id=".$communication.";";
		$res = pg_query($SQL);
	}//if(!isset($communication)){
	*/
	$SQL = "SELECT id FROM communication WHERE person_id = ".$person." ORDER BY date DESC";
	$res = pg_query($SQL);
	$l = pg_fetch_array($res);
	
	$headers  = "MIME-Version: 1.0\n";
	$headers .= "Content-Type: text/html; charset=iso-8859-1\n";
	$headers .= "From: Site <contato@enscer.com.br>\n";
	$headers .= "Return-Path: Site <contato@enscer.com.br>\n"; 
	$emailsender = "contato@enscer.com.br";

	mail("contato@enscer.com.br", urldecode($txtsubject), "O usuário ".$personname." (cod: ".$person.", email: ".$txtemail.") entrou em contato: \r\n\r\n " . urldecode($txttext) . " \r\n\r\nAcesse www.enscer.com.br/synapse/contact.php?acao=1&person=".$person."&codrel=".$l['id'], $headers); //, "-r".$emailsender

	$horas = "";
	$text = "";
	$enviado = true;
}//if(isset($text) && $text <> ""){
//---------------------------------------------------------------------------------------------------------- // GRAVA O CONTATO


if(isset($admcont) && (isset($txtemailviewcont) && $txtemailviewcont!="")){

	$SQL = "SELECT person.*, login.*
					FROM person 
							LEFT JOIN login ON login.person_id = person.id
					WHERE email = '".$txtemailviewcont."'";
	$res = pg_query($SQL);

	if(pg_num_rows($res)>0){
		unset($viewcont);
		$admcont=true;
		$l = pg_fetch_array($res);
		$person = $l['id'];
		session_register('person');
		$personname = $l['name'];
		session_register('personname');
		$email = $l['email'];
		session_register('email');
				
	}else{//if(pg_num_rows($res)>0){
		echo "<h3><font color='red'>Email não cadastrado em nosso banco de dados</font></h3>";
	}
}

?>

<html>
<head>
<title>:: ENSCER - Ensinando o cérebro ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="synapse.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php 
if(!($acao==1 || $acao==2)){
	ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
	include("includes/topo.php");
	ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
}
?>

<div id="col1">
<?php
	if(isset($person) && $person !=""){
		ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
		include("includes/menu.php");
		ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
	}
?> 
</div>

<div id="coltripla">
<?php
	echo $h1;
	if(isset($person) && $person!=""){
		echo "<h2>".$h2." ".$personname."</h2>";
	}
?>
	
<form name="contact" method="post" action="<?php echo "http://".$_SERVER['SERVER_NAME'].$PHP_SELF; ?> " onSubmit="return check_form(contact); ">

<?php 
if(isset($admcont) && isset($person)){
	if((isset($personage) && $personage==1) && ((!isset($acao)) || (isset($acao) && $acao!=6))){
		echo "<h3><a class=link href='http://".$_SERVER['SERVER_NAME'].($_SERVER['PHP_SELF'])."?admcont=true&acao=6'>Já Respondidos</a>";
	}elseif((isset($personage) && $personage==1) && (isset($acao) && $acao==6)){
		echo "<h3><a class=link href='http://".$_SERVER['SERVER_NAME'].($_SERVER['PHP_SELF'])."?admcont=true'>Não Respondidos</a>";
	}
	echo "<h3><a href='contact.php'>Novo contato</a></h3>";
	echo "<hr>";
	echo "<table width='560'>";

	$SQL = "SELECT DISTINCT person.name, communication.*, (actor.id) as actor_id
			FROM communication 
				LEFT JOIN person ON person.id = communication.person_id
				LEFT JOIN actor ON actor.person_id = person.id
			WHERE (((communication.subject)<>'') AND ((communication.text)<>'')";
			
	if((!isset($personage) || ((isset($personage) && $personage!=1))) && (isset($person) && $person!="")){
		$SQL.= " AND ((communication.person_id)=".$person.")";
	}
	if((isset($personage) && $personage==1) && (isset($acao) && $acao==6)){
		$SQL.= " AND ((communication.answer)=1)";
	}
	if((isset($personage) && $personage==1) && (!isset($acao) || (isset($acao) && $acao!=6))){
		$SQL.= " AND ((communication.answer)=0)";
	}
	$SQL .= ") ORDER BY communication.person_id ASC, communication.date DESC, communication.father_id, communication.type;";

	$r = pg_query($SQL);

	//echo '<a href=# onclick="javascript:window.open(\'contact.php?acao=1\',\''.$linha['questcod']. '\',\'menubar,scrollbars,resizable,width=550,height=300\');" class="link">Enviar uma mensagem</a>';

	while($l=pg_fetch_array($r)){

		if($l['type'] == "Pergunta"){
			echo '<tr><td colspan="2"><hr></tr>';
			echo "<tr>";
			echo "<td><h4></h4></td>";
			echo "<td><h4></h4></td>";
			echo "</tr>";
		}

		echo "<tr".($l['answer']=="Pergunta" ? "bgcolor='#E3E5EB'" : "bgcolor='#FFFFFF'").">";
		echo "<td><h3>";
		if($l['type'] == "Pergunta"){ 
			echo "Contato Enviado por <a href='actor_ins.php?person_cod=".$l['person_id']."'> ".$l['name']." </a> | Dia: ".$l['date']."</h3></td>";
		
			if(isset($personage) && $personage==1){
			?>
				<td><? 
				echo '<input type="image" name="imgresp" value="'.$l['id'].'" alt="Responder" id="sub" src="../../../imagens/resp.gif" border="0" align="left"';
				echo ' <a href="#" onclick="javascript:window.open(\'contact.php?acao=1'."&subject=".$l['subject']."&codrel=" .$l['id'].'\',\'\'';
				echo ',\'menubar,scrollbars,resizable,width=550,height=300\');">';?>
			<?php
			} 
		}else{ 
			echo "<font color=red>Contato Enviado pelo Enscer dia: ".$l['date']."</font>";
			echo "</td>";
			echo "<td>";
		}  
		echo "</td>";
		echo "</tr>";
		?>
		<tr <? echo strpos($l[6], "RE: ")>-1?'bgcolor="#A7B8E3"':'bgcolor="#A7B8E3"'; ?> >
		<td colspan="2"><h4>Assunto: <? echo urldecode($l['subject']);?></h4></td>
		</tr>
		<tr <? echo strpos($l[6], "RE: ")>-1?'bgcolor="#B4C9FE"':'bgcolor="#B4C9FE"'; ?>>
		<td colspan="2"><p><? echo urldecode($l['text']); ?></p></td>
		</tr>
		<?
	}//while($l=pg_fetch_array($r)){
	echo "</table>";

}//}if(isset($admcont) && isset($person)){


if(!isset($enviado)){
//------------------------------------------------------------------------------------------------------- PREENCHE CONTATO SEM PERSON
	if(!isset($viewcont) && !isset($person)){
		echo "<h2>Insira seu nome: <input type='text' name='txtname'></h2>";
		echo "<h2>Insira seu email*: <input type='text' name='txtemail'></h2>";
	}
//------------------------------------------------------------------------------------------------------- PREENCHE CONTATO COM PERSON
	if(!isset($viewcont) && !isset($admcont)){
		if(isset($person)){
			echo $h3;
		}
		?>
		<hr>
		<table width="259" border="0" cellspacing="0" cellpadding="2">
		<tr><h3><td><?php echo $subj."*: "; ?><input name="txtsubject" type="text" size="50" maxlength="40" value="<?php echo (isset($txtsubject) && $txtsubject!=""?$txtsubject:"");?>"></td></h3></tr>
		<tr><td height="66"><textarea name="txttext" cols="60" rows="10" id="text" value="<?php echo ($txttext!=""?$txttext:"");?>"></textarea></td></tr>
		</table>
		<input name="sub" type="submit" value="<?php echo $button; ?>" align="left" width="60" height="18">
		<?php
	}
//------------------------------------------------------------------------------------------------------- PREENCHE EMAIL PARA BUSCAR LISTA DE CONTATOS
 	if(isset($viewcont) && !isset($person)){
		echo "<h2>Insira seu email: <input type='text' name='txtemailviewcont'></h2>";
		echo "<input type='hidden' name='admcont' value='true'>";
		echo '<input name="sub" type="submit" value="'.$button.'" align="left" width="60" height="18">';
	}
?>

</form>
<?php

}

if(isset($enviado)){ //(!isset($enviado)){
	$text = ""; 
	echo "<hr>";
	echo "<h2><font color=red>Contato registrado com sucesso</font></h2>";
	if(isset($newperson)){
		echo "<h3>Um usuário foi criado para o seu futuro acesso. <br><br>Login: ".$txtemail." <br>Senha: synapse</h3>";
	}
	echo "<h3>Retornaremos o mais breve possível, enviando uma mensagem para o seu endere&ccedil;o de E-mail.</h3>";
	echo "<h3><a href='contact.php' class='link'>1 - Novo Contato</a></h3>";//?acao=3
	echo "<h3><a href='contact.php?admcont=true' class='link'>2 - Ver meu Hist&oacute;rico de Contatos</a></h3>";
}
?> 
</div>
<div id="base"><?php echo $base.date('Y');?> ::</div>
</body>
</html>