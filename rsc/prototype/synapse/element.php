<?php
session_start();
//________________________________________________________________________________________________________________________________VAR
if((!isset($idiom_id)) || (isset($idiom_id) && $idiom_id=="")){
	$idiom_id = 7;
}

if((!isset($event_id)) || (isset($event_id) && $event_id=="")){
	$event_id = 1;
}

if((!isset($layertype_id)) || (isset($layertype_id) && $layertype_id=="")){
	$layertype_id = 1;
}

if(isset($radio_name) && $radio_name=='image'){
	$elementtype_id = 2;
}elseif(isset($radio_name) && $radio_name=='movie'){
	$elementtype_id = 3;
}elseif(isset($radio_name) && $radio_name=='noise'){
	$elementtype_id = 4;
	$radio_name = "sound";
	$DimX = 36;
	$DimY = 36;
}elseif(isset($radio_name) && $radio_name=='music'){
	$elementtype_id = 5;
	$radio_name = "sound";
	$DimX = 36;
	$DimY = 36;
}elseif(isset($radio_name) && $radio_name=='word'){
	$elementtype_id = 7;
}elseif(isset($radio_name) && $radio_name=='compound'){
	$elementtype_id = 8;
}elseif(isset($radio_name) && $radio_name=='phrase'){
	$elementtype_id = 9;
}elseif(isset($radio_name) && $radio_name=='paragraph'){
	$elementtype_id = 10;
}elseif(isset($radio_name) && $radio_name=='number'){
	$elementtype_id = 13;
}
if(isset($noise) && $noise==true){
	$elementtype_id = 4;
	$DimX = 36;
	$DimY = 36;
}
if(isset($music) && $music==true){
	$elementtype_id = 5;
	$DimX = 36;
	$DimY = 36;
}
//------------------------------------------------------------------------------------------------------------------------------//VAR

//_____________________________________________________________________________________________________________________INSERT-ELEMENT

