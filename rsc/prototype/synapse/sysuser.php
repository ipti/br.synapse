<?php
session_start();

ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
include("includes/conecta.php");
ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

if(!(session_is_registered('person'))){
	echo "erro";
	header('Location: ' . "http://" . $_SERVER["SERVER_NAME"]."/synapse/index.php");	
}

//Historico de Navega��o
if (!session_is_registered('navegacao')) {
	session_register('navegacao');
	global $navegacao;
//$navegacao = new navigationHistory;
}

if(isset($idiom) && $idiom=="7"){
$h1="In�cio";
$h2="Bem Vindo:";
$newsa="Not�cias Atuais da Organiza��o";
$newsb="Not�cias Atuais da Organiza��o abaixo";
}

if(isset($idiom) && $idiom=="16"){
$h1="Home";
$h2="Welcome:";
$newsa="Actual News of the Organization";
$newsb="Actual News of the Below Organization";
}

if(isset($idiom) && $idiom=="17"){
$h1="Haus";
$h2="Willkommen:";
$newsa="Eigentlich �berblick von di Organisation";
$newsb="Eigentlich �berblick von die unten Organisation";
}

global $i;

	if(isset($regactor) && $regactor==true){
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
?>	  
<div id='col1'>

<?php
	ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
    include("includes/menu.php");//?idiom=".$idiom."
    ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
?> 

<div id="menu2acesso"> 
  <ul>
    <strong> 
<?php
	if($personage==1){
		if(isset($organization) && $organization!=""){
			//seleciona as organiza��es abaixo da organiza��o do actor logado
			$SQL = "SELECT * FROM organization WHERE father_id = ".$organization." ORDER BY org_level";
			$res = pg_query($SQL);
			
			if(pg_num_rows($res)==0){
				$SQL = "SELECT * FROM organization WHERE org_level='".$org_level."' ORDER BY org_level";
				$res = pg_query($SQL);
			}
			
			echo "<li class='titdest'>".$org_acronym."</li>";
			
			while($l_org = pg_fetch_array($res)){
				echo "<li class='dest'><a href='sysuser.php?org_menu=".$l_org['id']."'>".$l_org['name']."</a></li>";		
			}
		}	
	}
?>
    </strong> 
  </ul>
</div>

</div>

<div id='coltripla'>
  <h1><?php echo $h1; ?></h1>
<?php 
	echo "<h2>".$h2.(isset($personagename)?$personagename:"").$personname."</h2>";
 	echo "<h3>".(isset($organizationname)?$organizationname:"").(isset($unityname)?" - ".$unityname:"")."</h3>";
	echo "<hr>";
	
	if(isset($proj) && $proj==3){
		?>
<h3>DETALHAMENTO DO PROJETO</h3>
<p>1-  Estimativa da Influ�ncia dos Dist�rbios de Aprendizagem nos �ndices de Desempenho Escolar em L�ngua, Matem�tica e Inicia��o � Ci�ncia;</p>
<p>2- Estudo da Influ�ncia da Tecnologia dos Meios de Testagem no Resultado Final de Testes de Desempenho em L�ngua, Matem�tica e Inicia��o � Ci�ncia - Influ�ncia da Tecnologia em Testes de Avalia��es Padronizadas; </p>
<p>3- Estudo da rela��o entre o Desempenho Escolar em L�ngua e Matem�tica e Inicia��o � Ci�ncias - Desempenho escolar e Livro Did�tico;</p>
<p>4- Produ��o de Materiais Formativos e Instrucionais que contemplem o Enfrentamento das Dificuldades de Aprendizagem, como Dislexia, Discalculia, Deficit de Aten��o e Hiperatividade, no processo de forma��o do professor pesquisador.</p>
		<?
	}
	
if(isset($personage_grant) && $personage_grant==1){
	echo "<h3><a href='org_ins.php' target='_blank'>Clique Aqui</a> para inserir nova classe na organiza��o</h3>";
	echo "<hr>";
}
	
if(isset($org_menu) && $org_menu!=""){	

	//seleciona as organiza��es que tem como org_father a organiza��o do usuario logado
	$SQL = "SELECT * FROM organization WHERE id=".$org_menu."";
	$res = pg_query($SQL);
				
	if(pg_num_rows($res)==0){
		$SQL = "SELECT * FROM organization WHERE org_level=".$org_level."";
		$res = pg_query($SQL);
	}
	
	while($l_org_son = pg_fetch_array($res)){
	$i++;	
		echo "<h3>".$l_org_son['acronym'].($personage_grant==1?" - <a href='unity_ins.php?org=".$l_org_son['id']."' target='_blank'>Inserir nova Unidade</a></h3>":"</h3>");
		
		//seleciona as unidades das organiza��es que est�o abaixo da organiza��o do usuario logado
		$SQLu = "SELECT * FROM unity WHERE organization_id = ".$l_org_son['id']." AND father_id=".$unity.""; //
		$resu = pg_query($SQLu);		

		while($l_unity = pg_fetch_array($resu)){
			echo "<p><a href='unity.php?i=".$i."&unity_son=".$l_unity['id']."'>".$l_unity['name']."</a></p>";
		}
		
		if(pg_num_rows($resu)==0){
			//seleciona as demais organiza��es que est�o no mesmo nivel da organiza��o do usuario logado
			$SQL = "SELECT * FROM organization WHERE father_id = ".$org_father." AND org_level = ".$org_level."";
			$res = pg_query($SQL);

			
			if(pg_num_rows($res)>0){
		
				while($l_org_son = pg_fetch_array($res)){

					echo "<h3>".$l_org_son['acronym']."</h3>";
					
					//seleciona as unidades das demais organiza��es que est�o no mesmo n�vel da organiza��o do usuario logado
					$SQLu = "SELECT * FROM unity WHERE organization_id = ".$l_org_son['id']."";
					$resu = pg_query($SQLu);		
					
					while($l_unity = pg_fetch_array($resu)){
						echo "<p><a href='unity.php?i=".$i."&unity_son=".$l_unity['id']."'>".$l_unity['name']."</a></p>";
					}
					
					if(pg_num_rows($resu)==0){
				
						//se a organiza��o n�o tem unidades seleciona as organiza��o abaixo da org_son
						$SQLo = "SELECT * FROM organization WHERE father_id = ".$l_org_son['id']."";
						$reso = pg_query($SQLo);
					
						while($l_org_org = pg_fetch_array($reso)){

							//seleciona as unidades das organia��oes que est�o abaixo da org_son
							$SQLou = "SELECT * FROM unity WHERE organization_id = ".$l_org_org['father_id']."";
							$resou = pg_query($SQLou);
							while($l_org_unity = pg_fetch_array($resou)){
								echo "<p><a href='unity.php?i=".$i."&unity_son=".$l_org_unity['id']."'>".$l_org_unity['name']."</a></p>";
							}
						}
					}
				}
			}
			/*
			//se a organiza��o n�o tem unidades seleciona as organiza��o abaixo da org_son
			$SQLo = "SELECT * FROM organization WHERE org_father = ".$l_org_son['organization']."";
			$reso = pg_query($SQLo);

			while($l_org_org = pg_fetch_array($reso)){
			$i++;
				//seleciona as unidades das organia��oes que est�o abaixo da org_son
				$SQLou = "SELECT * FROM unity WHERE organization = ".$l_org_org['organization']."";
				$resou = pg_query($SQLou);

				while($l_org_unity = pg_fetch_array($resou)){
					echo "<p><a href='unity.php?i=".$i."&unity_son=".$l_org_unity['unity']."'>".$l_org_unity['name']."</a></p>";
				}
			}*/
		}
	}
}elseif(isset($organization) && $organization!=""){

   //Noticias Atuais da Organiza��o
  $SQL = "SELECT news.* 
  		  FROM news 
		  WHERE (organization=".$organization.") AND 
		  	    (org_son=0) AND 
				(news.state=1) 
		  ORDER BY modifieddate DESC;";
  $res = pg_query($SQL);
 // if(mysql_num_rows($res)>0){
  	  echo "<h3>".$newsb."</h3>";
	  echo "<ol>";
	  while($linha=pg_fetch_array($res)){
		echo "<li><strong>".$linha['title']."</strong>: ".$linha['body']."</li>";
	  }
	  echo "</ol>";
 // }	
  
 //Noticias Atuais da Organiza��o abaixo
  $SQL = "SELECT news.* 
  		  FROM news 
		  		LEFT JOIN organization on organization.id=news.organization
  		  WHERE (organization.org_level<=".$org_level.") AND 
		  		(news.state=1) AND
				(news.org_son=1)
		  ORDER BY modifieddate DESC;";
  $res = pg_query($SQL);

 // if(mysql_num_rows($res)>0){
      echo "<h3>".$newsb."</h3>";
	  echo "<ol>";
	  while($linha=pg_fetch_array($res)){
		echo "<li><strong>".$linha['title']."</strong>: ".$linha['body']."</li>";
	  }
	  echo "</ol>";
 // }
	
	echo "<hr>";
}
?>
</div>
<div id="base"><?php echo $base.date('Y');?> ::</div>
</body>
</html>