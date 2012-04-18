<?php
if(!isset($idiom)){
	$idiom=7;
}

if(isset($activity) && $activity!=""){
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
}else{//if(isset($activity) && $activity!=""){
	if(isset($idiom) && $idiom=="7"){
		$h1="Início";
		$h2="Bem Vindo:";
	}
	
	if(isset($idiom) && $idiom=="16"){
		$h1="Home";
		$h2="Welcome:";
	}
	
	if(isset($idiom) && $idiom=="17"){
		$h1="Haus";
		$h2="Willkommen:";
	}
}
?>