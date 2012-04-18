<?php
session_start();
ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
include("includes/conecta.php");
ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
//________________________________________________________________________________________________________________________________VAR
if((!isset($idiom_id)) || (isset($idiom_id) && $idiom_id=="")){$idiom_id = 7;}
if((!isset($event_id)) || (isset($event_id) && $event_id=="")){$event_id = 1;}
if((!isset($layertype_id)) || (isset($layertype_id) && $layertype_id=="")){$layertype_id = 1;}
if(isset($radio_name) && $radio_name=='noise'){$elementtype_id = 4;$radio_name = "sound";$noise = true;}
if(isset($radio_name) && $radio_name=='music'){$elementtype_id = 5;$radio_name = "sound";$music = true;}
//------------------------------------------------------------------------------------------------------------------------------//VAR

//_________________________________________________________________________________________________________________________ELEMENT.PHP
if(isset($pieceelement_ins) && $pieceelement_ins==true){
	ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
	include("element.php");
	ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
//	echo "<script>window.opener.reloadPage(); </script >";
	if(!isset($word_insert) || (isset($word_insert) && $word_insert==false)){
		echo "<script>window.close()</script >";
	}
}
//-----------------------------------------------------------------------------------------------------------------------//ELEMENT.PHP

//_____________________________________________________________________________________________________________________________DELETE
if(isset($delete) && $delete==true){
	$SQL = "SELECT a.name, a.goal_id
			FROM piece_element pe
					LEFT JOIN piece p ON p.id = pe.piece_id
					LEFT JOIN activity a ON a.id = p.activity_id
			WHERE element_id = ".$element_id." AND
					elementtype_id = ".$elementtype_id."";
	$res = pg_query($SQL);
	if(pg_num_rows($res)==0){
		$SQL = "DELETE FROM ".$radio_name." WHERE id = ".$element_id."";
		$res = pg_query($SQL);
//		echo "delete";
	}else{
		echo "<h3><font color='red'>Esse ".$radio_name." está sendo utilizado nas seguintes atividades: </font></h3>";
		while($l = pg_fetch_array($res)){
			$SQL1 = "SELECT g.description FROM goal g WHERE g.id = ".$l['goal_id']."";
			$res1 = pg_query($SQL1);
			$l1 = pg_fetch_array($res1);
			echo "<p>".$l1['description']." ".$l['name']."</p>";
		}
	}
}

//---------------------------------------------------------------------------------------------------------------------------//DELETE

//____________________________________________________________________________________________________________________________ TEXT_INS
if(isset($text_ins) && $text_ins==true){

	if(($radio_name=="image") || ($radio_name=="movie") || ($radio_name=="sound")){
		$SQL = "SELECT * 
			FROM word 
			WHERE name = '".convertem($name)."' AND 
				  idiom_id=".$idiom_id."";
	}else{
		$SQL = "SELECT * 
				FROM ".$radio_name." 
				WHERE name = '".convertem($text)."' AND 
					  idiom_id=".$idiom_id."";
	}
	$res = pg_query($SQL);
//echo $SQL."<br>";
	if(pg_num_rows($res)>0){
		$erro40 = "<h3 align='center'><font color='red'>ERRO:</font> ".$SQL."</h3>";
		$erro40 .= "<p align='center'><strong>Favor comunicar esse erro a <a href='mailto:fabio@enscer.com.br?subject=elementbean_erro40&body=elementbean_erro40=".$SQL."'>fabio@enscer.com.br</a></strong></p>";
		echo $erro40;
		exit;
	}
	if(pg_num_rows($res)==0){
		if(($radio_name=="image") || ($radio_name=="movie") || ($radio_name=="sound")){
			$SQLi = "INSERT INTO word (name, idiom_id) VALUES ('".strtoupper($name)."', ".$idiom_id.");";
		}else{
			$SQLi = "INSERT INTO ".$radio_name." (name, idiom_id) VALUES ('".strtoupper($text)."', ".$idiom_id.");";
		}
//echo $SQli."<br>";
		$resi = pg_query($SQLi); 
	}
}
//--------------------------------------------------------------------------------------------------------------------------//TEXT_INS

//________________________________________________________________________________________________________________________________ UPPER_TEXT
function convertem($term) { 
	$palavra = strtr(strtoupper($term),"àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ","ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß");
    return $palavra; 
} 
//--------------------------------------------------------------------------------------------------------------------------//UPPER_TEXT

