<?php
    session_start();

       ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
       include("includes/conecta.php");
       ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

if(!(session_is_registered('person'))){
	echo "erro";
	header('Location: ' . "http://" . $_SERVER["SERVER_NAME"]."/synapse/index.php");	
}

global $k, $i, $v;

if(isset($idiom) && $idiom=="7"){
$h1="Portal Enscer";
$h2="Bem Vindo:";
}

if(isset($idiom) && $idiom=="16"){
$h1="Portal Enscer";
$h2="Welcome:";
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
	if(isset($organization) && $organization!=""){
		
		//seleciona as organizações abaixo da organização do actor logado
		$SQL = "SELECT * FROM organization WHERE father_id = ".$organization." ORDER BY org_level";
		$res = pg_query($SQL);
		
		if(pg_num_rows($res)==0){
			$SQL = "SELECT * FROM organization WHERE org_level=".$org_level." ORDER BY org_level";
			$res = pg_query($SQL);
		}
		
		echo "<li class='titdest'>".$acronym."</li>";
		
		while($l_org = pg_fetch_array($res)){
			echo "<li class='dest'><a href='sysuser.php?org_menu=".$l_org['id']."'>".$l_org['name']."</a></li>";		
		}
		
	}
	
	echo "<li></li>";

	if(isset($unity_son) && $unity_son!=""){
	
		if($i==1){
		
			$unity_org=$unity_son;
			session_register('unity_org');
			$menu_org = array($k => $unity_org);
			$menu_org[$i] = $unity_org;
			session_register('menu_org');
			
			$SQL = "SELECT unity.organization_id, organization.acronym
					FROM unity
							LEFT JOIN organization ON organization.id = unity.organization_id
					WHERE unity.id = ".$unity_son."";

			$res = pg_query($SQL);
			$l_unity_son = pg_fetch_array($res);
		
			$SQLo = "SELECT * FROM organization WHERE father_id = ".$l_unity_son['organization_id'];
			$reso = pg_query($SQLo);		

			echo "<li class='titdest'>".$l_unity_son['acronym']."</li>";
				
			while($l_org_son = pg_fetch_array($reso)){
				echo "<li><a href='unity.php?i=".$i."&unity_son=".$unity_son."&org_menu=".$l_org_son['id']."'>".$l_org_son['name']."</a></li>";
			}
		}
	
		if($i>1){

			$unity_x=$unity_son;
			
			if(!in_array($unity_x, $menu_org)){
				$menu_org[$i] = $unity_x;	
			}

//			print_r(array_values ($menu_org));
//			$menu_org = array_slice($menu_org, 0, $i+1);
//			print_r(array_values ($menu_org));
	
			foreach($menu_org as $i => $v){
	
				//seleciona as organizações abaixo da unidade selecionada pelo actor logado
				$SQL = "SELECT unity.organization_id, organization.acronym
						FROM unity
								LEFT JOIN organization ON organization.id = unity.organization_id
						WHERE unity.id = ".$v."";

				$res = pg_query($SQL);
				$l_unity_son = pg_fetch_array($res);
				
				$SQLo = "SELECT * FROM organization WHERE father_id = ".$l_unity_son['organization_id'];
				$reso = pg_query($SQLo);
				
				if($i!=""){
					echo "<li></li>";
					echo "<li class='titdest'>".$l_unity_son['acronym']."</li>";
				}
					
				while($l_org_son = pg_fetch_array($reso)){
				
					if($i!=""){
						echo "<li><a href='unity.php?i=".$i."&unity_son=".$menu_org[$i]."&org_menu=".$l_org_son['id']."'>".$l_org_son['name']."</a></li>";
					}	
				}
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
	echo "<h2>".$h2." ".$personagename." ".$personname."</h2>";
    echo "<h3>".$unityname."</h3>";
	echo "<hr>";

	$i++;	

	//seleciona os dados da unity_son e da sua organização
	$SQL = "SELECT uni.*, org.name as org_name 
			FROM unity uni
					LEFT JOIN organization org ON org.id = uni.organization_id
			WHERE uni.id = ".$unity_son."";

	$res = pg_query($SQL);
	$l_unity_son = pg_fetch_array($res);
	$unity_name = $l_unity_son['name'];
	$org = $l_unity_son['organization_id'];
	$org_name = $l_unity_son['org_name'];

	echo "<h2>".$org_name." - <a href='unityins.php?unity_cod=".$unity_son."' target='_blank'>".$unity_name."</a></h2>";
	
	echo "<h3><a href='performance.php?unity_sel=".$unity_son."&unity_name=".$unity_name."'> Clique aqui </a>para gera um relatório de performance do atores dessa unidade.</h3>";
	
	if($personage_grant==1){
		echo "<h3><a href='actorins.php?unity_cod=".$unity_son."' target='_blank'>Clique Aqui</a> para inserir um novo ator</h3>";
	}
	
	echo "<hr>";
	
		//seleciona os personagens dos atores da organização da unity_son
		$SQLp = "SELECT DISTINCT personage.id, personage.name
				FROM personage
						LEFT JOIN actor ON actor.personage_id = personage.id 
				WHERE actor.unity_id = ".$unity_son."";
		$resp =pg_query($SQLp);
	
		while ($l_personage = pg_fetch_array($resp)){
			echo "<h3>".$l_personage['name']."</h3>";
			
			//seleciona os atores de cada personagem
			$SQLa = "SELECT actor.*, person.name
					FROM actor
							LEFT JOIN person ON person.id = actor.person_id
					WHERE actor.unity_id = ".$unity_son." AND
						  personage_id = ".$l_personage['id']."";
			$resa = pg_query($SQLa);
			
			while ($l_actor = pg_fetch_array($resa)){
				echo "<p><a href='actor.php?menu_org=".$menu_org."&i=".$i."&unity_son=".$unity_son."&actor_cod=".$l_actor['id']."'>".$l_actor['name']."</a></p>";
			}
		}
		echo "<hr>";
		
		if($personage_grant==1){
			echo "<h3><a href='orgins.php' target='_blank'>Clique Aqui</a> para inserir nova classe na organização</h3>";
			echo "<hr>";
		}	
		
		//seleciona as organizações abaixo da organização da unity_son
		$SQLo = "SELECT * FROM organization WHERE father_id = ".$org."";
		
		if(isset($org_menu) && $org_menu!=""){
			$SQLo .=" AND id=".$org_menu.";";		
		}
		$reso = pg_query($SQLo);

		while($l_org = pg_fetch_array($reso)){
			echo "<h3>".$l_org['acronym'].($personage_grant==1?" - <a href='unityins.php?i=".$i."&organization_cod=".$l_org['id']."' target='_blank'>Inserir nova Unidade</a></h3>":"</h3>");
			
			//seleciona as unidades das organizações abaixo da organização da unity_son
			$SQLu = "SELECT * FROM unity WHERE organization_id = ".$l_org['id']." AND father_id=".$unity_son."";
			$resu = pg_query($SQLu);
			//echo $SQLu;		
			
			while($l_unity = pg_fetch_array($resu)){

				if($l_unity['father_id']!=""){

					if($l_unity['father_id']==$unity_son){

						echo "<p><a href='unity.php?menu_org=".$menu_org."&i=".$i."&unity_son=".$l_unity['id']."'>".$l_unity['name']."</a></p>";
					}
				}elseif($l_untiy['father_id']==""){

					echo "<p><a href='unity.php?menu_org=".$menu_org."&i=".$i."&unity_son=".$l_unity['id']."'>".$l_unity['name']."</a></p>";
				}
			}//while($l_unity = pg_fetch_array($resu)){

			$SQLa = "SELECT * FROM unity WHERE organization_id = ".$l_org['id']." AND father_id=".$unity_son."";
			$resa = pg_query($SQLa);
			$count = 0;
			while ($row[$count] = pg_fetch_assoc($resa)){
				$count++;
			}
			
			if($count==0){
			
				//seleciona as organizações abaixo das organizações sem unidades que estão abaixo da organização da unity_son
				$SQLoo = "SELECT * FROM organization WHERE father_id = ".$l_org['id']."";
				$resoo = pg_query($SQLoo);
				//echo $SQLoo;
				
				while($l_org_org = pg_fetch_array($resoo)){
					//selecion as unidades das organizações selecionadas acima<strong></strong>
					$SQLou = "SELECT * FROM unity WHERE organization_id = ".$l_org_org['id']."";
					$resou = pg_query($SQLou);
					while($l_org_unity = pg_fetch_array($resou)){
						echo "<p><a href='unity.php?menu_org=".$menu_org."&i=".$i."&unity_son=".$l_org_unity['id']."'>".$l_org_unity['name']."</a></p>";
					}
				}//while($l_org_org = pg_fetch_array($resoo)){
			}//if($count==0){
		}//while($l_org = pg_fetch_array($reso)){
		
?>
</div>
<div id="base"><?php echo $base.date('Y');?> ::</div>
</body>
</html>