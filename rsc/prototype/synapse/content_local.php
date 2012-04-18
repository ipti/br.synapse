<?php

//Define where you have placed the phptreeview folder.
define("TREEVIEW_SOURCE", "../phptreeview/");	 

include(TREEVIEW_SOURCE."treeviewclasses.php"); //Include the phptreeview engine.

session_start();

$xajax = new xajax(); 
include(TREEVIEW_SOURCE."ajax/ajax.php");	//Enables real-time update. Must be called before any headers or HTML output have been sent.
$xajax->processRequests();

//Define identify name(s) to your treeview(s); Add more comma separated names to create more than one treeview. The treeview names must always be unique. You can´t even use the same treeview names on different php sites. 
$treeviewid = array("treeviewhttpvariables");

include(TREEVIEW_SOURCE."treeviewcreate.php"); //Creates phptreeview objects.
	
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
	$SQL = "UPDATE activitycontent SET description = '".$txtdescription."' WHERE id = ".$content_id."";
	$res = pg_query($SQL);
}
if(isset($upddescriptiongoal)){
	$SQL = "UPDATE goal SET description = '".$txtdescriptiongoal."' WHERE id = ".$goal_id."";
	$res = pg_query($SQL);
}

?>

<html>
<head>

	<title><?php echo $title; ?></title>

	<link href="synapse.css" rel="stylesheet" type="text/css">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

	<script language="javascript">
	<!--
	var form = "";
	var submitted = false;
	var error = false;
	var error_message = "";
	
	function check_form(form) {
	  if (submitted == true) {
		alert("Este formulário já foi enviado. Por favor pressione OK e aguarde o processo ser completado.");
		return false;
	  }
	}
	//-->
	</script>

</head>
<body>
<?php

//	if(!isset($content_id)){

	ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
    include("includes/topo.php");
    ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
?>

<div id='col1'>
<?php
	if(isset($proj) && $proj==2){
		echo '<a href="sysuser.php"><img src="images/portal_capes.jpg" border="0"></a>';
	}else{
		echo '<a href="sysuser.php"><img src="images/portal_enscer.gif" border="0"></a>';
	}
	echo "<h3 align='center'><a href='content.php?discname=Habilidades&content_father=11'>Habilidades</a></h3>";
	
	echo "<h2>Disciplinas</h2>";
	$SQLd = "SELECT * FROM discipline ORDER BY id";
	$resd = pg_query($SQLd);
	while($linhad=pg_fetch_array($resd)){
		echo "<h3><a href='content.php?disc=".$linhad['id']."&discname=".$linhad['name']."'>".$linhad['name']."</a></h3>";
	}
?> 
</div>

<div id='coltripla'>
<?php 

//	echo "<h2>".$h2.(isset($personagename)?$personagename:"")." ".$personname."</h2>";
// 	echo "<h3>".(isset($organizationname)?$organizationname:"").(isset($unityname)?" - ".$unityname:"")."</h3>";
//	echo "<hr>";

	echo "<h1>".$discname;

	if(isset($content_father) && $content_father!=""){
		echo " - ".$contentname." - ";
		echo "<a href='content.php?acao=9&disc=".$disc."&discname=".$discname."&contentname=".$contentname."&content_father=".$content_father."&contentFather=".$content_father."'>Novo Conteúdo</a>";
	}

	echo "</h1>";
	
	if(isset($acao) && ($acao==9 || $acao==10)){
		include("content_ins.php");
	}