//________________________________________________________________________________________________________________________________BODY
?>
<html>
<head>
<title><?php echo $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="activity.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
if(isset($text_sel) && $text_sel==true){

	$SQL = "SELECT rn.id, rn.name ";
	if($radio_name=="word"){
		$SQL .= ", ac.name_varchar";
	}
	$SQL .= " FROM ".$radio_name." rn";
	if($radio_name=="word"){
		$SQL .= " LEFT JOIN activitycontent ac ON ac.id = rn.content_id";
	}
	$SQL .= " WHERE rn.name";
	if($radio_name=="word" || $radio_name=="compound"){
		$SQL .= " = '".convertem($text)."'";
	}else{
		$SQL .= " LIKE '%".convertem($text)."%'";
	}
//echo $SQL;
	$res = pg_query($SQL);
	if(pg_num_rows($res)>0){

		$SQLet = "SELECT id FROM elementtype WHERE name = '".$radio_name."'";
		$reset = pg_query($SQLet);
		$let = pg_fetch_array($reset);
		$elementtype_id = $let['id'];
		$i = 0;	
		echo "<h2>".(isset($music)?"Musicas associadas":(isset($noise)?"Sons associados":(isset($verbal) && $verbal=="oral"?"Falas associadas":$radio_name." associados")))." ao texto digitado: <font color='red'>".$text."</font></h2>";
		echo "<table width='100%' border='1 solid #fff' cellpading='0' cellspacing='0'>";
		while($l = pg_fetch_array($res)){

			$i ++;

			echo "<tr><td><h3>";
			if(isset($verbal) && $verbal=="written"){
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
				$DimY=(round((strlen($ls['name'])/100))*22);
				if($DimY < 22){ $DimY = 22; }
				echo "<a href='element_bean.php?activity_id=".$activity_id."&activitytype_id=".$activitytype_id."&screen=".$screen."&radio_name=".$radio_name;
												echo "&verbal=written";
												if(isset($piece_id) && $piece_id!=""){
													echo "&piece_id=".$piece_id;
													echo "&piecename=".$piecename;
												}
												echo "&element_id=".$l['id'];
												echo "&layertype_id=".$layertype_id;
												//echo "&elementtype_id=".$elementtype_id."&event_id=".$event_id."&peseq=".$peseq."&lpseq=".$lpseq."&grouping=".$grouping."&layertype_id=".$layertype_id;
												if(isset($totalscreen) && $totalscreen!=""){
													echo "&totalscreen=".$totalscreen;
												}
												if(isset($newscreen) && $newscreen==true){
													echo "&newscreen=true";
												}
												if(isset($newpiece) && $newpiece==true){
													echo "&newpiece=true";
												}
												if(isset($newpieceelement) && $newpieceelement==true){
													echo "&newpieceelement=true";
												}
												if(isset($text) && $text!=""){
													echo "&text=".$text;
												}
												echo "&pieceelement_ins=true&DimX=".$DimX."&DimY=".$DimY."'>";
			}
			
			echo $l['name'].($radio_name=="word"?" - ".$l['name_varchar']:"");
			
			if(isset($verbal) && $verbal=="written"){
				echo "</a>";
			}
			echo "</h3></td>";
			echo "<td>";
			if(isset($verbal) && $verbal=="written"){
				echo "<a href='element_bean.php?delete=true&activity_id=".$activity_id."&activitytype_id=".$activitytype_id."&screen=".$screen."&radio_name=".$radio_name;
													echo "&verbal=written&text_sel=true";
													if(isset($piece_id) && $piece_id!=""){
														echo "&piece_id=".$piece_id;
													}
													echo "&layertype_id=".$layertype_id;
													echo "&element_id=".$l['id'];
													echo "&elementtype_id=".$elementtype_id;
													echo "&event_id=".$event_id;
													echo "&peseq=".$peseq;
													echo "&lpseq=".$lpseq;
													echo "&grouping=".$grouping;
													echo "&layertype_id=".$layertype_id;
													if(isset($newscreen) && $newscreen==true){
														echo "&newscreen=true";
													}
													if(isset($newpiece) && $newpiece==true){
														echo "&newpiece=true";
													}
													if(isset($newpieceelement) && $newpieceelement==true){
														echo "&newpieceelement=true";
													}
													if(isset($totalscreen) && $totalscreen!=""){
														echo "&totalscreen=".$totalscreen;
													}
													if(isset($text) && $text!=""){
														echo "&text=".$text;
													}
				echo "'> - Del</a>";
			}elseif(isset($verbal) && $verbal=="oral"){
				echo "<a href='element_bean.php?activity_id=".$activity_id."&activitytype_id=".$activitytype_id."&screen=".$screen."&radio_name=".$radio_name;
												echo "&text_sel=true&verbal=oral";
												if(isset($piece_id) && $piece_id!=""){
													echo "&piece_id=".$piece_id;
													echo "&piecename=".$piecename;
												}
												echo "&layertype_id=".$layertype_id;
												if(isset($newscreen) && $newscreen==true){
													echo "&newscreen=true";
												}
												if(isset($newpiece) && $newpiece==true){
													echo "&newpiece=true";
												}
												if(isset($newpieceelement) && $newpieceelement==true){
													echo "&newpieceelement=true";
												}
												if(isset($totalscreen) && $totalscreen!=""){
													echo "&totalscreen=".$totalscreen;
												}
												if(isset($text) && $text!=""){
													echo "&text=".$text;
												}
												echo "&audio_ins=true&elementid=".$l['id']."";
												echo "'>Inserir audio</a>";
			}
			echo "</td></tr>";
			if((isset($audio_ins) && $audio_ins==true) && ($elementid == $l['id'])){ ?>
				<tr><td><form name="media" action="element_bean.php" method="POST" enctype="multipart/form-data">
				<h3>Carregar Novo Audio: <input type="file" name="arquivo">
				<select name="sex">
					<option value"m">M</option>
					<option value"f">F</option>
				</select>
				Age<input type="text" name="age" size="1">
				<input type='hidden' name='activity_id' value='<?php echo $activity_id; ?>'> 
				<input type='hidden' name='activitytype_id' value='<?php echo $activitytype_id; ?>'> 
				<input type="hidden" name="screen" value="<?php echo $screen; ?>">
				<input type="hidden" name="radio_name" value="<?php echo $radio_name; ?>">
				<?php if(isset($piece_id) && $piece_id!=""){ ?>
					<input type="hidden" name="piece_id" value="<?php echo $piece_id; ?>">
				<?php } ?>
				<?php if(isset($newscreen) && $newscreen==true){ ?>
					<input type="hidden" name="newscreen" value="true">
				<?php } ?>
				<?php if(isset($newpiece) && $newpiece==true){ ?>
					<input type="hidden" name="newpiece" value="true">
				<?php } ?>
				<?php if(isset($newpieceelement) && $newpieceelement==true){ ?>
					<input type="hidden" name="newpieceelement" value="true">
				<?php } ?>
				<?php if(isset($totalscreen) && $totalscreen!=""){ ?>
					<input type="hidden" name="totalscreen" value="<?php echo $totalscreen; ?>">
				<?php } ?>
				<?php if(isset($text) && $text!=""){ ?>
					<input type="hidden" name="text" value="<?php echo $text; ?>">
				<?php } ?>
				<?php if(isset($layertype_id) && $layertype_id!=""){ ?>
					<input type="hidden" name="layertype_id" value="<?php echo $layertype_id; ?>">
				<?php } ?>
				<input type="hidden" name="verbal" value="oral">
				<input type="hidden" name="pieceelement_ins" value="true">
				<input type="submit" value="Inserir" style="border: 1pt solid #222222; background-color:#444444; color: #EEEEEE; width: 60px; height:20px;">
				</h3>
				</form></td></tr><?php
			}
			if(isset($verbal) && $verbal=="oral"){
				$SQLs = "SELECT * FROM ".$radio_name."_sound WHERE ".$radio_name."_id = ".$l['id']."";
				$ress = pg_query($SQLs);
				if(pg_num_rows($ress)>0){
					while($ls = pg_fetch_array($ress)){
						echo "<tr><td colspan='2'><a href='element_bean.php?activity_id=".$activity_id."&activitytype_id=".$activitytype_id."&screen=".$screen."&radio_name=".$radio_name;
												echo "&verbal=oral";
												if(isset($piece_id) && $piece_id!=""){
													echo "&piece_id=".$piece_id;
													echo "&piecename=".$piecename;
												}
												echo "&element_id=".$ls['sound_id'];
												echo "&layertype_id=".$layertype_id;
												if(isset($newscreen) && $newscreen==true){
													echo "&newscreen=true";
												}
												if(isset($newpiece) && $newpiece==true){
													echo "&newpiece=true";
												}
												if(isset($newpieceelement) && $newpieceelement==true){
													echo "&newpieceelement=true";
												}
												if(isset($totalscreen) && $totalscreen!=""){
													echo "&totalscreen=".$totalscreen;
												}
												if(isset($text) && $text!=""){
													echo "&text=".$text;
												}
												echo "&pieceelement_ins=true'>".$ls['id']." - ".$ls['sex']." - ".$ls['age']."</a></td></tr>";
					}
				}else{
					echo "<tr><td colspan='2'<h3><font color='red'>Não há audio registrado para esse texto!</font></h3></td></tr>";
				}
			}//if(isset($verbal) && $verbal=="oral"){
		}//while($l = pg_fetch_array($res)){
		echo "</table>";
	}else{//if(pg_num_rows($res)>0){
		echo "<h3><font color='red'>Não há ".$radio_name." associados com essa busca!</font></h3>"; ?>
		<form name="text_ins" action="element_bean.php">
			<textarea rows="7" cols="80" name="text"><?php echo $text; ?></textarea>
			<input type='hidden' name='activity_id' value='<?php echo $activity_id; ?>'> 
			<input type='hidden' name='activitytype_id' value='<?php echo $activitytype_id; ?>'> 
			<input type="hidden" name="screen" value="<?php echo $screen; ?>">
			<input type="hidden" name="radio_name" value="<?php echo $radio_name; ?>">
			<?php if(isset($piece_id) && $piece_id!=""){ ?>
				<input type="hidden" name="piece_id" value="<?php echo $piece_id; ?>">
			<?php } ?>
			<?php if(isset($newscreen) && $newscreen==true){ ?>
				<input type="hidden" name="newscreen" value="true">
			<?php } ?>
			<?php if(isset($newpiece) && $newpiece==true){ ?>
				<input type="hidden" name="newpiece" value="true">
			<?php } ?>
			<?php if(isset($newpieceelement) && $newpieceelement==true){ ?>
				<input type="hidden" name="newpieceelement" value="true">
			<?php } ?>
			<?php if(isset($totalscreen) && $totalscreen!=""){ ?>
				<input type="hidden" name="totalscreen" value="<?php echo $totalscreen; ?>">
			<?php } ?>
			<?php if(isset($verbal) && $verbal!=""){ ?>
				<input type="hidden" name="verbal" value="<?php echo $verbal; ?>">
			<?php } ?>
			<?php if(isset($verbal) && $verbal=="written"){ ?>
				<input type="hidden" name="pieceelement_ins" value="true">
			<?php } ?>
			<?php if(isset($layertype_id) && $layertype_id!=""){ ?>
				<input type="hidden" name="layertype_id" value="<?php echo $layertype_id; ?>">
			<?php } ?>
				<input type="hidden" name="text_sel" value="true">
				<input type="hidden" name="text_ins" value="true">
			<input type="submit" value="Inserir" style="border: 1pt solid #222222; background-color:#444444; color: #EEEEEE; width: 60px; height:20px;">
		</form><?php
	}
	?>
<?php } //if(isset($text_sel) && $text_sel==true){

