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
$h1="Notícias";
$h2="Bem Vindo:";
}

if(isset($idiom) && $idiom=="16"){
$h1="News";
$h2="Welcome:";
}
     
?>
<html>
<head>
<script language="javascript"><!--

var form = "";
var submitted = false;
var error = false;
var error_message = "";

function check_txt(field_name, field_default, message) {
	if (form.elements[field_name] && (form.elements[field_name].type != "hidden")) {
   		var field_value = form.elements[field_name].value;
   		if (field_value == field_default) {
      		error_message = error_message + "* " + message + "\n";
      		error = true;
    	}
  	}
}

function check_select(field_name, field_default, message){
  if (form.elements[field_name] && (form.elements[field_name].type != "hidden")){
    var field_value = form.elements[field_name].value;
    if (field_value == field_default) {
      error_message = error_message + "* " + message + "\n";
      error = true;
    }
  }
}
	
function check_form(form_name) {
    error = false;
    form = form_name; 
    error_message = "Erros ocorreram durante o envio de seu formulário.\n\nPor favor, faça as seguintes correções:\n\n";
    
    check_select("cmbPeriodos", "0", "Escolha um Plano de Ensino");
	check_txt("txtDesc","","Preencha o Desempenho");
	
    if (error == true) {
      alert(error_message);
	  return false;
    }
}

function filtra(cod) {
	    if (error == false) {
			document.forms["noticias"].filtragem.value = cod;
			if(cod==1){
				document.forms["noticias"].submit();
			}
		    return true;			
		}else{
		    return false;
		}
};
//--></script>
<title>:: ENSCER - Ensinando o c&eacute;rebro ::</title>
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
<div id=coltripla>
  <h1><?php echo $h1?></h1>
<?php 
	echo "<h2>".$h2.(isset($personagename)?$personagename:"").$personname."</h2>";
 	echo "<h3>".(isset($organizationname)?$organizationname:"").(isset($unityname)?" - ".$unityname:"")."</h3>";
	echo "<hr>";
	
