<?php
session_start();

ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
include("includes/conecta.php");
ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

if(!(session_is_registered('person'))){
	echo "erro";
	header('Location: ' . "http://" . $_SERVER["SERVER_NAME"]."/synapse/index.php");	
}
//_______________________________________________________________________________________________________________________________IDIOM
if(!isset($idiom)){
	$idiom=7;
}

if(isset($idiom) && $idiom=="7"){
	$h1="Atividades";
	$h2="Bem Vindo:";
	$m_theme="Tema";
	$m_activity="Atividade";
	$m_piece="Tela";
}

if(isset($idiom) && $idiom=="16"){
	$h1="Activities";
	$h2="Welcome:";
	$m_theme="Theme";
	$m_activity="Activity";
	$m_piece="Screen";
}

if(isset($idiom) && $idiom=="17"){
	$h1="Aktivitäten";
	$h2="Willkommen:";
	$m_theme="Thema";
	$m_activity="Aktivität";
	$m_piece="Screen";
}
//-----------------------------------------------------------------------------------------------------------------------------//IDIOM

//________________________________________________________________________________________________________________________________JAVA
?>
<html>
<head>
<title><?php echo $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="activity.css" rel="stylesheet" type="text/css">
<script type="text/JavaScript" language="JavaScript">
<!--
var form = "";
var submitted = false;
var error = false;
var error_message = "";

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

function check_form4(form_name) {
	if (submitted == true) {
		alert("Este formulário já foi enviado. Por favor pressione OK e aguarde o processo ser completado.");
		return false;
	}  
	error = false;
	form = form_name;
	error_message = "Erros ocorreram durante o envio de seu formulário.\n\nPor favor, faça as seguintes correções:\n\n";

	check_radio("radio_name", "Escolha um Tipo:\n ___________________Img (Imagem);\n ___________________Mov (Filme);\n ___________________Msc (Música);\n ___________________Snd (Som)");
	check_input("name", 3, "Digite uma palavra completa");

	if (error == true) {
		alert(error_message);
		return false;
	}else{
		submitted = true;
		return true;
	}
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function reloadPage(){  
   javascript:location.reload();
}

function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}

var MouseDownX, MouseDownY, PrevContainerX, PrevContainerY, PrevContainerW, PrevContainerH;
var MouseIsDown = false;

function LayerEvents(e, id) {
	switch(e.type) {
		case 'mousemove':
			if(e.ctrlKey && MouseIsDown) {
				w = PXValue(document.getElementById(id).style.width);
				h = PXValue(document.getElementById(id).style.height);
				document.getElementById(id).style.width = PrevContainerW+((e.clientX-PrevContainerX)-(MouseDownX-PrevContainerX))+'px';
				document.getElementById(id).style.height =  PrevContainerH+((e.clientY-PrevContainerY)-(MouseDownY-PrevContainerY))+'px';
			} else if(MouseIsDown) {
				document.getElementById(id).style.left = e.clientX-(MouseDownX-PrevContainerX)+'px';
				document.getElementById(id).style.top = e.clientY-(MouseDownY-PrevContainerY)+'px';
			}
			break;
		case 'mousedown':
			MouseIsDown = true;
			MouseDownX = e.clientX;
			MouseDownY = e.clientY;
			PrevContainerX = PXValue(document.getElementById(id).style.left);
			PrevContainerY = PXValue(document.getElementById(id).style.top);
			PrevContainerW = PXValue(document.getElementById(id).style.width);
			PrevContainerH = PXValue(document.getElementById(id).style.height);
			break;
		case 'mouseup':
			MouseIsDown = false;
	}
	window.write(document.getElementById(id).style.top); 
}
function PXValue(s) {
	return parseInt(s.replace('px',''));
}

function filtra4(cod) {
  document.forms["form4"].filtragem.value = cod;
}
//-->
</script>
</head>
<?php
//------------------------------------------------------------------------------------------------------------------------------//JAVA

