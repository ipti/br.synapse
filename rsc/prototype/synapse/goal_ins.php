<?php
session_start();

$contenthability_id = "#";

ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
include("goal/goal_contenthabilityi.php");
ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

if($contenthability_id=="#"){
	$msggoal_ins = "<h3 align='center'><font color='red'><strong>Escolha uma Habilidade e/ou um Conteúdo</strong></font></h3>";	
}else{
	if($acao=="3"){
		$SQLi = "INSERT INTO goal(contenthability_id, content_id, hability_id, name_varchar, degreegrade_id, description, discipline_id) 
				 VALUES ('";
	}elseif($acao=="2"){
		$SQLi = "UPDATE goal SET contenthability_id = '";
	}
		$SQLi .= $contenthability_id;
	//-------------------------------------------------------------------------------------- CAMPO CONTENT	
	if($acao=="3"){
		$SQLi .= "', '#";
	}elseif($acao=="2"){//grava novo objetivo
		$SQLi .= "', content_id = '#";
	}
	ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
	include("goal/goal_content_ins.php");
	ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
	//-------------------------------------------------------------------------------------- CAMPO HABILIDADE
	if($acao=="3"){
		$SQLi .= "' ,'#";
	}elseif($acao=="2"){//grava novo objetivo
		$SQLi .= "', hability_id = '#";
	}
	if(isset($habilidade) && $habilidade!=""){
		$SQLi .= $habilidade."#";
	}
	if(isset($subhabilidade) && $subhabilidade!=""){
		$SQLi .= $subhabilidade."#";
	}
	if(isset($habilidade1) && $habilidade1!=""){
		$SQLi .= $habilidade1."#";
	}
	if(isset($condicoes) && $condicoes!=""){
		$SQLi .= $condicoes."#";
	}
	//-------------------------------------------------------------------------------------- CAMPO NAME
	if($acao=="3"){
		$SQLi .= "', '";
	}elseif($acao=="2"){//grava novo objetivo
		$SQLi .= "', name_varchar = '";
	}
	
	ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
	include("goal/goalname_ins.php");
	ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
	
	if($acao=="2"){//grava novo objetivo
		$SQLi .= ", degreegrade_id = ".$degreegrade.", description = '".$description."', discipline_id = ".$discipline." WHERE id = ".$goal_id."";
	}elseif($acao=="3"){
		$SQLi .= ", ".$degreegrade.", '".$description."', ".$discipline.")";
	}
	//echo $SQLi."<br>";
	if($resi = pg_query($SQLi)){
		
		if($acao=="2"){
			$SQLd = "DELETE FROM goal_content WHERE goal_id = ".$goal_id."";
			$resd = pg_query($SQLd);
		}
		
		ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
		include("goal/goalcontent_ins.php");
		ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
		
	}else{
		$ERROgoal_ins = "<h3 align='center'><font color='red'>ERRO:</font> ".$SQLi."</h3>";
		$ERROgoal_ins .= "<p align='center'><strong>Favor comunicar esse erro a <a href='mailto:fabio@enscer.com.br?subject=ERROgoal_ins&body=".$SQLi."'>fabio@enscer.com.br</a></strong></p>";
	}
}
//_________________________________________________________________________________________________________________ //INSERT GOAL
?>