//	echo "<h3><a href='content.php?viewgoal=true&disc=".$disc."&discname=".$discname."&contentname=".$contentname."&content_father=".$content_father."'>Ver Objetivos</a><a href='content.php?viewgoal=false&disc=".$disc."&discname=".$discname."&contentname=".$contentname."&content_father=".$content_father."'>Esconder</a></h3>";
	echo "<hr>";
	
	if(isset($_SESSION["NodesHasBeenAddedHttpVariables"]) == false){
	unset($_SESSION["treeviewhttpvariables"]->Nodes);
	
	if(isset($content_father) && $content_father!=""){
		$SQLf = "SELECT g.*
				 FROM activitycontent g
				 WHERE g.father_id = ".$content_father." 
				 ORDER BY g.grade, name_varchar";
		$resf = pg_query($SQLf);		
		while($linhaf=pg_fetch_array($resf)){
			$i2++;
			$namegoal = $linhaf['name_varchar'];
			$node = new TreeNode("1", "".$linhaf['name_varchar']."");			//Create a new node object with id "1" and set name to "Root Folder".
//<a href='content.php?disc=".$disc."&discname=".$discname."&contentname=".$contentname."&content_father=".$content_father."&contentFather=".$content_father."&content_id=".$linhaf['id']."&namegoala=".$namegoal."'>
//<a href='content.php?ii=".$i2."&acao=2&disc=".$disc."&discname=".$discname."&contentname=".$contentname."&contentFather=".$linhaf['id']."&content_father=".$content_father."'>Novo
			$_SESSION["treeviewhttpvariables"]->AddNode($node);	//Add "Root Folder" node to treeview.

			if(isset($viewgoal) && $viewgoal==true){
				$SQLg1 = "SELECT goal.id, goal.description, goal.grade, degreeblock.name as blockname
						  FROM goal 
						  		LEFT JOIN degreeblock ON degreeblock.id = goal.degreeblock_id
						  WHERE goal.content_id like '%#".$linhaf['id']."#%'
						  ORDER BY degreeblock.grade, goal.grade";
				$resg1 = pg_query($SQLg1);
				while($lg1 = pg_fetch_array($resg1)){
					$content = "";
					$SQLc1 = "SELECT goal_content.id, (activitycontent.name_varchar) as contentname
							  FROM goal_content 
										LEFT JOIN activitycontent ON activitycontent.id = goal_content.activitycontent_id
							  WHERE goal_content.goal_id = ".$lg1['id']."";
	
					$resc1 = pg_query($SQLc1);
					while($lc1 = pg_fetch_array($resc1)){
						$content .= $lc1['contentname']." - ";
					}
					echo "<p><strong>".$lg1['description']."</strong> | ".$lg1['blockname']." - ".$lg1['grade']."<br>".$content."</p>";
				}//while($lg1 = pg_fetch_array($resg1)){
			}//if(isset($viewgoal) && $viewgoal==true){

			if((isset($acao) && ($acao==2 || $acao==10)) && ($ii==$i2) && ($goalins==false)){
				include("content_ins.php");
			}

			$SQL = "SELECT g.*
					FROM activitycontent g
					WHERE g.father_id = ".$linhaf['id']." 
					ORDER BY g.grade, name_varchar";
			$res = pg_query($SQL);
			echo "<ul>";
			while($linha=pg_fetch_array($res)){
				$i3++;
				$namegoal = $linha['name_varchar'];
				
				$node = new TreeNode("2", "".$namegoal."");
				$node->SetParentId("1");							//Set "Root Folder" node as parent.
				$node->AddHttpVariable("varnameone", "something");	//Add a http variable. The result will be index.php?varnameone=something
				$_SESSION["treeviewhttpvariables"]->AddNode($node);

//<a href='content.php?disc=".$disc."&discname=".$discname."&contentname=".$contentname."&content_father=".$content_father."&contentFather=".$content_father."&content_id=".$linha['id']."&namegoala=".$namegoal."'>
//<a href='content.php?ii=".$i3."&acao=3&disc=".$disc."&discname=".$discname."&contentname=".$contentname."&contentFather=".$linha['id']."&content_father=".$content_father."'>Novo
				
				if((isset($acao) && ($acao==3 || $acao==10)) && ($ii==$i3) && ($goalins==false)){
					include("content_ins.php");
				}
				$SQLs = "SELECT g.*
						 FROM activitycontent g 
						 WHERE g.father_id = ".$linha['id']." 
						 ORDER BY g.grade, name_varchar";
				$ress = pg_query($SQLs);
				echo "<ul>";
				while($linhas=pg_fetch_array($ress)){
					$i4++;
					$namegoal = $linhas['name_varchar'];
					echo "<li><strong><a href='content.php?disc=".$disc."&discname=".$discname."&contentname=".$contentname."&content_father=".$content_father."&contentFather=".$content_father."&content_id=".$linhas['id']."&namegoala=".$namegoal."'>".$namegoal."</a></strong> | <a href='content.php?ii=".$i4."&acao=4&disc=".$disc."&discname=".$discname."&contentname=".$contentname."&contentFather=".$linhas['id']."&content_father=".$content_father."'>Novo</a></li>";
					if((isset($acao) && ($acao==4 || $acao==10)) && ($ii==$i4) && ($goalins==false)){
						include("content_ins.php");
					}
					$SQLs1 = "SELECT g.*
							  FROM activitycontent g
							  WHERE g.father_id = ".$linhas['id']." 
							  ORDER BY g.grade, name_varchar";
					$ress1 = pg_query($SQLs1);
					echo "<ul>";
					while($linhas1=pg_fetch_array($ress1)){
						$namegoal = $linhas1['name_varchar'];
						echo "<li><strong><a href='content.php?disc=".$disc."&discname=".$discname."&contentname=".$contentname."&content_father=".$content_father."&contentFather=".$content_father."&content_id=".$linhas1['id']."&namegoala=".$namegoal."'>".$namegoal."</a></strong> | <a href='content.php?acao=5&disc=".$disc."&discname=".$discname."&contentname=".$contentname."&contentFather=".$linhas1['id']."&content_father=".$content_father."'>Novo</a></li>";
						if((isset($acao) && ($acao==5 || $acao==10)) && ($ii==$i5) && ($goalins==false)){
							include("content_ins.php");
						}
						$SQLs2 = "SELECT g.*
								  FROM activitycontent g 
								  WHERE g.father_id = ".$linhas1['id']."
								  ORDER BY g.grade, name_varchar";
						$ress2 = pg_query($SQLs2);
						echo "<ul>";
						while($linhas2=pg_fetch_array($ress2)){
							$namegoal = $linhas2['name_varchar'];
							echo "<li><strong><a href='content.php?disc=".$disc."&discname=".$discname."&contentname=".$contentname."&content_father=".$content_father."&contentFather=".$content_father."&content_id=".$linhas2['id']."&namegoala=".$namegoal."'>".$namegoal."</a></strong> | <a href='content.php?acao=6&disc=".$disc."&discname=".$discname."&contentname=".$contentname."&contentFather=".$linhas2['id']."&content_father=".$content_father."'>Novo</a></li>";
							if((isset($acao) && ($acao==6 || $acao==10)) && ($ii==$i6) && ($goalins==false)){
								include("content_ins.php");
							}
							$SQLs3 = "SELECT g.*
									  FROM activitycontent g
									  WHERE g.father_id = ".$linhas2['id']."
									  ORDER BY g.grade, name_varchar";
							$ress3 = pg_query($SQLs3);
							echo "<ul>";
							while($linhas3=pg_fetch_array($ress3)){
								$namegoal = $linhas3['name_varchar'];
								echo "<li><strong><a href='content.php?disc=".$disc."&discname=".$discname."&contentname=".$contentname."&content_father=".$content_father."&contentFather=".$content_father."&content_id=".$linhas3['id']."&namegoala=".$namegoal."'>".$namegoal."</a></strong> | <a href='content.php?acao=7&disc=".$disc."&discname=".$discname."&contentname=".$contentname."&contentFather=".$linhas3['id']."&content_father=".$content_father."'>Novo</a></li>";
								if((isset($acao) && ($acao==7 || $acao==10)) && ($ii==$i7) && ($goalins==false)){
									include("content_ins.php");
								}
								$SQLs4 = "SELECT g.*
										  FROM activitycontent g
										  WHERE g.father_id = ".$linhas3['id']."
										  ORDER BY g.grade, name_varchar";
								$ress4 = pg_query($SQLs4);
								echo "<ul>";
								while($linhas4=pg_fetch_array($ress4)){
									$namegoal = $linhas4['name_varchar'];
									echo "<li><strong><a href='content.php?disc=".$disc."&discname=".$discname."&contentname=".$contentname."&content_father=".$content_father."&contentFather=".$content_father."&content_id=".$linhas4['id']."&namegoala=".$namegoal."'>".$namegoal."</a></strong> | <a href='content.php?acao=8&disc=".$disc."&discname=".$discname."&contentname=".$contentname."&contentFather=".$linhas4['id']."&content_father=".$content_father."'>Novo</a></li>";
									if((isset($acao) && ($acao==8 || $acao==10)) && ($ii==$i8) && ($goalins==false)){
										include("content_ins.php");
									}
								}
								echo "</ul>";
							}
							echo "</ul>";
						}
						echo "</ul>";
					}
					echo "</ul>";
				}
				echo "</ul>";
			}
			echo "</ul>";
		}
	}
	}
		
	$_SESSION["treeviewhttpvariables"]->PrintTreeView();
	
	if (isset($_GET["varnameone"]) == true)
		echo "<br/><br/>Http Folder <b>One</b> has been selected.";
	
	if (isset($_GET["varnametwo"]) == true)
		echo "<br/><br/>Http Folder <b>Two</b> has been selected.";