//________________________________________________________________________________________________________________________________ BO
if(isset($filtragem) && $filtragem==1){

	foreach($Perg as $layername => $piece){
	$value="";
		if($layername=="radio" || $layername=="checkbox"){		
			foreach($piece as $piece_id => $group){
				foreach($group as $grouping => $layer_property_id){
//					echo "Perg: ".$Perg."<br>";
//					echo "layername: ".$layername."<br>";
//					echo "piece: ".$piece."<br>";
//					echo "piece_id: ".$piece_id."<br>";
//					echo "group: ".$group."<br>";
//					echo "grouping: ".$grouping."<br>";
//					echo "layer_property_id: ".$layer_property_id."<br>";
					$SQL = "SELECT lp.*, pe.*
							FROM layer_property lp
									LEFT JOIN piece_element pe ON pe.id = lp.piece_element_id
							WHERE lp.id = ".$layer_property_id."";
					$res = pg_query($SQL);
//					echo "SQL: ".$SQL."<br>";	
					$l = pg_fetch_array($res);

					$SQLi = "INSERT INTO performance (actor_id, activity_id, piece_id, piece_element_id, element_id, elementtype_id, layer_property_id, event_id, layertype_id, value) 
											VALUES (".$actor.", ".$activity_id.", ".$l['piece_id'].", ".$l['piece_element_id'].", ".$l['element_id'].", ".$l['elementtype_id'].", ".$layer_property_id.", ".$l['event_id'].", ".$l['layertype_id'].", '".$value."')";
					$resi = pg_query($SQLi);
//					echo "SQLi: ".$SQLi."<br>";	
				}
			}
		}else{
			foreach($piece as $piece_id => $layer_property){
				foreach($layer_property as $layer_property_id => $value){	
					$SQL = "SELECT lp.*, pe.*
							FROM layer_property lp
									LEFT JOIN piece_element pe ON pe.id = lp.piece_element_id
							WHERE lp.id = ".$layer_property_id."";
					$res = pg_query($SQL);
//					echo "SQL: ".$SQL."<br>";
					$l = pg_fetch_array($res);
					
					$SQLi = "INSERT INTO performance (actor_id, activity_id, piece_id, piece_element_id, element_id, elementtype_id, layer_property_id, event_id, layertype_id, value) 
											VALUES (".$actor.", ".$activity_id.", ".$l['piece_id'].",".$l['piece_element_id'].", ".$l['element_id'].", ".$l['elementtype_id'].", ".$layer_property_id.", ".$l['event_id'].", ".$l['layertype_id'].", '".$value."')";
					$resi = pg_query($SQLi);
//					echo "SQLi: ".$SQLi."<br>";
				}
			}
		}
	}
	$screen = $screen+1;
}
//exit;

//--------------------------------------------------------------------------------------------------------------------------------//BO

//_________________________________________________________________________________________________________________________________VAR
if(isset($activitytype_id) && $activitytype_id==1){
	$screenactivity = "Páginas";
	$screenpiece = "Tópicos";
	$typename = "Texto";
}elseif(isset($activitytype_id) && $activitytype_id==2){
	$screenactivity = "Telas";
	$screenpiece = "Questões";
	$typename = "Multipla Escolha";
}elseif(isset($activitytype_id) && $activitytype_id==3){
	$screenactivity = "Telas";
	$screenpiece = "Questões";
	$typename = "Pergunta Resposta";
}elseif(isset($activitytype_id) && $activitytype_id==4){
	$screenactivity = "Telas";
	$screenpiece = "Exercícios";
	$typename = "Associar Elementos";
}elseif(isset($activitytype_id) && $activitytype_id==5){
	$screenactivity = "Telas";
	$screenpiece = "Atividades";
	$typename = "Palavra Cruzada";
}elseif(isset($activitytype_id) && $activitytype_id==6){
	$screenactivity = "Telas";
	$screenpiece = "Atividades";
	$typename = "Diagrama";
}

if(!isset($screen) || (isset($screnn) && $screen=="")){
	$screen = 1;
}

