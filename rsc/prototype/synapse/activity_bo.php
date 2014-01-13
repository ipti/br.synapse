<?php
session_start();
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-DELETE
if(isset($acao) && $acao=="excluir"){
	$SQL = "DELETE FROM pieceprinted WHERE pieceelement_id = ".$piece_element."";
	$res = pg_query($SQL);
	$SQL = "DELETE FROM piece_element WHERE id = ".$piece_element."";
	$res = pg_query($SQL);
	$SQL = "DELETE FROM layer_property WHERE piece_element_id = ".$piece_element."";
	$res = pg_query($SQL);
}

//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-UPDATE
if(isset($filtragem) && $filtragem==4){//-------------------------------------------------------UPDATE TEXT
	if(isset($data) && $data!=""){
		$SQL = "SELECT name FROM ".$radio_name." WHERE name = '".convertem($data)."'";
		$res = pg_query($SQL);
		if(pg_num_rows($res)==0){
			$SQL = "UPDATE ".$radio_name." SET name = '".convertem($data)."' WHERE id = ".$element_id."";
			$res = pg_query($SQL);
			$SQLlt = "UPDATE layer_text SET name = '".$data."' WHERE layer_property_id = ".$layer_property_id."";
			$reslt = pg_query($SQLlt);
		}else{
			$erro210 = "<h3 align='center'><font color='red'>ERRO:</font> ".$SQL."</h3>";
			$erro210 .= "<p align='center'><strong>Favor comunicar esse erro a <a href='mailto:fabio@enscer.com.br?subject=activity_erro210&body=activity_erro210=".$SQL."'>fabio@enscer.com.br</a></strong></p>";
		}
	}
}

if(isset($filtragem) && $filtragem==5){//-------------------------------------------------------UPDATE LAYER
	if((!isset($PosX) || (isset($PosX) && $PosX=="")) && (isset($divleft) && $divleft!="")){
		$PosX = $divleft;
	}
	if((!isset($PosY) || (isset($PosY) && $PosY=="")) && (isset($divtop) && $divtop!="")){
		$PosY = $divtop;
	}
	if((!isset($DimX) || (isset($DimX) && $DimX=="")) && (isset($divwidth) && $divwidth!="")){
		$DimX = $divwidth;
	}
	if((!isset($DimY) || (isset($DimY) && $DimY=="")) || (isset($rows) && $rows!="")){
		$DimY = $rows*22;
	}

	if(isset($newevent)){
		$SQL = "INSERT INTO layer_property (piece_element_id, layer_id, piece_id, event_id, screen, pos_x, pos_y, dim_x, dim_y, seq, layertype_id, grouping, actor_id) 
				VALUES(".$piece_element.", ".$layer_id.", ".$piece_id.", ".$event_id.", ".$screen.", ".$PosX.", ".$PosY.", ".$DimX.", ".$DimY.", ".($lpseq+1).", ".$layertype_id.", ".$grouping.", ".$actor.")";
		$pg_query($SQL);
	}else{
		$SQL = "UPDATE layer_property 
				SET pos_x=".$PosX.", 
					pos_y=".$PosY.", 
					dim_x=".$DimX.", 
					dim_y=".$DimY.",
					layertype_id=".$layertype_id.",
					grouping=".$grouping.",
					seq=".$lpseq.",
					screen=".$screen.",
					layer_id=".$layer_id."
				WHERE piece_element_id=".$piece_element." AND
					  event_id=".$event_id."";
		$res = pg_query($SQL);
	}
	
	$SQL = "UPDATE piece_element SET seq = ".$peseq." WHERE id = ".$piece_element."";
	$res = pg_query($SQL);
	
	echo "<script> window.location.reloadPage(); </script>";
}//if(isset($filtragem) && $filtragem==5){

//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-INSERT LAYER
if(isset($filtragem) && ($filtragem==1 || $filtragem==2 || ($filtragem==3 && (isset($verbal) && $verbal=="oral")))){
//-------------------------TEXT_SEL----------MIDIA_SEL---------TEXT_ORAL_INS------------------------------------------
	echo "<script>window.open('element_bean.php?";
									if(isset($filtragem) && (($filtragem==1) || ($filtragem==3 && (isset($verbal) && $verbal=="oral")))){
										echo "text_sel=true";
									}elseif(isset($filtragem) && ($filtragem==2)){
										echo "media_sel=true";
									}
									if(isset($verbal) && $verbal!=""){
										echo "&verbal=".$verbal."";
									}
									echo "&activity_id=".$activity_id;
									echo "&activitytype_id=".$activitytype_id;
									echo "&screen=".$screen;
									echo "&radio_name=".$radio_name;
									echo "&layertype_id=".$layertype_id;
									if(isset($piece_id) && $piece_id!=""){
										echo "&piece_id=".$piece_id;
										echo "&piecename=".$piecename;
									}
									if(isset($element_id) && $element_id!=""){
										echo "&element_id=".$element_id;
										echo "&piece_element=".$piece_element;
										echo "&elementtype_id=".$elementtype_id;
										echo "&event_id=".$event_id;
										echo "&peseq=".$peseq;
										echo "&lpseq=".$lpseq;
										echo "&grouping=".$grouping;
										echo "&layer_id=".$layer_id;
									}
									if(isset($newscreen) && $newscreen!=""){
										echo "&newscreen=".$newscreen;
									}
									if(isset($totalscreen) && $totalscreen!=""){
										echo "&totalscreen=".$totalscreen;
									}
									if(isset($newpiece) && $newpiece==true){
										echo "&newpiece=true.";
									}
									if(isset($newpieceelement) && $newpieceelement==true){
										echo "&newpieceelement=true";
									}
									if(isset($text) && $text!=""){
										echo "&text=".$text;
									}
									if(isset($name) && $name!=""){
										echo "&name=".$name;
									}
									echo "'";

	echo ",'element','fullscreen=3,statusbar=no,menubar=no,resizable=no,scrollbars=yes,titlebar=no,toolbar=no,left=0,top=0,width=1010,height=710')";
	echo "</script>";
}

if((isset($filtragem) && $filtragem==3) && (isset($verbal) && $verbal=="written")){
//------------------------TEXT_INS-----------------------------WRITTEN-------------
	$pieceelement_ins = true;
	ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
	include("element.php");
	ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
	$piece_element = "";
	$element_id="";
	unset($element_id);
	$DimX = "";
	$DimY = "";
	$layertype_id = "";
	$grouping = "";
	$peseq = "";
	$lpseq = "";
	$layer_id = "";
	$PosX = "";
	$PosY = "";
	unset($newscreen);
	unset($newpiece);
//	exit;
}
?>