if((!isset($element_id)) || (isset($element_id) && $element_id=="")){

//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-TEXT
	if((isset($radio_name) && ($radio_name=="word" || $radio_name=="compound" || $radio_name=="phrase" || $radio_name=="paragraph" || $radio_name=="number")) && (isset($verbal) && $verbal=="written")){
	
		$SQL = "SELECT * 
				FROM ".$radio_name." 
				WHERE name = '".convertem($text)."'";
		if($radio_name!="number"){
			$SQL .= " AND idiom_id=".$idiom_id."";
		}
		$res = pg_query($SQL);
		if(pg_num_rows($res)==0){
			$SQLi = "INSERT INTO ".$radio_name;
			if($radio_name=="number"){
				$SQLi .= " (name) VALUES ('".convertem($text)."');";			
			}else{
				$SQLi .= " (name, idiom_id) VALUES ('".convertem($text)."', ".$idiom_id.");";
			}
			if($resi = pg_query($SQLi)){
				$SQLs = "SELECT * 
						 FROM ".$radio_name." 
						 ORDER BY id DESC";
				$ress = pg_query($SQLs);
				$ls = pg_fetch_array($ress);
				$element_id = $ls['id'];
			}else{
				$erro96 = "<h3 align='center'><font color='red'>ERRO:</font> ".$SQLi."</h3>";
				$erro96 .= "<p align='center'><strong>Favor comunicar esse erro a <a href='mailto:fabio@enscer.com.br?subject=element_erro96&body=element_erro96=".$SQLi."'>fabio@enscer.com.br</a></strong></p>";
				exit;
			}
		}elseif(pg_num_rows($res)==1){
			$ls = pg_fetch_array($res);
			$element_id = $ls['id'];
		}elseif(pg_num_rows($res)>1){
			$pieceelement_ins = false;
			echo "<script>window.open('element_bean.php?text_sel=true&verbal=".$verbal."";
			if(isset($text) && $text!=""){echo "&text=".$text;}
			if(isset($name) && $name!=""){echo "&name=".$name;}
			ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
			include("activity_link.php");
			ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
			echo "','element','fullscreen=3,statusbar=no,menubar=no,resizable=no,scrollbars=yes,titlebar=no,toolbar=no,left=0,top=0,width=1010,height=710')";
			echo "</script>";
		}
		if($radio_name=="word"){
			$DimX = 100;
		}
		if($radio_name=="compound"){
			$DimX = 200;
		}
		if($radio_name=="phrase"){
			$DimX = 400;
		}
		if($radio_name=="paragraph"){
			$DimX = 763;
		}
		if($radio_name=="number"){
			$DimX = 100;
		}
		$DimY=(round((strlen($ls['name'])/100))*22);
		if($DimY < 22){ $DimY = 22; }
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-MEDIA
	}elseif((isset($radio_name) && ($radio_name=="image" || $radio_name=="sound" || $radio_name=="movie")) || (isset($verbal) && $verbal=="oral")){

		$ext = explode('.', $_FILES['arquivo']['name']);

		if($radio_name=="image"){    
			$SQLim = "INSERT INTO image (style, content, color, extension) 
					VALUES ('".$style."', '".$content."', '".$color."', '".strtolower($ext[1])."');";
		}elseif(($radio_name=="sound") || (isset($verbal) && $verbal=="oral")){
			$SQLim = "INSERT INTO sound (extension, elementtype_id) 
					VALUES ('".strtolower($ext[1])."', ".$elementtype_id.");"; 
		}elseif($radio_name=="movie"){
			$SQLim = "INSERT INTO movie (dim_x, dim_y, extension) 
					VALUES (".$DimX.", ".$DimY.", '".strtolower($ext[1])."');";
		}

		if($resim = pg_query($SQLim)){
			if(isset($verbal) && $verbal=="oral"){
				$SQLe = "SELECT * FROM sound ORDER BY id DESC";
			}else{
				$SQLe = "SELECT * FROM ".$radio_name." ORDER BY id DESC";
			}
			$rese = pg_query($SQLe);
			$le = pg_fetch_array($rese);
			$element_id = $le['id'];

			if(isset($verbal) && $verbal=="oral"){
				$full_local_path = "activity/sound/".$element_id.".".$ext[1];
			}else{
				$full_local_path = "activity/".$radio_name."/".$element_id.".".$ext[1];
			}
		
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				global $_POST, $_FILES;
				if(move_uploaded_file($_FILES['arquivo']['tmp_name'], $full_local_path));
				print '<h3>O arquivo <b>'.$_FILES['arquivo']['name'].'</b> foi enviado com sucesso ao servidor!</h3>';
			}
		
			if(($radio_name=="image")){ 
				$tam_img = getimagesize($full_local_path);//      TamanhodaImagem(); 
				$DimX = $tam_img[0];
				$DimY = $tam_img[1];				
				$SQLu = "UPDATE image SET dim_x=".$DimX.", dim_y=".$DimY." WHERE id = ".$element_id."";
				$resu = pg_query($SQLu);
			}

			if(isset($verbal) && ($verbal=="oral" || $verbal="written")){
				$SQLm = "SELECT id 
						FROM ".$radio_name."
						WHERE name = '".convertem($text)."'";
			}elseif(!isset($verbal) || (isset($verbal) && $verbal=="")){
				$SQLm = "SELECT id 
						 FROM word
						 WHERE name = '".convertem($name)."'";
			}
			$SQLm .=	  " AND idiom_id=".$idiom_id." 
					ORDER BY id DESC";
			if($resm = pg_query($SQLm)){
				$lm = pg_fetch_array($resm);
				if(!isset($verbal) || (isset($verbal) && $verbal!="oral")){
					$word_id = $lm['id'];
				}				
				if(isset($verbal) && $verbal=="oral"){
					$SQLtx = "INSERT INTO ".$radio_name."_sound (".$radio_name."_id, sound_id, sex, age) VALUES(".$lm['id'].", ".$element_id.", '".$sex."', ".$age.");";
				}elseif(!isset($verbal) || (isset($verbal) && $verbal!="oral")){
					$SQLtx = "INSERT INTO word_".$radio_name." (word_id, ".$radio_name."_id) VALUES(".$word_id.", ".$element_id.");";
				}
				$restx = pg_query($SQLtx);
			}//if($resm = pg_query($SQLm)){
		}else{
			$ERROmediasel = "<h3 align='center'><font color='red'>ERRO:</font> ".$SQLim."</h3>";
			$ERROmediasel .= "<p align='center'><strong>Favor comunicar esse erro a <a href='mailto:fabio@enscer.com.br?subject=ERROmediasel&body=".$SQLim."'>fabio@enscer.com.br</a></strong></p>";
			exit;	
		}//if($res = pg_query($SQL)){
	}//}elseif(isset($radio_name) && ($radio_name=="image" || $radio_name=="sound" || $radio_name=="movie")){
}//if((!isset($element_id)) || (isset($element_id) && $element_id=="")){