$SQLt = "SELECT lp.screen 
		FROM layer_property lp
				LEFT JOIN piece p ON p.id = lp.piece_id
		WHERE p.activity_id = ".$activity_id."
		GROUP BY lp.screen
		ORDER BY lp.screen";
$rest = pg_query($SQLt);
while($linhat = pg_fetch_array($rest)){
	$totalscreen = $linhat['screen'];
}

if(isset($screen) && ($screen > $totalscreen)){
	$screen = 1;
}

if(isset($event_id) && $event_id!=""){
	$SQL = "SELECT name FROM event WHERE id = ".$event_id."";
	$res = pg_query($SQL);
	$l = pg_fetch_array($res);
	$eventname = $l['name'];
}

if(isset($layertype_id) && $layertype_id!=""){
	$SQL = "SELECT name FROM layertype WHERE id = ".$layertype_id."";
	$res = pg_query($SQL);
	$l = pg_fetch_array($res);
	$layername = $l['name'];
}
//-------------------------------------------------------------------------------------------------------------------------------//VAR

//________________________________________________________________________________________________________________________________MENU
?>
<body scroll="yes">

<div id="topo"><?php //border='1 solid black'
	echo "<table width='98%' cellpadding='0' cellspacing='0'><tr><td>";
	echo "<h3>".$discname." - ".$goaldescription." - ".$semanticname."<br>";
	echo "Block: ".$blockname_varchar." ".$block_content."<br>";
	echo "Activity: ".$activityname." - ".$activitydescription."</h3></td>";
	echo "<td><p>Type: ".$typename."<br>";
	echo "Event: ".$eventname."<br>";
	echo "Layer: ".$layername."<br>";
	echo "Element: ".$radio_name."</p></td></tr></table>";
	if(isset($erro210)){ 
		echo $erro210; 
	}?>
</div>

<div id="fechar"><a href=javascript:window.close()><img src="images/botao_fechar.gif" border="0"></a></div>

<div id="menutop"><?php echo "<h14>".$screen." - ".$piecedescription."</h14>"; ?>
	<div id="menutop1"><?php
		echo "<p><a href='#'";
		echo "onClick=\"MM_openBrWindow('activity.php?";
		echo "semantic_id=".$semantic_id."&";
		echo "semanticname=".$semanticname."&";
		echo "discipline_id=".$discipline_id."&";
		echo "discname=".$discname."&";
		echo "activityname=".$activityname."&";
		echo "activitydescription=".$activitydescription."&";
		echo "activity_id=".$activity_id."&";
		echo "activitytype_id=".$activitytype_id."&";
		echo "goaldescription=".$goaldescription."&";
		echo "block_content=".$name."&";
		echo "blockname_varchar=".$blockname_varchar."&";
		echo "screen=".$screen;
		echo "', 'activity',  'address=no, toolbar=no, menubar=no, status=no, location=no, width=1010, height=710')\">"; ?>
		Gerativ</a></p>
	</div>
</div>

<div id="menu_render"> 
  <?php
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-MENU/SCREEN
if(!isset($screen) && (isset($piece_id) && $piece_id!="")){
	$SQL = "SELECT lp.screen
			FROM layer_property lp
					LEFT JOIN piece p ON p.id = lp.piece_id
			WHERE p.id=".$piece_id."";
	$res = pg_query($SQL);
	if($l = pg_fetch_array($res)){
		$screen = $l['screen'];
	}else{
		$screen = 0;
	}
}
echo "<table width='140'>";
echo "<tr><td class='azultit' width='140' align='center'>".$screenactivity."</td></tr></table>";
echo "<table width='140'><tr>";
$SQLs = "SELECT lp.screen
		 FROM layer_property lp
		 		LEFT JOIN piece p ON p.id = lp.piece_id
				LEFT JOIN activity a ON a.id = p.activity_id 
		 WHERE a.id = ".$activity_id."
		 GROUP BY lp.screen
		 ORDER BY lp.screen";