if(isset($personage_grant) && $personage_grant==1){
	
    	echo '<form name="noticias" action="news.php" method="post" onSubmit="return check_form(noticias);">';
	
		echo "<h3>Escolha a Organização";
  		echo "<select name='news_org' onChange=filtra(1)>";
        echo "<option value=0 ".($linha['org']<=0?"selected":"")."></option>\n";
        
  			$SQL = "SELECT organization.*
  					FROM organization 
  					WHERE organization.org_level>".$org_level." 
					ORDER BY organization.org_level;";
  			
  			$res=pg_query($SQL) or die(mysql_error()." Erro ao Filtrar dados regional" . $SQL );
				while($linha=pg_fetch_row($res)){
					echo "<option value=".$linha['0'].">".$linha['1']."</option>\n";
				}

       echo "</select></h3>";
       echo "<INPUT type=hidden value=0 name=filtragem>";

  		if(isset($filtragem) && $filtragem==1){		
  			//session_register('classe');
  			$SQL = "SELECT organization.* FROM organization WHERE organization.organization=".$news_org.";";
  			$res=pg_query($SQL);
  			$linha = pg_fetch_row($res);

			echo "<h3>Inserir nova Notícia para a Organização ".$linha['1'].", <a href='news.php?filtragem=2&news_org=".$news_org."&news_orgname=".$linha['1']."'>Clique Aqui</a></h3>";
			echo "<hr>";
			
			$SQL = "SELECT news.* 
					FROM news 
					WHERE news.organization=".$news_org." ORDER BY modifieddate DESC;";
					
			$res=pg_query($SQL);
			
			//if(mysql_num_rows($res)>0){
			
                while($linha=pg_fetch_row($res)){
                    echo "<p><a href=news.php?news=".$linha['0']." class='link'>".$linha['2']." | ".formatadata($linha['initialdate'], "d/m/Y")."</a> - ".($linha['8']==1?"Atual":"Anterior")."</p>";
                }
				
			//}else{
			//	echo "<h3><font color='red'>Não há nenhuma notícia registrada para essa Organização.</font></h3>";
			//}
  		}
  		
	  if(isset($filtragem) && $filtragem==2){
		  echo "<hr>";
		  echo "<h3>Inserindo uma nova notícia para a Organização:".$news_orgname."</h3>";
		  echo "<h3>Incluir todas as organizações abaixo:";
		  
		  echo "<input type='checkbox' name='org_son'></h3>";
		  
		  echo "<h3>Título: <input type='text' name='title'>";

		  $SQL = "SELECT * FROM organization WHERE organization = ".$news_org."";
		  $res = pg_query($SQL);
		  $linha = pg_fetch_row($res);
		  $news_orglevel = $linha['4'];
		  
		  echo "Personagem: <select name='news_personage'>";
			  
			  $SQL = "SELECT personage.* 
					  FROM personage 
							LEFT JOIN organization on organization.organization=personage.organization
					  WHERE organization.organization = ".$news_org.";";
					  
			  $res=pg_query($SQL); 
			  while($linha=pg_fetch_row($res)){
				echo "<option value=".$linha['0'].">".$linha['1']."</option>";
			  }
			
		  echo "</select></h3>";

		  echo "<textarea name='body' cols='67' rows='10'>".((isset($body) && $body!="")?$body:"")."</textarea>";
		  
		  echo "<input type='hidden' value='".$news_org."' name='news_ins'>";
		  echo "<input type='hidden' value='".$news_orglevel."' name='news_org_level'>";
				  
		  echo "<input name='imgGravar' value='true' id='sub' type='image' title='Gravar' src='../../../../imagens/gravar.gif' alt='Gravar' width='60' height='18' border='0' onClick=filtra(3)>";
	
      } 
	  
 if(isset($filtragem) && ($filtragem==3 || $filtragem==4)){
  	
  	 if((isset($filtragem) && $filtragem==3)){

		$SQL = "INSERT INTO news 
				SET title='".$title."', body='". $body ."', organization=".$news_ins.", 
					org_son=".(isset($org_son)?1:0).", initialdate=now(), modifieddate=now(), state=1";

		$res=pg_query($SQL) or die($SQL ."#". mysql_error());
		$filtragem=1;
		echo '<input type="hidden" value="'.$news_org.'" name="news_org">';
	}
  
  	if((isset($filtragem) && $filtragem==4)){
	
  		$SQL = "UPDATE news 
				SET title='".$title."', body='".$body."', state='".$state."', 
					modifieddate=now() WHERE news=".$news_ins.";";
					
  		$res = pg_query($SQL);
  		$filtragem=1;
  	}
  		
		$SQL = "SELECT person.name, person.email
				FROM person
						LEFT JOIN actor on actor.person=person.person
						LEFT JOIN personage on personage.personage=actor.personage
						LEFT JOIN organization on organization.organization=personage.organization";
				
				if(!isset($org_son)){				
					$SQL .= " WHERE organization.organization=".$news_ins."";
				}else{
					$SQL .= " WHERE organization.org_level>=".$news_org_level."";
				}
				
		$res=pg_query($SQL);
		
			while($linha=pg_fetch_row($res)){
				echo $linha['email']."<br>";
//				mail($linha['email'], $title, ($filtragem==3?"Há uma nova Notícia no Portal ENSCER:":"A seguinte notícia no Portal ENSCER foi modificada:")." \n\n " . $body . " \n\nATENÇÃO: Não responda esse e-mail. Acesse www.enscer.com.br/synapse/ e utilize a página de Contatos do Portal.", "FROM: Enscer<contato@enscer.com.br>\r\n");
			}
 }
 
   		if(isset($news)&&$news>0){
  			$SQL = "SELECT news.* FROM news WHERE news=".$news;
  			$res=pg_query($SQL);
  			$linha=pg_fetch_row($res);

  		echo "<hr><h3>Editando uma Notícia da Organização ".$organizationname."</h3>";
        echo '<h3>Título: <input name="title" type="text" value="'.$linha['2'].'">
  		    Situação: <input type="radio" name="state" value="1"'; if($linha['8']==1){echo "checked";} echo '>Atual 
				      <input type="radio" name="state" value="2"'; if($linha['8']==2){echo "checked";} echo '>Anterior</h3>';
		echo '<textarea name="body" cols="67" rows="10">'.$linha['3'].'</textarea>';
      	echo '<input name="imgAtualiza" value=true id="sub" type="image" title=" Atualizar " src="../../../../imagens/atualizar.gif" alt="Atualizar" width="60" height="18" border="0" onClick=filtra(4)>';
      	echo '<input type="hidden" value="'.$news.'" name="news_ins">';

		}

  	echo "</form>";
}
?>
</div>
<div id="base"><?php echo $base.date('Y');?> ::</div>
</body>
</html>