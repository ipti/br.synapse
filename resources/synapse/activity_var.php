<?php
session_start();
if(isset($activitytype_id) && $activitytype_id==1){//TEXTO
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
	$screenpiece = "Questões";
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

if(isset($eventid) && $eventid!=""){
	$event_id=$eventid;
}elseif(!isset($eventid) || (isset($eventid) && $eventid=="")){
	$eventid=1;
	$event_id=1;
}

if((!isset($layer_id) || (isset($layer_id) && $layer_id=="")) && (isset($piece_element) && $piece_element!="")){
	$layer_id = $piece_element;
}

if(!isset($screen) || (isset($screen) && $screen=="")){
	$screen = 1;
}

if((isset($newscreen) && $newscreen==true) && (isset($totalscreen) && $totalscreen!="")){
	$screen = $totalscreen+1;
}

$SQLt = "SELECT lp.screen 
		FROM layer_property lp
				LEFT JOIN piece p ON p.id = lp.piece_id
		WHERE p.activity_id = ".$activity_id."
		GROUP BY lp.screen
		ORDER BY lp.screen";
$rest = pg_query($SQLt);
$totalscreen = pg_num_rows($rest);

$SQLtp = "SELECT id 
		FROM piece 
		WHERE activity_id = ".$activity_id."";
$restp = pg_query($SQLtp);
$totalpiece = pg_num_rows($restp);

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
?>