$ress = pg_query($SQLs);
$i=0;
while($linhas = pg_fetch_array($ress)){
	$i ++;
	if(($i==6) || ($i==11) || ($i==16)){
		echo "<tr>";
	}
	if(isset($screen) && $screen==$linhas['screen']){
		echo "<td class='azulahover' align='center'>".$linhas['screen']."</td>";
	}else{
		echo "<td class='azul' align='center'><a href='render.php?screen=".$linhas['screen']."&discname=".$discname."&semantic=".$semantic."&semanticname=".$semanticname."&";
		echo "activity_id=".$activity_id."&goaldescription=".$goaldescription."&activityname=".$activityname."&activitydescription=".$activitydescription."&";
		echo "activitytype_id=".$activitytype_id."&typename=".$typename."&blockname_varchar=".$blockname_varchar."&block_content=".$block_content."'>".$linhas['screen']."</a></td>";
	}
	if(($i==11) || ($i==16)){
		echo "</tr>";
	}
}
if((isset($newscreen) && $newscreen==true) && (isset($totalscreen) && $totalscreen!="")){
	echo "<td class='azulahover' align='center'>".($screen)."</td>";
}
echo "</tr></table>";
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-MENU/PIECE
echo "<hr>";

echo "<table width='140'><tr>";
	echo "<td class='cinzatit' width='140' align='center'>".$screenpiece."</td></tr></table>";

$SQLp = "SELECT DISTINCT p.* 
		 FROM piece p
		 		LEFT JOIN layer_property lp ON lp.piece_id = p.id
		 WHERE p.activity_id = ".$activity_id." AND
		 		lp.screen = ".$screen." AND
		 	   p.father_id is null
		ORDER BY p.seq";
$resp = pg_query($SQLp);
echo "<table width='140'>";
while($linhap = pg_fetch_array($resp)){
	echo "<tr height='15'>";
		echo "<td class='cinza' width='140' align='left'><h13>";
			echo "<a href='render.php?newpieceelement=true&screen=".$screen."&totalscreen=".$totalscreen."&discname=".$discname."&semantic=".$semantic."&semanticname=".$semanticname."&";
			echo "activity_id=".$activity_id."&goaldescription=".$goaldescription."&pieceseq=".$linhap['seq']."&piece_id=".$linhap['id']."&";
			echo "activityname=".$activityname."&activitydescription=".$activitydescription."&activitytype_id=".$activitytype_id."&typename=".$typename."&";
			echo "blockname_varchar=".$blockname_varchar."&block_content=".$block_content."&piecename=".$linhap['name_varchar']."&piecedescription=".$linhap['description']."&piecetype_id=".$linhap['piecetype_id']."'>";
				if(isset($piece_id) && $piece_id == $linhap['id']){
					echo "<u>";
				}
				echo $linhap['seq']." - ".($linhap['name_varchar']!=""?$linhap['name_varchar']:"");
				if(isset($piece_id) && $piece_id == $linhap['id']){
					echo "</u>";
				}
			echo "</a></h13>";
		echo "</td>";
	echo "</tr>";
}
echo "</table>"; ?>
</div>
<?php
//------------------------------------------------------------------------------------------------------------------------------//MENU

//________________________________________________________________________________________________________________________________BODY
?>
<div id="conteudo_render" style="overflow: auto;"> 
  <form name='form4' action='render.php' method='post' onSubmit='return check_form(textupd);'>
    <?php