?>
</div>

<?php

//}//if(!isset($content_id){

if(isset($content_id) && $content_id!=""){
echo "<div id='colquadra'>";

	$SQLa = "SELECT discipline_id, description FROM activitycontent WHERE id = ".$content_id."";
	$resa = pg_query($SQLa);
	$linhaa = pg_fetch_array($resa);
	
	echo "<h1>".$namegoala."</h1>";
	echo '<p><form name="description" action="content.php" method="POST">';
	echo "<textarea cols='35' rows='2' name='txtdescription'>".$linhaa['description']."</textarea>";
	echo "<input type='hidden' name='disc' value='".$disc."'>";
	echo "<input type='hidden' name='discname' value='".$discname."'>";
	echo "<input type='hidden' name='contentname' value='".$contentname."'>";
	echo "<input type='hidden' name='content_father' value='".$content_father."'>";
	echo "<input type='hidden' name='contentFather' value='".$content_father."'>";
	echo "<input type='hidden' name='content_id' value='".$content_id."'>";
	echo "<input type='hidden' name='namegoala' value='".$namegoal."'>";
	echo "<input type='hidden' name='upddescription' value='true'>";
	echo "<input type='submit' value='Atualizar'>";
	echo "</form></p>";
	echo "<hr>";

	$SQLg = "SELECT g.*, (d.name) as discname, ds.name as stagename, db.name as blockname
			 FROM goal g 
					LEFT JOIN discipline d ON d.id = g.discipline_id
					LEFT JOIN degreeblock db ON db.id = g.degreeblock_id
					LEFT JOIN degreestage ds ON ds.id = db.degreestage_id
			 WHERE contenthability_id like '%#".$content_id."#%' 
			ORDER by ds.grade, db.grade, g.grade";
	$resg = pg_query($SQLg);
	$i = 0;
	echo "<table width='90%' border='1'>";
	echo "<tr><td><h3>Objetivo</h3></td><td><h3>Estágio</h3></td><td><h3>Bloco</h3></td><td><h3>Grau</h3></td></tr>";
	while($linhag = pg_fetch_array($resg)){
		$i++;
		echo "<tr>";
		echo "<td><h3><a target='_blank' href='activity_view.php?goal=".$linhag['id']."&blockname=".$linhag['dbname']."&degreeblock=".$linhag['degreeblock']."&discname=".$linhag['discname']."&description=".$linhag['description']."'>".$linhag['description']."</a></h3></td><td>".$linhag['stagename']."</td><td>".$linhag['blockname']."</td><td>".$linhag['grade']."</td>";
		echo "</tr>";
	}//while($linhag = pg_fetch_array($resg)){
	echo "</table>";
}//if(isset($content_id) && $content_id!=""){
echo "</div>";
?>
<div id="col5">
<?php	
		echo "<h3>Conteúdos - <a href='content.php?acao=1&disc=".$disc."&discname=".$discname."'>Novo</a></h3>";
		if(isset($acao) && ($acao==1) && ($ii==$i1) && ($goalins==false)){
			include("content_ins.php");
		}

		if(isset($disc) && $disc!=""){
			$SQL = "SELECT * FROM activitycontent WHERE father_id is null AND discipline_id = ".$disc." ORDER BY name_varchar";
			$res = pg_query($SQL);
			if(pg_num_rows($res)>0){
				while($linha=pg_fetch_array($res)){
					$i1 ++;
					echo "<h3><a href='content.php?ii=".$i1."&disc=".$disc."&discname=".$discname."&contentname=".$linha['name_varchar']."&content_father=".$linha['id']."'>".$linha['name_varchar']."</a></h3>";
				}
			}
		}
?>
</div>
<div id="base"><?php echo $base.date('Y');?> ::</div>
</body>
</html>