<?  session_start();

       ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
       require("includes/conecta.php");
       ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

       ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
       require("includes/funcoes.php");
       ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

//if(!(session_is_registered('person'))){
//	echo "erro";
//	header('Location: ' . "http://" . $_SERVER["SERVER_NAME"]."/synapse/index.php");	
//}
?>

<head>
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

function check_radio(field_name, message) {
  var isChecked = false;
  if (form.elements[field_name] && (form.elements[field_name].type != "hidden")) {
    var radio = form.elements[field_name];

    for (var i=0; i<radio.length; i++) {
      if (radio[i].checked == true) {
        isChecked = true;
        break;
      }
    }

    if (isChecked == false) {
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

function check_password(field_name_1, field_name_2, field_size, message_1, message_2) {
  if (form.elements[field_name_1] && (form.elements[field_name_1].type != "hidden")) {
    var password = form.elements[field_name_1].value;
    var confirmation = form.elements[field_name_2].value;

    if (password == '' || password.length < field_size) {
      error_message = error_message + "* " + message_1 + "\n";
      error = true;
    } else if (password != confirmation) {
      error_message = error_message + "* " + message_2 + "\n";
      error = true;
    }
  }
}

function check_password_new(field_name_1, field_name_2, field_name_3, field_size, message_1, message_2, message_3) {
  if (form.elements[field_name_1] && (form.elements[field_name_1].type != "hidden")) {
    var password_current = form.elements[field_name_1].value;
    var password_new = form.elements[field_name_2].value;
    var password_confirmation = form.elements[field_name_3].value;

    if (password_current == '' || password_current.length < field_size) {
      error_message = error_message + "* " + message_1 + "\n";
      error = true;
    } else if (password_new == '' || password_new.length < field_size) {
      error_message = error_message + "* " + message_2 + "\n";
      error = true;
    } else if (password_new != password_confirmation) {
      error_message = error_message + "* " + message_3 + "\n";
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

  check_input("nome", 4, "Seu nome deve conter o mínimo de 4 caracteres.");
  check_input("profissao", 4, "Sua profissão deve ter o mínimo de 4 caracteres.");
  check_input("email", 6, "Seu E-Mail deve conter o mínimo de 6 caracteres.");
  check_input("telefone", 5, "Seu telefone deve ter o mínimo de 5 caracteres.");  
  check_input("logra", 1, "Falta escolher o logradouro.");
  check_input("endereco", 5, "Seu endereço deve ter o mínimo de 5 caracteres.");
  check_input("numero", 1, "O número de sua residência deve ter o mínimo de 1 caractere.");
  check_input("cep", 8, "Seu CEP deve ter o mínimo de 8 caracteres.");
  check_input("cidade", 3, "Sua cidade deve ter o mínimo de 3 caracteres.");
  check_input("estado", 2, "Seu estado deve ter o mínimo de 2 caracteres.");

  check_password("senha", "confirmacao", 4, "Sua senha deve ter o mínimo de 4 caracteres.", "A confirmação de senha deve combinar com sua senha.");
  check_password_new("password_current", "password_new", "password_confirmation", 5, "Sua senha deve ter o mínimo de5 caracteres.", "Sua nova senha deve ter o mínimo de5 caracteres.", "A confirmação de senha deve combinar com sua senha.");

  if (error == true && document.pesq==false) {
    alert(error_message);
    return false;
  } else {
    submitted = true;
    return true;
  }
}
//--></script>
<title>:: ENSCER - Ensinando o c&eacute;rebro ::</title>
<link href="<?php echo "http://" . $_SERVER['SERVER_NAME']; ?>/enscercss.css" rel="stylesheet" type="text/css">
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
	include("includes/menu.php");
	ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
?>
</div>

<div id="coltripla">
<?php
	
	if(isset($imgPedido_x) && $imgPedido_x != ""){
		
		$SQL = "SELECT * FROM activity_order WHERE person_id=" . $person_cod . " ORDER BY orderdate ASC" ;
		$res=pg_query($SQL);
		if (pg_num_rows($res)==0){
			echo "<h2><font color=red>Não Existe Pedidos</font></h2><br>";
		}else{
			echo "<h2>Pedidos:</h2><br>";
			while($linha=pg_fetch_array($res)){
				echo "<h4>Em: <a href='http://" . $_SERVER["SERVER_NAME"] ."/synapse/pedido.php?codPed=" . $linha[0] .  "'>" . date("d/m/Y H:i:s",strtotime($linha['orderdate'])) . "</a></h4><br>";
			}
		}
		session_unregister('horas');
		echo "<h3><a href='inseripedido.php'>Inserir Novo Pedido</a></h3>";
		
	}elseif((isset($imgCadContato_x) && $imgCadContato_x!=0) || (isset($imgEnvContato_x) && $imgEnvContato_x!=0)){
		
		$texto = isset($_POST['textcont'])?$_POST['textcont']:'';
		
		if($texto!="" && $codUsu>0){
		
			$SQL = "INSERT INTO communication (person_id, date, subject, text, type, anwser) 
					VALUES (".$person_cod.", now(), '".$assunto."', '".$texto."', 'Resposta', '1')";
			pg_query($SQL);
			
			if(isset($imgEnvContato_x) && $imgEnvContato_x!=0){
				if($clEmail <> ""){
					$headers  = "MIME-Version: 1.0\r\n";
					$headers .= "From: Site Enscer <atendimento@enscer.com.br>\r\n";
					$headers .= "Content-Type: text/html; charset=iso-8859-1\n";
					mail($clEmail, $assunto, "Prezado(a) ".$usuario.",\n".urldecode($texto)."\nAtenciosamente: Equipe do Enscer.\n\nATENÇÃO: Não responda esse e-mail.\nAcesse sua área em www.enscer.com.br/admin/login.php", "FROM:Enscer - Ensinando o Cérebro<atendimento@enscer.com.br>\r\n") or die("Erro ao enviar a mensagem");
				}else{
					echo "<h1>Cadastro sem E-MAIL</h1>";
				}	
			}
		}
		
	}elseif(isset($codCli) && $codCli!=""){
		
		$selectSQL = "SELECT person.*, login.login, login.password, city.name as cityname
					  FROM person 
					  		LEFT JOIN login ON login.person_id = person.id 
							LEFT JOIN city ON city.id = person.city_id
					  WHERE person.id=".$codCli;
		$resultado = pg_query($selectSQL);
		$linha = pg_fetch_array($resultado);
		$usuario = $linha['name'];
		session_register("usuario");
		$codUsu = $linha['id'];
		session_register("codUsu");
		$clEmail = $linha['email'];
		session_register("clEmail");
		$clTelefone = $linha['phone'];
		session_register("clTelefone");
		$clLogin = $linha['login'];
		session_register("clLogin");
		$clPassword = $linha['password'];
		session_register("clPassword");
		$clLogra = $linha['addresstype'];	
		session_register("clLogra");
		$clRua = $linha['address'];
		session_register("clRua");
		$clNum = $linha['number'];
		session_register("clNum");
		$clComplemento = $linha['comlement'];
		session_register("clComplemento");
		$clBairro = $linha['neighborhood'];
		session_register("clBairro");
		$clCidade = $linha['city_id'];
		session_register("clCidade");
		$clCidadeNome = $linha['cityname'];
		session_register("clCidadeNome");
		$clEstado = $linha['state_id'];
		session_register("clEstado");
		$clCEP = $linha['postalcode'];
		session_register("clCEP");
				
	}elseif(isset($_POST['imgPesqNome_x']) || isset($_POST['imgPesqEmail_x']) || isset($_POST['imgPesqCid_x'])){
		
		echo "<h2>Pesquisa</h2>";
		
		if(isset($_POST['imgPesqEmail_x']) && $_POST['imgPesqEmail_x']!=''){
		
			$selectSQL = "SELECT id, name FROM person WHERE email like '%".$txtemail."%' ORDER BY name";
			$rescli = pg_query($selectSQL);
			$numcli=pg_num_rows($rescli);

		}else if(isset($_POST['imgPesqNome_x']) && $_POST['imgPesqNome_x']!=''){
		
			$selectSQL = "SELECT id, name FROM person WHERE name like '%".$txtname."%' ORDER BY name";
			$rescli = pg_query($selectSQL);
			$numcli=pg_num_rows($rescli);
		
		}
		
		$linha = pg_fetch_array($rescli);
		
		if($numcli > 0){
			while($linha = pg_fetch_array($rescli)){
				echo "<b>&nbsp;&nbsp;<a href='http://" . $_SERVER["SERVER_NAME"] . "/synapse/actor_ins.php?codCli=" . $linha['id']. "'>" . $linha['name'] ."</a><br></b>";
			}
		}
		
		$imgPesqNome_x="";
		$imgPesqEmail_x="";
		
	}elseif(isset($imgAtualizar_x )&& $imgAtualizar_x !=""){
		
		$selectSQL = "SELECT * FROM person WHERE email LIKE '".$txtemail."' AND id <> ".$codUsu."";
		$res = pg_query($selectSQL);

		if (pg_num_rows($res)>0){
			$linha2 = pg_fetch_array($resultado);
			if($linha2['id']!=$codUsu){
				echo '<h1>Cadastro</h1><h2>Email já Existente!</h2><h3><a href="actor_ins.php?person_cod='.$codUsu.'" class="link">Voltar</a></h3>';
				exit(0);
			}
		}
			
		$SQL = "UPDATE person SET name='".$txtname."', email='".$txtemail."', phone='".$txtphone."', celphone='".$txtcelphone."', 
								  addresstype='".$txtaddresstype."', address='".$txtaddress."', number='".$txtnumber."', 
								  complement='".$txtcomplement."', neighborhood='".$txtneighborhood."', postalcode='".$txtpostalcode."', 
								  city_id=".$txtcity.", state_id='".$txtstate."'
				WHERE id=".$codUsu ;
		$resultado = pg_query($SQL);
		
		$SQL = "UPDATE login SET login='".$txtlogin."', password='".$txtpassword."' WHERE person_id = ".$codUsu."";
		$resultado = pg_query($SQL);
		
		echo '<h3><font color=red>Cadastro do Cliente Atualizado com sucesso!</font></h3>';
		
		if ($resultado){
			$SQL = "SELECT person.*, login.login, login.password, city.name as cityname
					FROM person 
							LEFT JOIN login ON login.person_id = person.id 
							LEFT JOIN city ON city.id = person.city_id
					WHERE person.id=".$codUsu."";
			$res = pg_query($SQL);
			$linha = pg_fetch_array($res);
			$usuario = $linha['name'];
			session_register("usuario");
			$codUsu = $linha['id'];
			session_register("codUsu");
			$clEmail = $linha['email'];
			session_register("clEmail");
			$clTelefone = $linha['phone'];
			session_register("clTelefone");
			$clCelTelefone = $linha['celphone'];
			session_register("clCelTelefone");
			$clLogin = $linha['login'];
			session_register("clLogin");
			$clPassword = $linha['password'];
			session_register("clPassword");
			$clLogra = $linha['addresstype'];	
			session_register("clLogra");
			$clRua = $linha['address'];
			session_register("clRua");
			$clNum = $linha['number'];
			session_register("clNum");
			$clComplemento = $linha['comlement'];
			session_register("clComplemento");
			$clBairro = $linha['neighborhood'];
			session_register("clBairro");
			$clCidade = $linha['city_id'];
			session_register("clCidade");
			$clCidadeNome = $linha['cityname'];
			session_register("clCidadeNome");
			$clEstado = $linha['state_id'];
			session_register("clEstado");
			$clCEP = $linha['postalcode'];
			session_register("clCEP");
					
		}
	}
		
	if(isset($person_cod) && $person_cod!=""){

		$selectSQL = "SELECT person.*, login.login, login.password, city.name as cityname
					  FROM person 
					  		LEFT JOIN login ON login.person_id = person.id 
							LEFT JOIN city ON city.id = person.city_id
					  WHERE person.id=".$person_cod;
		$resultado = pg_query($selectSQL);
		$linha = pg_fetch_array($resultado);
		$usuario = $linha['name'];
		session_register("usuario");
		$codUsu = $linha['id'];
		session_register("codUsu");
		$clEmail = $linha['email'];
		session_register("clEmail");
		$clTelefone = $linha['phone'];
		session_register("clTelefone");
		$clCelTelefone = $linha['celphone'];
		session_register("clCelTelefone");
		$clLogin = $linha['login'];
		session_register("clLogin");
		$clPassword = $linha['password'];
		session_register("clPassword");
		$clLogra = $linha['addresstype'];	
		session_register("clLogra");
		$clRua = $linha['address'];
		session_register("clRua");
		$clNum = $linha['number'];
		session_register("clNum");
		$clComplemento = $linha['comlement'];
		session_register("clComplemento");
		$clBairro = $linha['neighborhood'];
		session_register("clBairro");
		$clCidade = $linha['city_id'];
		session_register("clCidade");
		$clCidadeNome = $linha['cityname'];
		session_register("clCidadeNome");
		$clEstado = $linha['state_id'];
		session_register("clEstado");
		$clCEP = $linha['postalcode'];
		session_register("clCEP");

	}	
?>

<form name="cadcli" action="actor_ins.php" method="post" onSubmit="return check_form(cadcli);">
    <h1>Administra&ccedil;&atilde;o - Cadastro de Clientes/Contatos</h1>
    <table border="0" width="560" cellspacing="0" cellpadding="2">
      <tr> 
        <td colspan="2" class="main"><div align="left"> 
            <h2><b>Dados Pessoais</b></h2>
          </div></td>
        <td colspan="2" align="right" class="inputRequirement"><div align="left"> 
            <h2><b>Endereço</b></h2>
          </div></td>
      </tr>
      <tr> 
        <td width="14%" class="main">Nome: <? echo $codUsu; ?></td>
        <td width="37%" align="left" valign="middle" class="main"><input name="txtname" type="text" id="nome" <? if(isset($usuario)){ echo "value='" . $usuario . "'";}?> > &nbsp;* 
          <input name="imgPesqNome" type="image" src="../imagens/pesq.gif" border="0" onClick='javascript:document.pesq=true;location="http://<? echo $_SERVER["SERVER_NAME"]; ?>/synapse/actor_ins.php"'></td>
        <td width="16%" class="main"> <select name="txtaddresstype">
            <? if ($clLogra){
        	  echo "<option>".$clLogra."</option>";
		} ?>
            <option value=Rua>Rua</option>
            <option value=Avenida>Avenida</option>
            <option value=Praça>Praça</option>
            <option value=Alameda>Alameda</option>
            <option value=Estrada>Estrada</option>
          </select> </td>
        <td width="33%" class="main"><input name="txtaddress" type="text" id="endereco3" <? if(isset($clRua)){ echo "value='".$clRua."'";}?>> &nbsp;*</td>
      </tr>
      <tr> 
        <td class="main">E-Mail:</td>
        <td class="main"><input name="txtemail" type="text" id="email" <? if(isset($clEmail)){ echo " value='".$clEmail."'";}?>> &nbsp;* 
          <input name="imgPesqEmail" type="image" src="../imagens/pesq.gif" border="0" onClick='javascript:document.pesq=true;location="http://<? echo $_SERVER["SERVER_NAME"]; ?>/synapse/actor_ins.php"'></td>
        <td class="main">N&uacute;mero:</td>
        <td class="main"><input name="txtnumber" type="text" id="numero" size="8" <? if(isset($clNum)){ echo "value='".$clNum."'";}?>>*</td>
      </tr>
      <tr> 
        <td>Login:</td>
        <td><input name="txtlogin" type="text" id="login" <? if(isset($clLogin)){ echo " value='".$clLogin."'";}?>>*</td>
        <td>Complemento:</td>
        <td> <input name="txtcomplement" type="text" id="complemento" <? if(isset($clComplemento)){ echo "value='".$clComplemento."'";}?>> 
        </td>
      </tr>
      <tr> 
        <td class="main">Senha:</td>
        <td align="left" valign="middle" class="main"><input name="txtpassword" type="text" maxlength="40" <? if(isset($clPassword)){ echo " value='".$clPassword."'";}?>></td>
        <td class="main">Bairro:</td>
        <td class="main"> <input name="txtneighborhood" type="text" <? if(isset($clBairro)){ echo " value='".$clBairro."'";}?>>*</td>
      </tr>
      <tr> 
        <td class="main">Telefone:</td>
        <td class="main"><input name="txtphone" type="text"  <? if(isset($clTelefone)){ echo " value='".$clTelefone."'";}?>> &nbsp;*</td>
        <td class="main">CEP:</td>
        <td class="main"><input name="txtpostalcode" type="text" maxlength="10" <? if(isset($clCEP)){ echo " value='".$clCEP."'";}?>>*</td>
      </tr>
      <tr> 
        <td class="main">Celular:</td>
        <td class="main"><input name="txtcelphone" type="text"  <? if(isset($clCelTelefone)){ echo " value='".$clCelTelefone."'";}?>></td>
        <td class="main">Estado:</td>
		<td>
		<select name="txtstate" onChange=document.cadcli.submit()>
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
		</td>
      </tr>
      <tr> 
        <td class="main">Cidade:</td>
		<td colspan="2">
		<select name="txtcity">
		<?php
		if(isset($txtcity)){
			echo "<option value=".$txtcity." selected>".$txtcity."</option>";
		}elseif(isset($city)){
			echo "<option value=".$clCidade." selected>".$clCidadeNome."</option>";
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
	  </td>
      </tr>
      <tr> 
        <td colspan="2" class="main"><h2>Contato</h2></td>
        <td class="main">&nbsp;</td>
        <td class="main">&nbsp; </td>
      </tr>
      <tr> 
        <td class="main">Assunto:</td>
        <td class="main"><input name="assunto" type="text" id="assunto2"> </td>
        <td class="main">&nbsp;</td>
        <td class="main">&nbsp;</td>
      </tr>
      <tr> 
        <td class="main"><p>Mensagem:</p>
          <p> 
            <input name="imgCadContato" type="image" title=" Gravar " src="../imagens/gravar.gif" alt="Gravar" border="0" onClick='javascript:document.pesq=true;location="http://<? echo $_SERVER["SERVER_NAME"]; ?>/admin/lista.php"'>
            <br>
            <input name="imgEnvContato" type="image" title=" Enviar " src="../imagens/enviar.gif" alt="Enviar" width="60" height="18" border="0" onClick='javascript:document.pesq=true;location="http://<? echo $_SERVER["SERVER_NAME"]; ?>/admin/lista.php"'>
          </p></td>
        <td colspan="3" class="main"><textarea name="textcont" cols="55" rows="5" id="textarea2"></textarea></td>
      </tr>
      <tr> 
        <td colspan="4" class="main"> 
		  <input name="person_cod" type="hidden" value="<?php echo $person_cod; ?>">
	      <input type="hidden" name="acao" value="processa">
		  <input name="imgAtualizar" type="image" title=" Atualizar " src="../imagens/atualizar.gif" alt="Atualizar" width="60" height="18" border="0"> 
          <a href="http://<? echo $_SERVER['SERVER_NAME']; ?>/synapse/contact.php?cliCod=<? echo $codUsu; ?>"><img src="../imagens/contatos.gif" border="0" Alt="Contatos"></a> 
          <input name="imgPedido" type="image" title=" Pedidos " src="../imagens/pedidos.gif" alt="Pedidos" width="60" height="18" border="0"> 
          <a href="http://<? echo $_SERVER['SERVER_NAME']; ?>/synapse/etiq.php" target="_blank"><img src="../imagens/etiqueta.gif" border="0"></a> 
        </td>
      </tr>
    </table>
</form>
</div>
<div id="base">:: ENSCER - Ensinando o Cérebro :: <? echo date(Y);?> ::</div>
</body>
</html>