//-------------------------------------------------------------------------------------------------------------------//INSERT-ELEMENT

//___________________________________________________________________________________________________________________PIECEELEMENT_INS

if((isset($pieceelement_ins) && $pieceelement_ins==true) && (!isset($word_insert) || (isset($word_insert) && $word_insert==false))){

	if(!isset($piece_id) || (isset($piece_id) && $piece_id=="")){

		$SQL1 = "SELECT seq FROM piece WHERE activity_id = ".$activity_id." ORDER BY seq DESC";
		$res1 = pg_query($SQL1);
		$l1 = pg_fetch_array($res1);
		$totalpeseq = $l1['seq'];	
		
		$SQL2 = "INSERT INTO piece (activity_id, seq, actor_id) VALUES (".$activity_id.", ".($totalpeseq+1).", ".$actor.")";
		if($res2 = pg_query($SQL2)){
			
			$SQL3 = "SELECT id FROM piece ORDER BY id DESC";
			$res3 = pg_query($SQL3);
			$l3 = pg_fetch_array($res3);
			$piece_id = $l3['id'];
			
			if(isset($newpiece) && $newpiece==true){
				$screenins = $screen;	
			}else{
				$screenins = $totalscreen+1;
			}
		}else{
			$ERROpiece = "<h3 align='center'><font color='red'>ERRO:</font> ".$SQL2."</h3>";
			$ERROpiece .= "<p align='center'><strong>Favor comunicar esse erro a <a href='mailto:fabio@enscer.com.br?subject=ERROpiece&body=".$SQL2."'>fabio@enscer.com.br</a></strong></p>";		
		}
	}else{
		$screenins = $screen;
	}//if(!isset($piece_id) || (isset($piece_id) && $piece_id=="")){
	
	$SQLsp = "SELECT seq FROM piece_element WHERE piece_id = ".$piece_id." ORDER BY seq DESC";
	$ressp = pg_query($SQLsp);
	if($lsp = pg_fetch_array($ressp)){
		$peseq = $lsp['seq'];
	}else{
		$peseq = 0;
	}

	$SQLg = "SELECT grouping FROM layer_property WHERE piece_id = ".$piece_id." ORDER BY grouping DESC";
	$resg = pg_query($SQLg);
	if($lg = pg_fetch_array($resg)){
		$grouping = $lg['grouping'];
	}else{
		$grouping = 0;
	}

	if(isset($piece_element) && $piece_element!=""){
		$SQLslp = "SELECT seq FROM layer_property WHERE piece_element_id = ".$piece_element." AND element_id = ".$element_id." ORDER BY seq DESC";
		$resslp = pg_query($SQLslp);
		if(pg_num_rows($resslp)>0){
			$lslp = pg_fetch_array($resslp);
			$lpseq = $lslp['seq'];
		}else{
			$lpseq = 0;
		}
	}else{
		$lpseq = 0;
	}

	if(isset($verbal) && $verbal=="oral"){
		$elementtype_id = 6;
		$DimX = 36;
		$DimY = 36;
	}
	
	$SQLpe = "INSERT INTO piece_element (piece_id, element_id, elementtype_id, seq, actor_id) 
								VALUES(".$piece_id.", ".$element_id.", ".$elementtype_id.", ".($peseq+1).", ".$actor.");";
	if($respe = pg_query($SQLpe)){	

		$SQLspe = "SELECT id FROM piece_element ORDER BY id DESC";
		$resspe = pg_query($SQLspe);
		$pespe = pg_fetch_array($resspe);

		$SQLspp = "SELECT pp.dim_y 
				FROM layer_property pp
						LEFT JOIN piece_element pe ON pe.id = pp.piece_element_id
				WHERE pe.piece_id=".$piece_id."";
		$resspp = pg_query($SQLspp);
		$totalposy = 0;	
		while($lspp = pg_fetch_array($resspp)){
			$totalposy = $totalposy+$lspp['dim_y']+20;
		}
		$totalposy = $totalposy+40;
		$PosX = 20;
		$PosY = $totalposy;

		$SQLlp = "INSERT INTO layer_property (piece_element_id, layer_id, element_id, piece_id, event_id, screen, pos_x, pos_y, dim_x, dim_y, seq, layertype_id, grouping, actor_id)
				VALUES (".$pespe['id'].", ".$pespe['id'].", ".$element_id.", ".$piece_id.", ".$event_id.", ".($screenins).", ".$PosX.", ".$PosY.", ".$DimX.", ".$DimY.", ".($lpseq+1).", ".$layertype_id.", ".($grouping+1).", ".$actor.")";		
		if($reslp = pg_query($SQLlp)){	
			if($elementtype_id==7 || $elementtype_id==8 || $elementtype_id==9 || $elementtype_id==10  || $elementtype_id==13){
				$SQL = "SELECT id FROM layer_property ORDER BY id DESC";
				$res = pg_query($SQL);
				$l = pg_fetch_array($res);
				$SQLilt = "INSERT INTO layer_text (layer_property_id, element_id, elementtype_id, name, piece_element_id)
							VALUES (".$l['id'].", ".$element_id.", ".$elementtype_id.", '".$text."', ".$pespe['id'].")";
				$resilt = pg_query($SQLilt);
			}
		}else{
			$ERROlayer = "<h3 align='center'><font color='red'>ERRO:</font> ".$SQLlp."</h3>";
			$ERROlayer .= "<p align='center'><strong>Favor comunicar esse erro a <a href='mailto:fabio@enscer.com.br?subject=ERROlayer&body=".$SQLlp."'>fabio@enscer.com.br</a></strong></p>";
		}
	}else{
		$ERROpieceelement = "<h3 align='center'><font color='red'>ERRO:</font> ".$SQLspe."</h3>";
		$ERROpieceelement .= "<p align='center'><strong>Favor comunicar esse erro a <a href='mailto:fabio@enscer.com.br?subject=ERROpieceelement&body=".$SQLspe."'>fabio@enscer.com.br</a></strong></p>";
	}
}//($pieceelement_ins==true)){	
//-----------------------------------------------------------------------------------------------------------------//PIECEELEMENT_INS
//echo "SQL".$SQL."<br>";
//echo "SQLi".$SQLi."<br>";
//echo "SQLs".$SQLs."<br>";
//echo "SQLim".$SQLim."<br>";
//echo "SQLe".$SQLe."<br>";
//echo "SQLu".$SQLu."<br>";
//echo "SQLm".$SQLm." - verbal: ".$verbal."<br>";
//echo "SQLtx".$SQLtx."<br>";
//echo $SQL1."<br>";
//echo $SQL2."<br>";
//echo $SQL3."<br>";
//echo $SQLslp;
//echo $SQLpe."<br>";
//echo $SQLspp."<br>";
//echo $SQLlp."<br>";
//echo $SQLilt;
//exit;
?>