if(isset($media_sel) && $media_sel==true){
	$word_insert=false;
	//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-TEXT_INS
	$SQL = "SELECT id 
			FROM word 
			WHERE name = '".convertem($name)."' AND 
				  idiom_id=".$idiom_id."";
	$res = pg_query($SQL);
	
	if(pg_num_rows($res)==0){
		$word_insert = true;
		echo "<h3><font color='red'>Não existe essa palavra no banco!</font></h3>";
		echo "<hr>";
		echo "<h3>Deseja inserir a palavra <font color='blue'>".$name."</font>no banco de dados? <a href='element_bean.php?";
														echo "text_ins=true";
														echo "&word_insert=true";
														echo "&media_sel=true";
														echo "&name=".$name;
														echo "&activity_id=".$activity_id;
														echo "&activitytype_id=".$activitytype_id;
														echo "&screen=".$screen;
														echo "&radio_name=".$radio_name;
														if(isset($piece_id) && $piece_id!=""){
															echo "&piece_id=".$piece_id;
														}
														if(isset($newscreen) && $newscreen==true){
															echo "&newscreen=true";
														}
														if(isset($totalscreen) && $totalscreen!=""){
															echo "&totalscreen=".$totalscreen;
														}
														if(isset($newpiece) && $newpiece==true){
															echo "&newpiece=true";
														}
														if(isset($newpieceelement) && $newpieceelement==true){
															echo "&newpieceelement=true";
														}
														echo "'>Sim</a> - <a href='#' onClick='window.close()'>Não</a></h3>";
	}else{//if(pg_num_rows($res)==0){
	
	//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-MEDIA_SEL
		$l = pg_fetch_array($res);
		$word_id = $l['id'];
	
		$SQL = "SELECT wm.word_id, wm.".$radio_name."_id as radio_name_id, w.id, w.name, m.*";
		if($radio_name=="sound"){
			$SQL .= ", wm.age, wm.sex ";
		}
		$SQL .=	"FROM word_".$radio_name." wm
						LEFT JOIN word w ON w.id = wm.word_id
						LEFT JOIN ".$radio_name." m ON m.id = wm.".$radio_name."_id
				WHERE name = '".strtoupper($name)."'";
		$res = pg_query($SQL);
		
		echo "<hr>";
		
		if(pg_num_rows($res)>0){
			if($radio_name!="sound"){
				$SQLet = "SELECT id FROM elementtype WHERE name = '".$radio_name."'";
				$reset = pg_query($SQLet);
				$let = pg_fetch_array($reset);
				$elementtype_id = $let['id'];
			}
			echo "<h2>".$radio_name." associados à palavra: <font color='red'>".$name."</font></h2>";
			echo "<table width='900'>";
			while($l = pg_fetch_array($res)){
				if($i==1 || $i==6 || $i==11 || $i==16){
					echo "<tr>";
				}
				echo "<td><table><tr><td><a href='element_bean.php?pieceelement_ins=true&name=".$name."&DimX=".$l['dim_x']."&DimY=".$l['dim_y']."&element_id=".$l['radio_name_id'];
				ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
				include("activity_link.php");
				ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);														
				if($radio_name=="image" || $radio_name=="movie"){
					echo "'>Inserir</a>";
					echo "<a href='#' onClick=\"javascript:window.open('media_view.php?radio_name=".$radio_name."&url=activity/".$radio_name."/".$l['id'].".".$l['extension']."','mediaview','fullscreen=3,statusbar=no,menubar=no,resizable=no,scrollbars=no,titlebar=no,toolbar=no,left=145,top=120,width=".($l['dim_x']+20).",height=".($l['dim_y']+20)."')\">Ver Maior</a></td></tr>";
				}elseif($radio_name=="sound"){
					if($music==true){
						echo "'>Music</a>";
					}elseif($noise==true){
						echo "'>Noise</a>";
					}else{
						echo "'>".$l['sex']." - ".$l['age']."</a>";
					}
				}
				if($radio_name=="image"){
					echo '<tr><td><img src="activity/'.$radio_name.'/'.$l['id'].'.'.$l['extension'].'" border="0" width="100" height="100"></a></td></tr></table>';
				}elseif($radio_name=="movie"){
					echo '<tr><td><embed src="activity/'.$radio_name.'/'.$l['id'].'.'.$l['extension'].'" quality="high" type="application/x-shockwave-flash" width="100" height="100"></embed></a></td></tr></table>'; //width="'.$l['dim_x'].'" height="'.$l['dim_y'].'"
				}
			echo "</td>";
			if($i==6 || $i==11 || $i==16){
				echo "</tr>";
			}
		}
			echo "</table>";
		}else{
			echo "<h3><font color='red'>Não há ".(isset($music)?"nenhuma Música associada":(isset($noise)?"nenhum Som associados":(isset($verbal) && $verbal=="oral"?"nenhuma Fala associada":"nenhuma ".$radio_name." associado")))." a palavra: </font>".$name."!</h3>";
		}
		
		$SQLr = "SELECT w.name, w.wordroot1_id, (wr.name) as rootname
				 FROM word w
						LEFT JOIN wordroot wr ON wr.id = w.wordroot1_id
				 WHERE w.name = '".convertem($name)."'";
		$resr = pg_query($SQLr);
		if(pg_num_rows($resr)>0){
			echo "<hr><h3>".(isset($music)?"Musicas associadas":(isset($noise)?"Sons associados":(isset($verbal) && $verbal=="oral"?"Falas associadas":$radio_name." associados")))." às palavras da raíz: ".$rootname."</h3>";
			if($lr['wordroot1_id']!=""){
				while($lr = pg_fetch_array($resr)){
					$wordroot1 = "";
					echo "<h3>".$lr['name']."</h3>";
					$SQLw = "SELECT *
							 FROM word
							 WHERE ((wordroot1_id = ".$lr['wordroot1_id'].") or (wordroot2_id = ".$lr['wordroot1_id']."))";
					if($lr['wordroot2_id']!=""){ 
						$SQLw.= " OR ((wordroot1_id = ".$lr['wordroot2_id'].") or (wordroot2_id = ".$lr['wordroot2_id']."))";
					}
					$resw = pg_query($SQLw);
					echo "<table width='100%'>";
					while($lw = pg_fetch_array($resw)){
						if($lw['wordroot1_id']!=$wordroot1){
							$wordroot1 = $lw['wordroot1_id'];
							$SQLwi = "SELECT ".$radio_name."_id as radio_name_id FROM word_".$radio_name." WHERE word_id = ".$lw['id']."";
							$reswi = pg_query($SQLwi);
							if(pg_num_rows($reswi)>0){
								$i=0;
								while($lwi = pg_fetch_array($reswi)){
									$i ++;
									$SQLi = "SELECT * FROM ".$radio_name." WHERE id = ".$lwi['radio_name_id']."";
									$resi = pg_query($SQLi);
									$li = pg_fetch_array($resi);
							if($i==1 || $i==6 || $i==11 || $i==16){
								echo "<tr>";
							}
									echo "<td>";
										echo "<table><tr><td>".$lw['name']."</td></tr>";
											echo "<tr><td><a href='element_bean.php?";
														echo "name=".$name;
														echo "&activity_id=".$activity_id;
														echo "&activitytype_id=".$activitytype_id;
														echo "&screen=".$screen;
														echo "&radio_name=".$radio_name;
														if(isset($piece_id) && $piece_id!=""){
															echo "&piece_id=".$piece_id;
														}
														echo "&element_id=".$l['radio_name_id'];
														if(isset($newscreen) && $newscreen==true){
															echo "&newscreen=true";
														}
														if(isset($totalscreen) && $totalscreen!=""){
															echo "&totalscreen=".$totalscreen;
														}
														if(isset($newpiece) && $newpiece==true){
															echo "&newpiece=true";
														}
														if(isset($newpieceelement) && $newpieceelement==true){
															echo "&newpieceelement=true";
														}
														echo "&pieceelement_ins=true";
														echo "&DimX=".$l['dim_x']."";
														echo "&DimY=".$l['dim_y']."";
														echo "'>Inserir</a>";
														echo "<a href='#' onClick=\"javascript:window.open('media_view.php?radio_name=".$radio_name."&url=activity/".$radio_name."/".$l['id'].".".$l['extension']."','mediaview','fullscreen=3,statusbar=no,menubar=no,resizable=no,scrollbars=no,titlebar=no,toolbar=no,left=145,top=120,width=".($l['dim_x']+20).",height=".($l['dim_y']+20)."')\">Ver Maior</a></td></tr>";
												if($radio_name=="image"){
													echo '<tr><td><img src="activity/'.$radio_name.'/'.$l['id'].'.'.$l['extension'].'" border="0" width="100" height="100"></a></td></tr>';
												}elseif($radio_name=="movie"){
													echo '<tr><td><embed src="activity/'.$radio_name.'/'.$l['id'].'.'.$l['extension'].'" quality="high" type="application/x-shockwave-flash" width="100" height="100"></embed></a></td></tr>'; //width="'.$l['dim_x'].'" height="'.$l['dim_y'].'"
												}
										echo "</table>";
									echo "</td>";								
							if($i==6 || $i==11 || $i==16){
								echo "</tr>";
							}
								}//while($lwi = pg_fetch_array($reswi)){
								echo "</table>";
							}else{
								echo "<h3><font color='red'>Não há nenhuma imagem associada às raizes dessa palavra!</font></h3>";
							}
						}//if($lr['wordroot1_id']!=$wordroot1){
					}
				}//while($lr = pg_fetch_array($resr)){
			}else{
				echo "<h3><font color='red'>Essa palavra não tem raiz cadastrada!</font></h3>";
			}//if($lr['wordroot1_id']!=""){
		}//if(pg_num_rows($resr)>0){
	}//elseif(pg_num_rows($res)==0){
}//isset($media_sel){