//$SQLp = "SELECT * FROM piece WHERE activity_id = ".$activity_id." ORDER BY seq";
//$resp = pg_query($SQLp);
//while($lp = pg_fetch_array($resp)){
	$SQLe = "SELECT lp.*, lp.seq as lpseq, lp.id as layer_property_id, 
					pe.*, pe.seq as peseq, 
					et.name as radio_name, 
					p.name_varchar as piecename, p.seq,
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

	if(pg_num_rows($rese)>0){

		$i=0;
		$zindex = 10;

		while($linhae = pg_fetch_array($rese)){

			$i++;
			$zindex ++;			
			$radio_name = $linhae['radio_name'];
			if($linhae['piecetype_id']!=""){
				$activitytype_id = $linhae['piecetype_id'];
			}
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-ACTIVITY_TYPE
			if(isset($activitytype_id) && $activitytype_id==1){//TEXTO
				$divwidth = $linhae['dim_x'];
				$divheight = $linhae['dim_y'];
				$divleft = $linhae['pos_x'];
				if($i==1){
					$divtop = $linhae['pos_y'];
					$divheightt = ($linhae['dim_y'])+($linhae['pos_y']);
				}else{
					$divtop = 20+$divheightt;
					$divheightt = $divheightt+$linhae['dim_y']+20;
				}
			}elseif(isset($activitytype_id) && $activitytype_id==2){//MULTIPLA ESCOLHA
				if($linhae['layertype_id']==1){//modelo
					$divwidth = $linhae['dim_x'];
					$divheight = $linhae['dim_y'];
					$divtop = $linhae['pos_y'];
					$divleft = 435;
				}elseif($linhae['layertype_id']==2){//Acerto
					$divwidth = $linhae['dim_x'];
					$divheight = $linhae['dim_y'];
					$divtop = $linhae['pos_y'];
					$divleft = $linhae['pos_x'];				
				}elseif($linhae['layertype_id']==3){//Erro
					$divwidth = $linhae['dim_x'];
					$divheight = $linhae['dim_y'];
					$divtop = $linhae['pos_y'];
					$divleft = $linhae['pos_x'];				
				}elseif($linhae['layertype_id']==4){//radio
					$divwidth = $linhae['dim_x'];
					$divheight = $linhae['dim_y'];
					$divtop = $linhae['pos_y'];
					$divleft = $linhae['pos_x'];				
				}elseif($linhae['layertype_id']==5){//checkbox
					$divwidth = $linhae['dim_x'];
					$divheight = $linhae['dim_y'];
					$divtop = $linhae['pos_y'];
					$divleft = $linhae['pos_x'];				
				}elseif($linhae['layertype_id']==6){//text
					$divwidth = $linhae['dim_x'];
					$divheight = $linhae['dim_y'];
					$divtop = $linhae['pos_y'];
					$divleft = $linhae['pos_x'];				
				}elseif($linhae['layertype_id']==7){//textarea
					$divwidth = $linhae['dim_x'];
					$divheight = $linhae['dim_y'];
					$divtop = $linhae['pos_y'];
					$divleft = $linhae['pos_x'];				
				}
			}elseif(isset($activitytype_id) && $activitytype_id==3){//PERGUNTA RESPOSTA
				$divwidth = $linhae['dim_x'];
				$divheight = $linhae['dim_y'];
				$divtop = $linhae['pos_y'];
				$divleft = $linhae['pos_x'];
			}elseif(isset($activitytype_id) && $activitytype_id==4){//ASSOCIAR ELEMENTOS
				$divwidth = $linhae['dim_x'];
				$divheight = $linhae['dim_y'];
				$divtop = $linhae['pos_y'];
				$divleft = $linhae['pos_x'];
			}elseif(isset($activitytype_id) && $activitytype_id==5){//PALAVRA CRUZADA
				$divwidth = $linhae['dim_x'];
				$divheight = $linhae['dim_y'];
				$divtop = $linhae['pos_y'];
				$divleft = $linhae['pos_x'];
			}elseif(isset($activitytype_id) && $activitytype_id==6){//DIAGRAMA
				$divwidth = $linhae['dim_x'];
				$divheight = $linhae['dim_y'];
				$divtop = $linhae['pos_y'];
				$divleft = $linhae['pos_x'];
			}else{
				$divwidth = $linhae['dim_x'];
				$divheight = $linhae['dim_y'];
				$divtop = $linhae['pos_y'];
				$divleft = $linhae['pos_x'];
			}
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-DIV-STYLE
			if(isset($piece_id) && $piece_id == $linhae['piece_id']){
				$bgcolor="#FFFFFF";
				$bordersytle = "";//dashed
			}else{
				$bgcolor="#FFFFFF";
				$bordersytle = "";
			}
			?>
    <STYLE>
				.div<?php echo $i; ?>{ 
					position:absolute;
					width: <?php echo $divwidth; ?> ;
					height: <?php echo $divheight; ?>;
					top: <?php echo $divtop; ?>;
					left: <?php echo $divleft ?>;
					z-index: <?php echo $zindex ?>;
					border-style: <?php echo $bordersytle; ?>;
					border-width: 1px;
					background-color: <?php echo $bgcolor; ?>
				}
			</STYLE>
<?php 
			echo "<div id='".$i."' class='div".$i."'>";
			if($linhae['elementtype_id']=="2" || $linhae['elementtype_id']=="3" || $linhae['elementtype_id']=="4" || $linhae['elementtype_id']=="5" || $linhae['elementtype_id']=="6"){
				$SQLim = "SELECT id, extension FROM ".$radio_name." WHERE id=".$linhae['element_id']."";
				$resim = pg_query($SQLim);
				$linhaim = pg_fetch_array($resim);
				$media = "activity/".$radio_name."/".$linhaim['id'].".".$linhaim['extension']; 
				
				if($linhae['elementtype_id']==2){ ?>
					<img src="<?php echo $media; ?>" border='0'><?php
				}//if($linhae['elementtype_id']==2){ 
	
				if($linhae['elementtype_id']=="3"){ ?>
					<object type="application/x-shockwave-flash"
										data="<?php echo $movie; ?>"
										width="<?php echo $divwidth; ?>" height="<?php echo $divheight; ?>" id="VideoPlayback">
					  <param name="movie" value="<?php echo $movie; ?>" />
					  <param name="allowScriptAcess" value="sameDomain" />
					  <param name="quality" value="best" />
					  <param name="bgcolor" value="#FFFFFF" />
					  <param name="scale" value="noScale" />
					  <param name="salign" value="TL" />
					  <param name="FlashVars" value="playerMode=embedded" />
					</object><?php
				}//if($linhae['elementtype_id']=="3"){
	
				if($linhae['elementtype_id']=="4" || $linhae['elementtype_id']=="5" || $linhae['elementtype_id']=="6"){ ?>
					<img src='images/sound.gif' ></div><?php
				} //onClick='PlaySound(".$media.")'
			}

			if($linhae['elementtype_id']=="7" || $linhae['elementtype_id']=="8" || $linhae['elementtype_id']=="9" || $linhae['elementtype_id']=="10"){

				$SQLet = "SELECT * FROM layer_text WHERE layer_property_id = ".$linhae['layer_property_id']."";
				$reset = pg_query($SQLet);
				$linhaet = pg_fetch_array($reset);
				
				$fontcolor = "#000000";
				$fontweight="400";
				$fontfamily = "arial, helvetica, serif";
				$fontsize = "14px";				
				$j=$i;
				echo '<STYLE type="text/css">
						t'.$j.'{
							font-family: '.$fontfamily.';
							font-size: '.$fontsize.';
							color: '.$fontcolor.';
							font-weight: '.$fontweight.';
							line-height: 1.5em;
							text-align:justify;
						}
					</STYLE>';
				$SQL = "SELECT idiom_id FROM ".$radio_name." where id = ".$linhae['element_id']."";
				$res = pg_query($SQL);
				$linha = pg_fetch_array($res);
				
				echo "<t".$j.">";
				if(isset($linhae['layertype_id']) && $linhae['layertype_id']==5){
					echo "<input type='radio' name='Perg[".$linhae['layername']."][".$linhae['piece_id']."][".$linhae['grouping']."]' value='".$linhae['layer_property_id']."'>";
				}elseif(isset($linhae['layertype_id']) && $linhae['layertype_id']==6){
					echo "<input type='checkbox' name='Perg[".$linhae['layername']."][".$linhae['piece_id']."][".$linhae['grouping']."]' value='".$linhae['layer_property_id']."'>";
				}
				if($linhae['layertype_id']==8 || $linhae['layertype_id']==9){
					echo "<input type='".$linhae['layername']."' value='";
				}
				if($linha['idiom_id']==$idiom){ 
					echo $linhaet['name']; //."-".$linhae['layertype_id']."-".$linhae['layername']
				}else{ 		
					$SQLi = "SELECT w.id, w.name FROM ".$radio_name." w LEFT JOIN ".$radio_name."_".$radio_name." ww on (ww.".$radio_name."1_id=w.id) or (ww.".$radio_name."2_id=w.id)
							WHERE (((ww.".$radio_name."1_id=".$linhae['element_id'].") or (ww.".$radio_name."2_id=".$linhae['element_id'].")) and w.idiom_id=".$idiom.")";
					$resi = pg_query($SQLi);
					$linhai = pg_fetch_array($resi);
					if($linhai['name']!=""){
						echo $linhai['name'];
					}else{
						echo $linhaet['name'];
					}
				}
				if($linhae['layertype_id']==8 || $linhae['layertype_id']==9){
					echo "' onClick='filtra4(1)'>";
				}
				if(isset($linhae['layertype_id']) && $linhae['layertype_id']==4){
					echo "<input type='text' name='Perg[".$linhae['layername']."][".$linhae['piece_id']."][".$linhae['layer_property_id']."]'>";
				}elseif(isset($linhae['layertype_id']) && $linhae['layertype_id']==7){
					echo "<textarea name='Perg[".$linhae['layername']."][".$linhae['piece_id']."][".$linhae['layer_property_id']."]' style='width:".$divwidth."; height:".($divheight-22)."'></textarea>";
				}
				echo "</t".$j.">";
			}//if($linhae['elementtype_id']=="7" || $linhae['elementtype_id']=="8" || $linhae['elementtype_id']=="9" || $linhae['elementtype_id']=="10"){
			echo "</div>";
		}//while($linhae = pg_fetch_array($rese)){
		if(isset($activitytype_id) && $activitytype_id==7){
			echo '<div id="Layer3" style="position:absolute; left:750px; top:500px; width:150px; height:75px; z-index:1">';
			echo "<input type='submit' name='OK'>";
			echo "</div>";
		}		
	}//if(pg_num_rows($rese)>0){
