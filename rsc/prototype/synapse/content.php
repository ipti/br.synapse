<?php

session_start();
	
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
    include("includes/topo1.php");
    ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
?>

<div id='col1'>
<?php
	if(isset($proj) && $proj==3){
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

<div id='coldupla'>
<?php 

//	echo "<h2>".$h2.(isset($personagename)?$personagename:"")." ".$personname."</h2>";
// 	echo "<h3>".(isset($organizationname)?$organizationname:"").(isset($unityname)?" - ".$unityname:"")."</h3>";
//	echo "<hr>";

	echo "<h1>".$discname." - <a href='content.php?acao=1&goalins=0&disc=".$disc."&discname=".$discname."'>Novo</a></h1>";
	echo "<hr>";
	echo "<table><tr><td valign='top'>";

	if((isset($acao) && ($acao==1 || $acao==10)) && (isset($goalins) && $goalins==0)){
		include("content_ins.php");
	}

	if(isset($disc) && $disc!=""){
		$SQL = "SELECT * FROM activitycontent WHERE father_id is null AND discipline_id = ".$disc." ORDER BY name_varchar";
		$res = pg_query($SQL);
		if(pg_num_rows($res)>0){
			echo "<table><tr><td valign='top'>";
			while($linha=pg_fetch_array($res)){
				echo "<h3><a href='content.php?namegoala=".$linha['name_varchar']."&content_id=".$linha['id']."&disc=".$disc."&discname=".$discname."&contentname=".$linha['name_varchar']."&content_father=".$linha['id']."'>".$linha['name_varchar']."</a></h3>";
			}
			echo "</td></tr>";
		}
	}

	if(isset($content_father) && $content_father!=""){

		echo "<tr><td valign='top'>";
		echo "<h3>".$contentname." - <a href='content.php?acao=9&goalins=0&disc=".$disc."&discname=".$discname."&contentname=".$contentname."&content_father=".$content_father."&contentFather=".$content_father."'>Novo</a></h3>";
		if((isset($acao) && ($acao==9 || $acao==10)) && (isset($goalins) && $goalins==0)){
			include("content_ins.php");
		}
		$SQLf = "SELECT g.*
				 FROM activitycontent g
				 WHERE g.father_id = ".$content_father." 
				 ORDER BY g.grade, name_varchar";
		$resf = pg_query($SQLf);		
		echo "<ul>";
		while($linhaf=pg_fetch_array($resf)){
			$i2++;
			$namegoal = $linhaf['name_varchar'];
			echo "<li><h3><a href='content.php?content2=".$linhaf['id']."&disc=".$disc."&discname=".$discname."&contentname=".$contentname."&contentname2=".$linhaf['name_varchar']."&content_father=".$content_father."&contentFather=".$linhaf['id']."&content_id=".$linhaf['id']."&namegoala=".$namegoal."'>".$linhaf['name_varchar']."</a></h3></li>";
		}
		echo "</ul>";
		echo "</td></tr>";
		
		if(isset($content2) && $content2!=""){
		
			echo "<tr><td valign='top'>";
			echo "<h3>".$contentname2." - <a href='content.php?acao=2&goalins=0&disc=".$disc."&discname=".$discname."&content2=".$content2."&contentname=".$contentname."&contentname2=".$contentname2."&contentFather=".$contentFather."&content_father=".$content_father."'>Novo</a></h3>";
			if((isset($acao) && ($acao==2 || $acao==10)) && (isset($goalins) && $goalins==0)){
				include("content_ins.php");
			}
			$SQL = "SELECT g.*
					FROM activitycontent g
					WHERE g.father_id = ".$content2." 
					ORDER BY g.grade, name_varchar";
			$res = pg_query($SQL);
			echo "<ul>";
	
			while($linha=pg_fetch_array($res)){
				$namegoal = $linha['name_varchar'];
				echo "<li><h3><a href='content.php?content2=".$content2."&content3=".$linha['id']."&disc=".$disc."&discname=".$discname."&contentname=".$contentname."&contentname2=".$contentname2."&contentname3=".$linha['name_varchar']."&content_father=".$content_father."&contentFather=".$linha['id']."&content_id=".$linha['id']."&namegoala=".$namegoal."'>".$namegoal."</a></h3></li>";	
			}			
			echo "</ul>";
			echo "</td></tr></table></td>";
		}else{
			echo "</table></td>";
		}//if(isset($content2) && $content2!="") && $ii==$i2){

		if(isset($content3) && $content3!=""){			
			echo "<td valign='top'><table><tr><td valign='top'>";
			echo "<h3>".$contentname3." | <a href='content.php?acao=3&goalins=0&disc=".$disc."&discname=".$discname."&content2=".$content2."&content3=".$content3."&contentname=".$contentname."&contentname2=".$contentname2."&contentname3=".$contentname3."&contentFather=".$contentFather."&content_father=".$content_father."'>Novo</a></h3>";
			if((isset($acao) && ($acao==3 || $acao==10)) && (isset($goalins) && $goalins==0)){
				include("content_ins.php");
			}
			$SQLs = "SELECT g.*
					 FROM activitycontent g 
					 WHERE g.father_id = ".$content3." 
					 ORDER BY g.grade, name_varchar";
			$ress = pg_query($SQLs);
			echo "<ul>";
			while($linhas=pg_fetch_array($ress)){
				$namegoal = $linhas['name_varchar'];
				echo "<li><strong><a href='content.php?content2=".$content2."&content3=".$content3."&content4=".$linhas['id']."&disc=".$disc."&discname=".$discname."&contentname=".$contentname."&contentname2=".$contentname2."&contentname3=".$contentname3."&contentname4=".$linhas['name_varchar']."&content_father=".$content_father."&contentFather=".$linhas['id']."&content_id=".$linhas['id']."&namegoala=".$namegoal."'>".$namegoal."</a></strong></li>";
			}
			echo "</ul>";
			echo "</td></tr>";
		}//if((isset($content3) && $content3!="") && $ii==$i3){
	
		if(isset($content4) && $content4!=""){
			echo "<tr><td valign='top'>";
			echo "<h3>".$contentname4." | <a href='content.php?acao=4&goalins=0&disc=".$disc."&discname=".$discname."&content2=".$content2."&content3=".$content3."&content4=".$content4."&contentname=".$contentname."&contentname2=".$contentname2."&contentname3=".$contentname3."&contentname4=".$contentname4."&contentFather=".$contentFather."&content_father=".$content_father."'>Novo</a></h3>";
			if((isset($acao) && ($acao==4 || $acao==10)) && (isset($goalins) && $goalins==0)){
				include("content_ins.php");
			}
			$SQLs1 = "SELECT g.*
					  FROM activitycontent g
					  WHERE g.father_id = ".$content4." 
					  ORDER BY g.grade, name_varchar";
			$ress1 = pg_query($SQLs1);
			echo "<ul>";
	
			while($linhas1=pg_fetch_array($ress1)){
				$namegoal = $linhas1['name_varchar'];
				echo "<li><strong><a href='content.php?content2=".$content2."&content3=".$content3."&content4=".$content4."&content5=".$linhas1['id']."&disc=".$disc."&discname=".$discname."&contentname=".$contentname."&contentname2=".$contentname2."&contentname3=".$contentname3."&contentname4=".$contentname4."&contentname5=".$linhas1['name_varchar']."&content_father=".$content_father."&contentFather=".$linhas1['id']."&content_id=".$linhas1['id']."&namegoala=".$namegoal."'>".$namegoal."</a></strong></li>";
			}
			echo "</ul>";
			echo "</td></tr>";
		}//if((isset($content4) && $content4!="") && $ii==$i4){

		if(isset($content5) && $content5!=""){
			echo "<tr><td valign='top'>";
			echo "<h3>".$contentname5." | <a href='content.php?acao=5&goalins=0&disc=".$disc."&discname=".$discname."&content2=".$content2."&content3=".$content3."&content4=".$content4."&content5=".$content5."&contentname=".$contentname."&contentname2=".$contentname2."&contentname3=".$contentname3."&contentname4=".$contentname4."&contentname5=".$contentname5."&contentFather=".$contentFather."&content_father=".$content_father."'>Novo</a></h3>";
			if((isset($acao) && ($acao==5 || $acao==10)) && (isset($goalins) && $goalins==0)){
				include("content_ins.php");
			}
			$SQLs2 = "SELECT g.*
					  FROM activitycontent g 
					  WHERE g.father_id = ".$content5."
					  ORDER BY g.grade, name_varchar";
			$ress2 = pg_query($SQLs2);
			echo "<ul>";
			while($linhas2=pg_fetch_array($ress2)){
				$namegoal = $linhas2['name_varchar'];
				echo "<li><strong><a href='content.php?content2=".$content2."&content3=".$content3."&content4=".$content4."&content5=".$content5."&content6=".$linhas2['id']."&disc=".$disc."&discname=".$discname."&contentname=".$contentname."&contentname2=".$contentname2."&contentname3=".$contentname3."&contentname4=".$contentname4."&contentname5=".$contentname5."&contentname6=".$linhas2['name_varchar']."&content_father=".$content_father."&contentFather=".$linhas2['id']."&content_id=".$linhas2['id']."&namegoala=".$namegoal."'>".$namegoal."</a></strong></li>";
			}
			echo "</ul>";
			echo "</td></tr></table></td>";
		}else{
			echo "</table></td>";
		}////if((isset($content5) && $content5!="") && $ii==$i5){
		
		if(isset($content6) && $content6!=""){
			echo "<td valign='top'><table><tr><td>";
			echo "<h3>".$contentname6." | <a href='content.php?acao=6&goalins=0&disc=".$disc."&discname=".$discname."&content2=".$content2."&content3=".$content3."&content4=".$content4."&content5=".$content5."&content6=".$content6."&contentname=".$contentname."&contentname2=".$contentname2."&contentname3=".$contentname3."&contentname4=".$contentname4."&contentname5=".$contentname5."&contentname6=".$contentname6."&contentFather=".$contentFather."&content_father=".$content_father."'>Novo</a></h3>";
			if((isset($acao) && ($acao==6 || $acao==10)) && (isset($goalins) && $goalins==0)){
				include("content_ins.php");
			}
			$SQLs3 = "SELECT g.*
					  FROM activitycontent g
					  WHERE g.father_id = ".$content6."
					  ORDER BY g.grade, name_varchar";
			$ress3 = pg_query($SQLs3);
			echo "<ul>";
			while($linhas3=pg_fetch_array($ress3)){
				$namegoal = $linhas3['name_varchar'];
				echo "<li><strong><a href='content.php?content2=".$content2."&content3=".$content3."&content4=".$content4."&content5=".$content5."&content6=".$content6."&content7=".$linhas3['id']."&disc=".$disc."&discname=".$discname."&contentname=".$contentname."&contentname2=".$contentname2."&contentname3=".$contentname3."&contentname4=".$contentname4."&contentname5=".$contentname5."&contentname6=".$contentname6."&contentname7=".$linhas3['name_varchar']."&content_father=".$content_father."&contentFather=".$linhas3['id']."&content_id=".$linhas3['id']."&namegoala=".$namegoal."'>".$namegoal."</a></strong></li>";
			}
			echo "</ul>";
			echo "</td></tr>";
		}

		if(isset($content7) && $content7!=""){		
			echo "<tr><td>";
			echo "<h3>".$contentname7." | <a href='content.php?acao=7&goalins=0&disc=".$disc."&discname=".$discname."&content2=".$content2."&content3=".$content3."&content4=".$content4."&content5=".$content5."&content6=".$content6."&content7=".$content7."&contentname=".$contentname."&contentname2=".$contentname2."&contentname3=".$contentname3."&contentname4=".$contentname4."&contentname5=".$contentname5."&contentname6=".$contentname6."&contentname7=".$contentname7."&contentFather=".$contentFather."&content_father=".$content_father."'>Novo</a></strong></h3>";
			if((isset($acao) && ($acao==7 || $acao==10)) && (isset($goalins) && $goalins==0)){
				include("content_ins.php");
			}
			$SQLs4 = "SELECT g.*
					  FROM activitycontent g
					  WHERE g.father_id = ".$content7."
					  ORDER BY g.grade, name_varchar";
			$ress4 = pg_query($SQLs4);
			echo "<ul>";
			while($linhas4=pg_fetch_array($ress4)){
				$namegoal = $linhas4['name_varchar'];
				echo "<li><strong><a href='content.php?content2=".$content2."&content3=".$content3."&content4=".$content4."&content5=".$content5."&content6=".$content6."&content7=".$content7."&content8=".$linhas4['id']."&disc=".$disc."&discname=".$discname."&contentname=".$contentname."&contentname2=".$contentname2."&contentname3=".$contentname3."&contentname4=".$contentname4."&contentname5=".$contentname5."&contentname6=".$contentname6."&contentname7=".$contentname7."&contentname8=".$linhas4['name_varchar']."&content_father=".$content_father."&contentFather=".$linhas4['id']."&content_id=".$linhas4['id']."&namegoala=".$namegoal."'>".$namegoal."</a></strong></li>";
			}
			echo "</ul>";
			echo "</td></tr>";
		}
		
		if(isset($content8) && $content8!=""){
			echo "<tr><td>";
			echo "<h3>".$contentname8." | <a href='content.php?acao=8&goalins=0&disc=".$disc."&discname=".$discname."&content2=".$content2."&content3=".$content3."&content4=".$content4."&content5=".$content5."&content6=".$content6."&content7=".$content7."&content8=".$content8."&contentname=".$contentname."&contentname2=".$contentname2."&contentname3=".$contentname3."&contentname4=".$contentname4."&contentname5=".$contentname5."&contentname6=".$contentname6."&contentname7=".$contentname7."&contentname8=".$contentname8."&content_father=".$content_father."&contentFather=".$contentFather."'>Novo</a></strong></h3>";
			if((isset($acao) && ($acao==8 || $acao==10)) && (isset($goalins) && $goalins==0)){
				include("content_ins.php");
			}
			$SQLs5 = "SELECT g.*
					  FROM activitycontent g
					  WHERE g.father_id = ".$content8."
					  ORDER BY g.grade, name_varchar";
			$ress5 = pg_query($SQLs5);
			echo "<ul>";
			while($linhas5=pg_fetch_array($ress5)){
				$namegoal = $linhas5['name_varchar'];
				echo "<li><strong><a href='content.php?content2=".$content2."&content3=".$content3."&content4=".$content4."&content5=".$content5."&content6=".$content6."&content7=".$content7."&content8=".$content8."&disc=".$disc."&discname=".$discname."&contentname=".$contentname."&contentname2=".$contentname2."&contentname3=".$contentname3."&contentname4=".$contentname4."&contentname5=".$contentname5."&contentname6=".$contentname6."&contentname7=".$contentname7."&contentname8=".$contentname8."&content_father=".$content_father."&contentFather=".$linhas5['id']."&content_id=".$linhas5['id']."&namegoala=".$namegoal."'>".$namegoal."</a></strong></li>";
			}
			echo "</ul>";
			echo "</td></tr></table></td>";
		}else{
			echo "</table></td>";
		}
	}else{
		echo "</table></td></tr></table>";
	}//if(isset($content_father) && $content_father!=""){
	echo "</tr></table>";
?>
</div>

<?php

//}//if(!isset($content_id){

if(isset($content_id) && $content_id!=""){
echo "<div id='col2'>";

	$SQLa = "SELECT discipline_id, description FROM activitycontent WHERE id = ".$content_id."";
	$resa = pg_query($SQLa);
	$linhaa = pg_fetch_array($resa);
	
	echo "<h1>".$namegoala."</h1>";
	echo '<form name="description" action="content.php" method="POST">';
	echo "<p><textarea cols='35' rows='2' name='txtdescription'>".$linhaa['description']."</textarea>";
	echo "<input type='hidden' name='disc' value='".$disc."'>";
	echo "<input type='hidden' name='discname' value='".$discname."'>";
	echo "<input type='hidden' name='contentname' value='".$contentname."'>";
	echo "<input type='hidden' name='content_father' value='".$content_father."'>";
	echo "<input type='hidden' name='contentFather' value='".$content_father."'>";
	echo "<input type='hidden' name='content_id' value='".$content_id."'>";
	echo "<input type='hidden' name='namegoala' value='".$namegoal."'>";
	echo "<input type='hidden' name='upddescription' value='true'>";
	echo "<input type='submit' value='Ok'></p>";
	echo "</form>";
	echo "<hr>";

	$SQLg = "SELECT g.*, (d.name) as discname, ds.name as stagename, db.name as blockname,
						g.grade as goalgrade, 
						ds.name as stagename, ds.id as degreestage, 
						db.name as blockname, db.id as degreeblock, 
						dg.name as gradename, dg.id as degreegrade
			 FROM goal g 
					LEFT JOIN discipline d ON d.id = g.discipline_id
					LEFT JOIN degreegrade dg ON dg.id = g.degreegrade_id
					LEFT JOIN degreeblock db ON db.id = dg.degreeblock_id
					LEFT JOIN degreestage ds ON ds.id = db.degreestage_id
			 WHERE contenthability_id like '%#".$content_id."#%' 
			ORDER by ds.grade, db.grade, g.grade";
	$resg = pg_query($SQLg);
	$i = 0;
	echo "<table width='90%' border='1'>";
	echo "<tr><td><h3>Objetivo - <a target='_blank' href='goal_ins.php?acao=10&disc=".$disc."'>Novo</a></h3></td><td><h3>Es</h3></td><td><h3>Bl</h3></td><td><h3>Gr</h3></td></tr>";
	while($linhag = pg_fetch_array($resg)){
		$i++;
		echo "<tr>";
			echo "<td><h3><a href='#' onclick=\"javascript:window.open('activity_view.php?blockname=".$linhag['blockname']."&degreeblock_id=".$linhag['degreeblock']."&";
			echo "degreestage=".$linhag['degreestage']."&stagename=".$linhag['stagename']."&descriptiona=".$linhag['description']."&discipline=".$discipline."&";
			echo "discname=".$discname."&goal=".$linhag['id']."&goalgrade=".$linhag['goalgrade']."&ia=".$i."', '', 'scrollbar=yes, width=800, height=300')\">";
			echo $linhag['description']."</a>";
			echo "</h3></td>";
			echo "<td>".$linhag['stagename']."</td>";
			echo "<td>".$linhag['blockname']."</td>";
			echo "<td>".$linhag['grade']."</td>";
		echo "</tr>";
	}//while($linhag = pg_fetch_array($resg)){
	echo "</table>";
echo "</div>";
}//if(isset($content_id) && $content_id!=""){

/*
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
*/
?>
<div id="base1"><?php echo $base.date('Y');?> ::</div>
</body>
</html>
