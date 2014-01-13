<?php
session_start();
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
		$divleftoption = $divleftoption+$linhae['dim_x']+20;
		$divwidth = $linhae['dim_x'];
		$divheight = $linhae['dim_y'];
		if($i==1){
			$divleft = 40;
		}else{
			$divleft  = $divleftoption;
		}
		$divtop = 150;
	}elseif($linhae['layertype_id']==3){//Erro
		$divleftoption = $divleftoption+$linhae['dim_x']+20;
		$divwidth = $linhae['dim_x'];
		$divheight = $linhae['dim_y'];
		if($i==1){
			$divleft = 40;
		}else{
			$divleft  = $divleftoption;
		}
		$divtop = 150;
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
	if($linhae['layertype_id']==1){//modelo
		$divtopmodelo = $divtopmodelo+$linhae['dim_y']+20;
		$divwidth = $linhae['dim_x'];
		$divheight = $linhae['dim_y'];
		if($i==1){
			$divtop = 40;
		}else{
			$divtop = $divtopmodelo;
		}
		$divleft = 40;
	}elseif($linhae['layertype_id']==2){//Acerto
		$divtopacerto = $divtopacerto+$linhae['dim_y']+20;
		$divwidth = $linhae['dim_x'];
		$divheight = $linhae['dim_y'];
		if($i==1){
			$divtop = 40;
		}else{
			$divtop = $divtopacerto;
		}
		$divleft = 300;				
	}elseif($linhae['layertype_id']==3){//Erro
		$divwidth = $linhae['dim_x'];
		$divheight = $linhae['dim_y'];
		$divtop = $linhae['pos_y'];
		$divleft = 300;				
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
?>