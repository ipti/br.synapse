<?php
session_start();

ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
include("includes/conecta.php");
ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
require("includes/funcoes.php");
ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

if(!isset($proj) || (isset($proj) && $proj!=2)){
	$title=":: ENSCER - Ensinando o Cérebro :: Portal Enscer";
	session_register('title');
	$logo="logo_enscer.gif";
	session_register('logo');
	$base=":: ENSCER - Ensinando o Cérebro :: ";
	session_register('base');
}else{
	session_unregister('title');
	$title="Desempenho Escolar Inclusivo";
	session_register('title');
	session_unregister('logo');
	$logo="logo_capes.jpg";
	session_register('logo');
	session_unregister('base');
	$base=":: Desempenho Escolar Inclusivo :: ";
	session_register('base');
}

if(isset($idioma)){
	$idiom=$idioma;
	session_register('idiom');
}elseif(!isset($idiom)){
	$idiom="7";
	session_register('idiom');
}

if(isset($idiom) && $idiom=="7"){
	if(isset($proj) && $proj==3){
		$h1="";
		$h2="OBSERVATÓRIO DA EDUCAÇÃO – EDITAL 2010<br>Fomento a Estudos e Pesquisas em Educação<br>EDITAL Nº 038/2010/CAPES/INEP";
	}else{
		$h1="Portal Enscer";
		$h2="Bem Vindos ao Portal do Enscer!!!";		
	}
	$h3="Caso j&aacute; seja cadastrado, entre com seus dados:";
	$h3a="Caso contrário, <a href='person_ins.php'>faça o seu cadastro!</a>";
	$user="Usuário";
	$pass="Senha";
	$button="Enviar";
}

if(isset($idiom) && $idiom=="16"){
$h1="Portal Enscer";
$h2="Welcome to the Enscer";
$h3="If you are registered, make your login:";
$h3a="Otherwise, <a href='person_ins.php'>do your registration!</a>";
$user="User";
$pass="Password";
$button="Send";
}