if((isset($media_sel) && $media_sel==true) && ($word_insert==false)){ ?>
	<form name="media" action="element_bean.php" method="POST" enctype="multipart/form-data">
		<hr>
		<h3>Carregar <?php echo (isset($music)?"Nova Música":(isset($noise)?"Novo Som":(isset($verbal) && $verbal=="oral"?"Nova Fala":"Novo ".$radio_name))); ?> </h3>
<?php /*
		<div class="fileinputs"> 
		<input type="file" class="file" />
		<div class="fakefile"> 
		  <input />
		  <img src="images/search.gif" /> </div>
		</div>
*/ ?>
		<input type="file" name="arquivo">

<?php if($radio_name=="movie"){ ?>
			DimX <input type="text" name="DimX" size="1">
			| DimY <input type="text" name="DimY" size="1">
<?php }
	  
	  if(($radio_name=="image")){ ?>
			<p>
			| |<input type="radio" name="color" value="PB"> PB |
			|<input type="radio" name="color" value="COLOR"> Color |
			|<input type="radio" name="content" value="OBJECT"> Object |
			|<input type="radio" name="content" value="SCENE"> Scene | |
			Estilo: <select name="style">
			<?php
				$SQLdb = "SELECT style.* FROM style ORDER BY id";
				$resdb = pg_query($SQLdb);
				echo "<option value='2'>Infantil</option>";
				while($linhadb = pg_fetch_array($resdb)){
					echo "<option value='".$linhadb['id']."'>".$linhadb['name']."</option>";
				}
			?>
			</select><?php 
		} ?>
		
		<input type='hidden' name='activity_id' value='<?php echo $activity_id; ?>'> 
		<input type='hidden' name='activitytype_id' value='<?php echo $activitytype_id; ?>'> 
		<input type="hidden" name="screen" value="<?php echo $screen; ?>">
		<input type="hidden" name="radio_name" value="<?php echo $radio_name; ?>">
		<?php if(isset($elementtype_id) && $elementtype_id!=""){ ?>
			<input type="hidden" name="elementtype_id" value="<?php echo $elementtype_id; ?>">
		<?php } ?>
		<?php if(isset($piece_id) && $piece_id!=""){ ?>
			<input type="hidden" name="piece_id" value="<?php echo $piece_id; ?>">
		<?php } ?>
		<?php if(isset($piece_element) && $piece_element!=""){ ?>
			<input type='hidden' name='piece_element' value='<?php echo $piece_element; ?>'>
			<input type='hidden' name='element_id' value='<?php echo $element_id; ?>'>
			<input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
			<input type="hidden" name="layertype_id" value="<?php echo $layertype_id; ?>">
			<input type="hidden" name="grouping" value="<?php echo $grouping; ?>">
			<input type="hidden" name="lpseq" value="<?php echo $lpseq; ?>">
			<input type="hidden" name="peseq" value="<?php echo $peseq; ?>">
		<?php } ?>
		<?php if(isset($newscreen) && $newscreen==true){ ?>
			<input type="hidden" name="newscreen" value="true">
		<?php } ?>
		<?php if(isset($newpiece) && $newpiece==true){ ?>
			<input type="hidden" name="newpiece" value="true">
		<?php } ?>
		<?php if(isset($newpieceelement) && $newpieceelement==true){ ?>
			<input type="hidden" name="newpieceelement" value="true">
		<?php } ?>
		<?php if(isset($totalscreen) && $totalscreen!=""){ ?>
			<input type="hidden" name="totalscreen" value="<?php echo $totalscreen; ?>">
		<?php } ?>
		<?php if(isset($verbal) && $verbal!=""){ ?>
			<input type="hidden" name="verbal" value="<?php echo $verbal; ?>">
		<?php } ?>
		<?php if(isset($name) && $name!=""){ ?>
			<input type="hidden" name="name" value="<?php echo $name; ?>">
		<?php } ?>
		<?php if(isset($text) && $text!=""){ ?>
			<input type="hidden" name="text" value="<?php echo $text; ?>">
		<?php } ?>
		<input type="hidden" name="pieceelement_ins" value="true">
		<input type="hidden" name="word_id" value="<?php echo $word_id; ?>">
		<input type="submit" value="Inserir" style="border: 1pt solid #222222; background-color:#444444; color: #EEEEEE; width: 60px; height:20px;">
		</p>
	</form>
	<hr>
<?php 
} ?>
</body>
</html>