//}?>
<input type="hidden" name="discname" value="<?php echo $discname; ?>"> 
<input type="hidden" name="semanticname" value="<?php echo $semanticname; ?>"> 
<input type="hidden" name="blockname_varchar" value="<?php echo $blockname_varchar; ?>"> 
<input type="hidden" name="block_content" value="<?php echo $block_content; ?>"> 
<input type="hidden" name="activityname" value="<?php echo $activityname; ?>"> 
<input type="hidden" name="activitydescription" value="<?php echo $activitydescription; ?>"> 
<input type='hidden' name='activity_id' value='<?php echo $activity_id; ?>'> 
<input type='hidden' name='activitytype_id' value='<?php echo $activitytype_id; ?>'> 
<input type="hidden" name="typename" value="<?php echo $typename; ?>"> 
<input type="hidden" name="goaldescription" value="<?php echo $goaldescription; ?>"> 
<input type='hidden' name='piece_id' value='<?php echo $piece_id; ?>'> 
<input type='hidden' name='piece_element' value='<?php echo $piece_element; ?>'>
<input type='hidden' name='element_id' value='<?php echo $element_id; ?>'>
<input type='hidden' name='elementtype_id' value='<?php echo $elementtype_id; ?>'>
<input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
<input type="hidden" name="layertype_id" value="<?php echo $layertype_id; ?>">
<input type="hidden" name="screen" value="<?php echo $screen; ?>">
<input type="hidden" name="totalscreen" value="<?php echo $totalscreen; ?>">
<input type="hidden" name="grouping" value="<?php echo $grouping; ?>">
<input type="hidden" name="lpseq" value="<?php echo $lpseq; ?>">
<input type="hidden" name="peseq" value="<?php echo $peseq; ?>">
<input type="hidden" name="radio_name" value="<?php echo $radio_name; ?>">
<input type='hidden' name='filtragem' value='0'>
</form>
</div>
<div id="render_bottom"></div>
</body>
</html>