if(isset($idiom) && $idiom=="17"){
$h1="Portal Enscer";
$h2="Willkommen auf der Enscer";
$h3="Wenn sind sie registriert, machen sie seine Login:";
$h3a="Caso contrário, <a href='person_ins.php'>faça o seu cadastro!</a>";
$user="Emails";
$pass="Passwort";
$button="Senden";
}

	if((isset($txtuser) && $txtuser!="") && (isset($txtsenha) && $txtsenha!="")){
	    
		$SQL = "SELECT * FROM login WHERE login='" . $txtuser . "'";
		$res=pg_query($SQL);
		$l_login = pg_fetch_array($res);

		if($l_login!=""){	
		
		    if($l_login['password'] != $txtsenha){
		
		        session_start();
    			session_destroy();
    			session_start();
				echo "<script> window.location='index.php?wrongpass=true'; </script>";
					
		    }elseif($l_login['password'] == $txtsenha){
			
				$person = $l_login['person_id'];
				session_register('person');
				$login = $txtuser;
				session_register('login');
				$password = $txtsenha;
				session_register('password');

				echo "<script> window.location='index.php?login=true'; </script>";
				
			}
		}else{
			echo "<script> window.location='index.php?wronguser=true'; </script>";
		}			
	}
								
	if(isset($txtemail) && $txtemail!=""){

		$SQL = "SELECT password FROM login WHERE login='".$txtemail."';";
		$res = pg_query($SQL);
		$linha=pg_fetch_array($res);		

		if($linha!=""){		
		
			$headers  = "MIME-Version: 1.0\n";
			$headers .= "Content-Type: text/html; charset=iso-8859-1\n";
			$headers .= "From: Contato Enscer <contato@enscer.com.br>\n";
			$headers .= "Return-Path: Contato Enscer <contato@enscer.com.br>\n"; 
			$emailsender = "contato@enscer.com.br";
			if(mail($linha['login'], "Envio de Senha", "Sua senha de acesso ao Portal ENSCER é: ".$linha['password']."\r\n\r\nATENÇÃO: Não responda esse e-mail. Utilize a página de Contatos do Portal: www.enscer.com.br/synapse", $headers)){
				$mail=true;
			}else{
				$erro=true;
			}
		}else{
		$userro=true;
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
	  
if(isset($login) && $login==true){

	echo "<div id='col1'><a href='index.php'><img src='images/portal_enscer.gif' border='0'></a></div>";	
	echo "<div id='coltripla'>";
    echo "<h1 align='center'>".$h1."</h1>";
	   	
	$SQL = "SELECT person.* FROM person WHERE id = ".$person."";
	$res = pg_query($SQL);
	$l_person = pg_fetch_array($res);

	$personname = $l_person['name'];
	session_register('personname');
	$email = $l_person['email'];
	session_register('email');
	$birthday = $l_person['birthday'];
	session_register('birthday');
	$nationality = $l_person['nationality_id'];
	session_register('nationality');
	$addresstype = $l_person['address_type'];
	session_register('addresstype');
	$address = $l_person['address'];
	session_register('address');
	$number = $l_person['number'];
	session_register('number');
	$complement = $l_person['complement'];
	session_register('complement');
	$postalcode = $l_person['postalcode'];
	session_register('postalcode');
	$city = $l_person['city_id'];
	session_register('city');
	$cityname = $l_person['c_name'];
	session_register('cityname');
	$state = $l_person['state_id'];
	session_register('state');
	$country = $l_person['country_id'];
	session_register('country');
	$phone = $l_person['phone'];
	session_register('phone');
	$celphone = $l_person['celphone'];
	session_register('celphone');
	$persontype = $l_person['persontype'];
	session_register('persontype');

	if($persontype==1){
		$SQL = "SELECT * FROM human WHERE person = ".$person."";
		$res = pg_query($SQL);
		$l_human = pg_fetch_array($res);
		$sex = $l_human['sex'];
		session_register('sex');
	}
	
	$SQLa = "SELECT * FROM actor WHERE person_id = ".$person."";
	$r_actora = pg_query($SQLa);
	$count = 0;

	while ($row[$count] = pg_fetch_assoc($r_actora)){
		$count++;
	}
	
	if(($count)>1){		
		echo "<h2>".($sex=='m'?'Bem vindo ':'Bem vinda: ') .$personname."</h2>";
		echo "<h3>Escolha o seu acesso:</h3>";
	}
	
	$SQL = "SELECT * FROM actor WHERE person_id = ".$person."";
	$r_actor = pg_query($SQL);	

	while($l_actor = pg_fetch_array($r_actor)){

		$actor = $l_actor['id'];
		$unity = $l_actor['unity_id'];
		$personage = $l_actor['personage_id'];
		$activated = $l_actor['activated'];
		$deactivated = $l_actor['deactivated'];
		
		$SQL = "SELECT * FROM unity WHERE id = ".$unity."";
		$res = pg_query($SQL);
		$l_unity = pg_fetch_row($res);
		$unityname = $l_unity['name'];
		$unity_level = $l_unity['4'];
		
		$SQLp = "SELECT * FROM personage WHERE id = ".$personage."";
		$resp = pg_query($SQLp);
//		echo $SQLp;
		$l_personage = pg_fetch_row($resp);
//echo "linha".$l_personage['organization_id'];
//echo "linha".$l_personage['name'];
//echo "linha".$l_personage['id'];
		$personagename = $l_personage['name'];
		$organization = $l_personage['organization_id'];
//echo "organization:".$organization;
		$SQL = "SELECT * FROM organization WHERE id = ".$organization."";
		$res = pg_query($SQL);
//		echo $SQL;
//		exit;
		$l_organization = pg_fetch_array($res);
		$organizationname = $l_organization['name'];
		$org_acronym = $l_organization['acronym'];
		$org_father = $l_organization['father_id'];
		$org_level = $l_organization['org_level'];
			
		echo "<p><a href='sysuser.php?regactor=true&actor=".$actor."&actor_father=".$actor_father."&actor_level=".$actor_level."&actorname=".$actorname."&unity=".$unity."&unity_father=".$unity_father."&unity_level=".$unity_level."&personage=".$personage."&activated=".$activated."&deactivated=".$deactivated."&unityname=".$unityname."&personagename=".$personagename."&organization=".$organization."&personage_level=".$personage_level."&personage_grant=".$personage_grant."&organizationname=".$organizationname."&org_acronym=".$org_acronym."&org_level=".$org_level."&org_father=".$org_father."'>".$personagename." - ".$organizationname."</a></p>";				
		}
	
		if(($count)==1){
			session_register('actor');
			session_register('actor_father');
			session_register('actor_level');
			session_register('actorname');
			session_register('unity');
			session_register('unity_father');
			session_register('unity_level');
			session_register('personage');
			session_register('activated');
			session_register('deactivated');
			session_register('unityname');
			session_register('personagename');
			session_register('organization');
			session_register('personage_level');
			session_register('personage_grant');
			session_register('organizationname');
			session_register('org_acronym');
			session_register('org_father');
			session_register('org_level');
			
			setcookie('personnameCook',$personname,time()+60*60*24*30, $cookie_path, $cookie_domain);
			setcookie('passwordCook',$password,time()+60*60*24*30, $cookie_path, $cookie_domain);
			setcookie('personCook',$person,time()+60*60*24*30, $cookie_path, $cookie_domain);

			//Historico de Navegação
			if(!session_is_registered('navegacao')) {
				session_register('navegacao');
				global $navegacao;
			}

			if(isset($pedido) && $pedido==true){
				redireciona("http://". $_SERVER['SERVER_NAME'] . "/synapse/fechapedido.php");
			}else{
				echo "<script> window.location='sysuser.php'; </script>";
			}
		}
		
		if(($count)==0){
			echo "<script> window.location='index.php'; </script>";
		}
}

echo "</div>";
echo "<div id='col1'>";
	if(isset($proj) && $proj==3){
		echo "<a href='index.php'><img src='images/portal_capes.jpg' border='0'></a></div>";	
	}else{
		echo "<a href='index.php'><img src='images/portal_enscer.gif' border='0'></a></div>";	
	}

echo "<div id='coltripla'>";	

?>   
  <h1 align="center"><?php echo $h1; ?></h1>
  <h2 align="center"><?php echo $h2; ?></h2>
  <h3><?php echo $h3; ?></h3>
  
<?php
    if(isset($wrongpass) && $wrongpass){
  		echo "<h2><font color=red>Senha Não Confere!</font></h2>";
  	}
  	if(isset($wronguser) && $wronguser){
  		echo "<h2><font color=red>Usuário Desconhecido!</font></h2>";
  	}
	
	if((!isset($proj)) || (isset($proj) && $proj!=3)){
		echo '<h3><font color="#FF0000">ATENÇÃO: Se você é do Projeto Capes e foi redirecionado para cá, por favor, <a href="../capes/index.php">Clique Aqui!</a></font></h3>';
	}
?>
  <form name="form1" method="post" action="index.php" >
    <table width="368" border="0">
      <tr>
        <td width="17%"><h3><?php echo $user; ?>:</h3></td>
        <td colspan="2"><input type="text" name="txtuser"></td>
      </tr>
      <tr>
        <td><h3><?php echo $pass; ?>:</h3></td>
        <td width="42%"><input type="password" name="txtsenha"></td>
        <td width="41%"><input name="sub" type="submit" value="<?php echo $button ?>" width="60" height="15" border="0"></td>
      </tr>
    </table>
	<?php echo "<h3>".$h3a."</h3>"; 
		if(isset($msg)){
			echo $msg;
		}else{
	?>
		
    <hr>
	<?php } ?>
	  <table>
	  <tr>
        <td colspan="2"><font color="red"><strong>Não sei minha Senha!</strong></font> 
          <br>
          Preencha seu e-mail e clique em enviar. </td>
      </tr>
	<tr>
    <td width="210"><input name="txtemail" type="text" size="35"></td>
    <td width="660"><input name="mail" type="image" src="images/enviar.gif" width="60" height="18" border="0"></td>
    </tr>
    </table>
	<?php if(isset($mail) && $mail==true){
	  	echo "<h3>Você receberá sua senha no endereço de e-mail cadastrado!</h3>";
	  }elseif(isset($userro) && $userro==true){
	  	echo "<h3>Não foi encontrado um usuário com o e-mail preenchido!</h3>";
	  }elseif(isset($erro) && $erro==true){
	  	echo "<h3>Ocorreu um erro na tentativa de enviar a mensagem para o seu e-mail. Tente novamente!</h3>";
	  }
	 ?>
	<hr>
	  <table width="90%">
	  <tr>
        <td><font color="red"><strong>Não sei meu Usuário!</strong></font><br>
          Seu usu&aacute;rio &eacute; o seu endere&ccedil;o de email. Caso n&atilde;o 
          funcione, envie-nos uma <a href="mailto:contato@enscer.com.br?Subject=Solicitação de Usuário" class="link">mensagem</a> 
          com seu nome completo.</td>
      </tr>
	  </table>
    </form>
</div>
<div id="base"><?php echo $base.date('Y');?> ::</div>
</body>
</html>