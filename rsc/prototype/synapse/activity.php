<?php
/*
filtragem==1 (element_bean.php?text_sel=true)
filtragem==2 (element_bean.php?media_sel=true)
filtragem==3 (INSERT text)
filtragem==4 (UPDATE text)
filtragem==5 (UPDATE layer_property)
*/
session_start();
ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
include("includes/conecta.php");
include("includes/validation.php");
include("includes/idiom.php");
ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

//________________________________________________________________________________________________________________________________ UPPER_TEXT
function convertem($term) { 
	$palavra = strtr(strtoupper($term),"àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ","ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß");
    return $palavra; 
} 
//--------------------------------------------------------------------------------------------------------------------------//UPPER_TEXT

?>
<html>
<head>
<title><?php echo $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="activity.css" rel="stylesheet" type="text/css">
<?php
//________________________________________________________________________________________________________________________________JAVA
ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
include("activity_java.php");
ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
//------------------------------------------------------------------------------------------------------------------------------//JAVA
?>
</head>
<?php
//_________________________________________________________________________________________________________________________________VAR
//__________________________________________________________________________________________________________________________________BO
ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
include("activity_var.php");
include("activity_bo.php");
ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
//-------------------------------------------------------------------------------------------------------------------------------//VAR
//--------------------------------------------------------------------------------------------------------------------------------//BO

//________________________________________________________________________________________________________________________________TOPO
?>
<body scroll="yes">
<table width="100%" height="100%" border="3 solid #000000"><tr><td>
<div id="topo"><?php //border='1 solid black'
	ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
	include("activity_topo.php");
	ini_set("allow_url_fopen",0); ini_set("allow_url_include",0); ?>
</div>

<div id="fechar"><a href=javascript:window.close()><img src="images/botao_fechar.gif" border="0"></a></div>

<div id="menutop">
	<?php echo "<h14>Tela ".$screen.(isset($pieceseq) && $pieceseq!=""?" - ".$pieceseq."ª Questão":"").(isset($piecedescription) && $piecedescription!=""?" - ".$piecedescription:"")."</h14>"; ?>
	<div id="menutop1"><?php
		echo "<p><a href='#' onClick=\"MM_openBrWindow('render.php?render=true";
		ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
			include("activity_link.php");
		ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
		echo "', 'activity', 'address=no, toolbar=no, menubar=no, status=no, location=no, width=1010, height=710')\">Render</a></p>" ?>
	</div>
	    <div id="menutop2">
          <?php
		echo "<h14><a href='#' onClick=\"MM_openBrWindow('activity.php?gerativ=true";
		ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
			include("activity_link.php");
		ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
		echo "', 'activity', 'address=no, toolbar=no, menubar=no, status=no, location=no, width=1010, height=710')\">Atualizar</a></h14>" ?>
        </div>
</div><?php
//------------------------------------------------------------------------------------------------------------------------------//TOPO

//________________________________________________________________________________________________________________________________MENU
?><div id="menu"><?php
ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
include("activity_menu_screen.php");
include("activity_menu_piece.php");
include("activity_menu.php");
ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
?></div>
<?php
//------------------------------------------------------------------------------------------------------------------------------//MENU

//_______________________________________________________________________________________________________________________________LAYER
?>
<div id="layer"><?php
ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
include("activity_layer.php");
ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
?></div><?php
//-----------------------------------------------------------------------------------------------------------------------------//LAYER

//________________________________________________________________________________________________________________________________BODY
?>
<div id="conteudo">
	
<form name='form4' action='activity.php' method='post' onSubmit='return check_form(textupd);'> <?php

	$SQLe = "SELECT lp.*, lp.seq as lpseq, lp.id as layer_property_id, 
					pe.*, pe.seq as peseq, 
					et.name as radio_name, 
					p.name_varchar as piecename, p.seq, p.piecetype_id,
					lt.name as layername
			 FROM layer_property lp
			 		LEFT JOIN piece p ON p.id = lp.piece_id
					LEFT JOIN piece_element pe ON pe.id = lp.layer_id
					LEFT JOIN elementtype et ON et.id = pe.elementtype_id
					LEFT JOIN layertype lt ON lt.id = lp.layertype_id
			 WHERE lp.screen = ".$screen." AND
			 		p.activity_id=".$activity_id." 
			ORDER BY pe.seq, lp.seq";
	$rese = pg_query($SQLe);
//echo $SQLe;
	if(pg_num_rows($rese)>0){

		$i=0;
		$zindex = 10;
		$divtopmodelo = 0;
		$divtopacerto = 0;
		$divleftoption = 0;
		
		while($linhae = pg_fetch_array($rese)){

			$i++;
			$zindex ++;			
			$radio_name = $linhae['radio_name'];
			if($linhae['piecetype_id']!=""){
				$activitytype_id = $linhae['piecetype_id'];
			}
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-ACTIVITY_TYPE
			ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
			include("activity_type.php");
			ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-DIV-STYLE
			ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
			include("activity_style.php");
			ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-IMAGE
			if($linhae['elementtype_id']==2){ 
				ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
				include("activity_imageel.php");
				ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
	  		}//if($linhae['elementtype_id']==2){ 
			
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-MOVIE
			if($linhae['elementtype_id']=="3"){
				ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
				include("activity_movie.php");
				ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
			}//if($linhae['elementtype_id']=="3"){
			
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-SOUND
			if($linhae['elementtype_id']=="4" || $linhae['elementtype_id']=="5" || $linhae['elementtype_id']=="6"){
				ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
				include("activity_sound.php");
				ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
			}
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-TEXT
			if($linhae['elementtype_id']=="7" || $linhae['elementtype_id']=="8" || $linhae['elementtype_id']=="9" || $linhae['elementtype_id']=="10" || $linhae['elementtype_id']=="13"){
				ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
				include("activity_text.php");
				ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
			}//if($linhae['elementtype_id']=="7" || $linhae['elementtype_id']=="8" || $linhae['elementtype_id']=="9" || $linhae['elementtype_id']=="10"){
			
		}//while($linhae = pg_fetch_array($rese)){
		if(isset($activitytype_id) && $activitytype_id==7){
			echo '<div id="Layer3" style="position:absolute; left:750px; top:500px; width:150px; height:75px; z-index:1">';
			echo "<input type='submit' name='OK'>";
			echo "</div>";
		}		
	}//if(pg_num_rows($rese)>0){
//}?>
</form>
</div>
<?php
//--------------------------------------------------------------------------------------------------------------------------------BODY

//______________________________________________________________________________________________________________________________BOTTOM
?>
<div id="alert"><?php
	ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
	include("activity_alert.php");
	ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
?></div>

<div id="activity_element"><?php 
	ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
	include("activity_element.php");
	ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
?>
</div>
</td></tr></table>
</body>
</html>