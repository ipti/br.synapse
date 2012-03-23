<?php
    session_start();

       ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
       include("includes/conecta.php");
       ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

if(!(session_is_registered('person'))){
	echo "erro";
	header('Location: ' . "http://" . $_SERVER["SERVER_NAME"]."/synapse/index.php");	
}

if(isset($idiom) && $idiom=="7"){
$h1="Atividades";
$h2="Bem Vindo:";
$m_theme="Tema";
$m_activity="Atividade";
$m_piece="Peça";
}

if(isset($idiom) && $idiom=="16"){
$h1="Activities";
$h2="Welcome:";
$m_theme="Theme";
$m_activity="Activity";
$m_piece="Piece";
}

if(isset($idiom) && $idiom=="17"){
$h1="Aktivitäten";
$h2="Willkommen:";
$m_theme="Thema";
$m_activity="Aktivität";
$m_piece="Stück";
}

if(isset($acao) && $acao=="excluir"){
	$SQL = "DELETE FROM pieceprinted WHERE pieceelement_id = ".$piece_element."";
	$res = pg_query($SQL);
	$SQL = "DELETE FROM piece_element WHERE id = ".$piece_element."";
	$res = pg_query($SQL);
	$SQL = "DELETE FROM layer_property WHERE piece_element_id = ".$piece_element."";
	$res = pg_query($SQL);
}
?>

<head>
<title><?php echo $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<?php if(isset($activity) && $activity!=""){ ?>

<link href="activity.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function reloadPage(){  
   javascript:location.reload();
}

//function PlaySound(url) {
 // document.all.sound.src = url;
//}

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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
function filtra(cod) {
  document.forms["activityform"].filtragem.value = cod;
}
//-->
</script>
</head>
<body scroll='yes'>

<div id="topo"><img src="images/logo_enscerr.gif" alt="Visite o site do Enscer - Ensinando o C&eacute;rebro!" border="0"><img src="images/top_degrade.gif" width="85" height="87"></div>
<div id="fechar"><a href=javascript:window.close()><img src="images/botao_fechar.gif" border="0"></a></div>

<div id="titulo">
<?php

if(!isset($piece_id) || (isset($piece_id) && $piece_id=="")){
	$SQLp = "SELECT * 
			 FROM piece 
			 WHERE activity_id = ".$activity." AND
				   father_id is null 
			 ORDER BY SEQ";
	$resp = pg_query($SQLp);
	$linhap = pg_fetch_array($resp);
	$piece_id = $linhap['id'];
	$pieceseq=$linhap['seq'];
	$piecename=$linhap['name_varchar'];
	$piecedescription=$linhap['description'];
}

  session_register('groupname');
  echo "<h1>".(isset($blockname)?$blockname:"")."</h1>";
  echo "<h2>".(isset($activitydescription)?$activitydescription:"")."</h2>";
  echo "<h3>".(((isset($piecedescription) && $piecedescription!="null") && !isset($goaldescription))?$piecedescription:"")."</h3>";
  echo "<h1>".(isset($semanticname)?$semanticname:"")."</h1>";
  echo "<h2>".((isset($goaldescription) && $goaldescription!="")?$goaldescription:"")."</h2>";
  echo "<h3>".((isset($goaldescription) && $goaldescription!="")?$pieceseq." - ".$piecedescription:"")."</h3>";
?>
</div>
<div id="menutop">
<?php
echo "<h3>".(isset($piecename)?$piecename:"")."</h3>";

if(isset($piece_id) && $piece_id!=""){
	echo '<div id="Layer1" style="position:absolute; left:750px; top:0px; width:150px; height:75px; z-index:1">';
	$SQL = "SELECT * FROM piece WHERE id = ".$piece_id."";
	$res = pg_query($SQL);
	$l = pg_fetch_array($res);
	if($l['father_id']!=""){
		$SQL = "SELECT id FROM piece WHERE id = ".$l['father_id']."";
		$res = pg_query($SQL);
		$l = pg_fetch_array($res);
		echo "<p>Página: ";
		$SQLpf1 = "SELECT *
				  FROM piece
				  WHERE father_id = ".$l['id']."
				  ORDER BY seq";
		$respf1 = pg_query($SQLpf1);
		$ifp =0;
		while($lpf1 = pg_fetch_array($respf1)){
			$ifp ++;
			echo "<a href='piece_element.php?semantic=".$semantic."&semanticname=".$semanticname."&blockname=".$blockname."&activityname=".$activityname."&activitydescription=".$activitydescription."&activity=".$activity."&activitytype_id=".$activitytype_id."&typename=".$typename."&piece_id=".$lpf1['id']."&pieceseq=".$lpf1['seq']."&piecename=".$lpf1['name_varchar']."&piecedescription=".$lpf1['description']."'>".$ifp."</a> - ";
		}
		echo "</p>";
	}
	echo '</div>';
}
?>
</div>
<div id="menu">
<?php
echo "<p align='center'>Activity's Pieces</p><hr>";
	
$SQLp = "SELECT * 
		 FROM piece 
		 WHERE activity_id = ".$activity." AND
			   father_id is null 
		 ORDER BY SEQ";
$resp = pg_query($SQLp);

while($linhap = pg_fetch_array($resp)){
	echo "<h3><a href='piece_element.php?semantic=".$semantic."&semanticname=".$semanticname."&activity=".$activity."&goaldescription=".$goaldescription."&pieceseq=".$linhap['seq']."&piece_id=".$linhap['id']."&activityname=".$activityname."&activitydescription=".$activitydescription."&activitytype_id=".$activitytype_id."&typename=".$typename."&blockname=".$blockname."&piecename=".$linhap['name_varchar']."&piecedescription=".$linhap['description']."'>".$linhap['seq']." - ".($linhap['name_varchar']!=""?$linhap['name_varchar']:"")."</a>";
	echo "<a href='#'  onClick=\"javascript:window.open('piece_ins.php?acao=2&activity_id=".$activity."&piece_id=".$linhap['id']."&nameupd=".$linhap['name_varchar']."&descriptionupd=".$linhap['description']."&sequpd=".$linhap['seq']."','',',,,width=600,height=200')\">Upd</a>-";
	echo "<a href='#'  onClick=\"javascript:window.open('piece_ins.php?acao=3&activitytype_id=".$activitytype_id."&activity_id=".$activity."&piece_id=".$linhap['id']."','',',,,width=600,height=200')\">Del</a></h3>";
}
echo "<hr>";
echo "<p><a href='#' onClick=\"javascript:window.open('piece_ins.php?acao=1&activity_id=".$activity."&activitytype_id=".$activitytype_id."','',',,,width=600,height=200')\">Inserir Peça</a></p>";

if(isset($piece_id) && $piece_id!=""){
	$SQL = "SELECT seq FROM piece_element WHERE piece_id = ".$piece_id." ORDER BY seq DESC";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$seq = $linha['seq'];
}//if(isset($piece) && $piece!=""){
?>
</div>

<div id="conteudo" onDblClick="javascript:window.open('element.php?piece_id=<?php echo $piece_id; ?>&seq=<?php echo $seq; ?>&activitytype_id=<?php echo $activitytype_id; ?>','element','fullscreen=3,statusbar=no,menubar=no,resizable=no,scrollbars=no,titlebar=no,toolbar=no,left=0,top=0,width=1010,height=700')">
<form name="activity" action="piece_element.php">
<?php

	if(isset($piece_id) && $piece_id!=""){
		
		$SQLf = "SELECT id FROM piece WHERE father_id = ".$piece_id."";
		$resf = pg_query($SQLf);
		if(pg_num_rows($resf)>0){
			$father = true;
		}else{
			$father = false;
		}
		
		$SQLe = "SELECT pe.*, pp.pieceelement_id, pp.pos_x, pp.pos_y, pp.dim_x, pp.dim_y
				 FROM piece_element pe
				 		LEFT JOIN pieceprinted pp ON pp.pieceelement_id = pe.id
				 WHERE pe.piece_id = ".$piece_id." 
				 ORDER BY pe.seq";

		$rese = pg_query($SQLe);
		
		if((pg_num_rows($rese)>0) || ($father==false)){

			$i=0;
			$zindex = 0;
			$ipf=1;
			$ifp=1;
	
			while($linhae = pg_fetch_array($rese)){
				$piece_element = $linhae['id'];
				$i++;
				$zindex ++;
	
				$SQLen = "SELECT * FROM entity_element WHERE element_id = ".$linhae['id'].";";
				$resen = pg_query($SQLen);
				$count = 0;
				
				while ($row[$count] = pg_fetch_assoc($resen)){
					$count++;
				}
				$divwidth = $linhae['dim_x'];
				$divheight = $linhae['dim_y'];
				$divtop = $linhae['pos_y'];
				$divleft = $linhae['pos_x'];
				?>
				<STYLE>
					.div<?php echo $i; ?>{ 
						position:absolute;
						width: <?php echo $divwidth; ?> ;
						height: <?php echo $divheight; ?>;
						top: <?php echo $divtop; ?>;
						left: <?php echo $divleft ?>;
						z-index: <?php echo $zindedx ?>;
					}
				</STYLE>
				<?php	
//						border-style: solid;
//						border-width: 1px;

				// elemento imagem
				if($linhae['elementtype_id']=="2"){
					
					$cod_data = $linhae['element_id'];
	
					$SQLim = "SELECT id, extension FROM image WHERE id=".$cod_data.""; //, extension
					$resim = pg_query($SQLim);
					$linhaim = pg_fetch_array($resim);
					$image = "activity/image/".$linhaim['id'].".".$linhaim['extension'];//.$linhaim['extension']
	
					echo "<div class='div".$i."'>";
					echo "<img src='".$image."'>";
					?> <a href='piece_element.php?acao=excluir&activity=<?php echo $activity; ?>&piece_element=<?php echo $piece_element; ?>&piece_id=<?php echo $piece_id; ?>&semanticname=<?php echo $semanticname; ?>&goaldescription=<?php echo $goaldescription; ?>&pieceseq=<?php echo $pieceseq; ?>&activitytype_id=<?php echo $activitytype_id; ?>'>Del - </a> <?php
					echo "<a href='#' onClick=\"javascript:window.open('element.php?image=".$linhae['element_id']."&piece_id=".$piece_id."&acao=editar&piece_element=".$piece_element."&seq=".$seq."&element_id=".$linhae['element_id']."&element_type=".$linhae['elementtype_id']."&activitytype_id=".$activitytype_id."&divwidth=".$divwidth."&divheight=".$divheight."&divtop=".$divtop."&divleft=".$divleft."','', 'fullscreen=3,statusbar=no,menubar=no,resizable=no,scrollbars=no,titlebar=no,toolbar=no,left=210,top=480,width=860,height=300')\">Upd</a>";
					echo "</div>";
					
				}
				
				if($linhae['elementtype_id']=="3"){
					$SQLm = "SELECT name, extension FROM movie WHERE movie = ".$linhae['element_id']." ";
					$resm = pg_query($SQLm);
					$linham = pg_fetch_array($resm);
			?>
					<div class='div<?php echo $i; ?>'>
					<?php if($linham[1]=='.SWF'){ ?>
					<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="<?php echo $linhae[12] ?>" height="<?php echo $linhae[13] ?>">
					<param name="movie" value="activity/<?php echo $linham[0]; ?>.swf">
					<param name="quality" value="high">
					<embed src="activity/<?php echo $linham[0]; ?>.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="<?php echo $linhae[12] ?>" height="<?php echo $linhae[13] ?>"></embed>
					</object>
					<?php }else{ 
					//echo '<script type="text/javascript">';
					echo '<object align="center" name="RealPlayer" id="RealPlayer" width="'.$linhae[12].'" height="'.$linhae[13].'" classid="clsid:22D6F312-B0F6-11D0-94AB-0080C74C7E95" codebase="http://activex.microsoft.com/activex/%20%20%20controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701" standby="Carregando " type="application/x-oleobject" VIEWASTEXT>';
					echo '<param name="FileName" value="activity/'.$linham[0].'.wmv">';
					echo '<param name="AutoStart" value="false">';
					echo '<param name="TransparentAtStart" value="false">';
					echo '<param name="ShowControls" value="1">';
					echo '<param name="ShowDisplay" value="0">';
					echo '<param name="ShowStatusBar" value="0">';
					echo '<param name="AutoSize" value="0">';
					echo '<param name="AnimationAtStart" value="0">';
					echo '<param name="showpositioncontrols" value="0">';
					echo '<embed src="activity/'.$linham[0].'.wmv" width="'.$linhae[12].'" height="'.$linhae[13].'" autostart="false" showcontrols="1" showdisplay="0" name="RealPlayer" >';
					//echo '</object></noscript>';
					 } ?>
					</div>
				
			<?php }
			
				if($linhae['elementtype_id']=="6"){
	
					$SQLim = "SELECT extension FROM sound WHERE id=".$linhae['element_id']."";
					$resim = pg_query($SQLim);
					$linhaim = pg_fetch_array($resim);
					$sound = "activity/sound/".$linhae['element_id'].".".$linhaim['extension'];
					
					echo "<div class='div".$i."'>";
					echo "<img src='images/sound.gif' >";//onClick='PlaySound(".$sound.")'
					?> <a href='piece_element.php?acao=excluir&activity=<?php echo $activity; ?>&piece_element=<?php echo $piece_element; ?>&piece_id=<?php echo $piece_id; ?>&semanticname=<?php echo $semanticname; ?>&goaldescription=<?php echo $goaldescription; ?>&pieceseq=<?php echo $pieceseq; ?>&activitytype_id=<?php echo $activitytype_id; ?>'>Del - </a> <?php
					echo "<a href='#' onClick=\"javascript:window.open('element.php?grouping=".$linhae['grouping']."&layertype_id=".$linhae['layertype_id']."&layername=".$linhae['layername']."&image=".$linhae['element_id']."&piece_id=".$piece_id."&acao=editar&piece_element=".$piece_element."&seq=".$seq."&element_id=".$linhae['element_id']."&element_type=".$linhae['elementtype_id']."&activitytype_id=".$activitytype_id."&divwidth=".$divwidth."&divheight=".$divheight."&divtop=".$divtop."&divleft=".$divleft."','', 'fullscreen=3,statusbar=no,menubar=no,resizable=no,scrollbars=no,titlebar=no,toolbar=no,left=160,top=400,width=800,height=300')\">Upd</a>";
					echo "</div>";
					
				}
				
				if($linhae['elementtype_id']=="7" || $linhae['elementtype_id']=="8" || $linhae['elementtype_id']=="9" || $linhae['elementtype_id']=="10"){
					
	//				$SQLet = "SELECT * FROM element_text WHERE piece_element_id = ".$piece_element."";
	//				$reset = pg_query($SQLet);
	//				$linhaet = pg_fetch_array($reset);
					
					if (isset($linhaet['color']) && $linhaet['color']==-16777208){ 
						$fontcolor="#000000"; 
					}elseif(isset($linhaet['color']) && $linhaet['color']==32768){
						$fontcolor="#00FF00"; 
					}else{
						$fontcolor = "#000000";
					}
					if (isset($linhaet['color']) && $linhaet['weight']==1){
						$fontweight="700";
					}elseif(isset($linhaet['color']) && $linhaet['weight']==0){
						$fontweight="400";
					}else{
						$fontweight="400";
					}
					$fontfamily = "arial, helvetica, serif";
					$fontsize = "14px";
					
					$j=$i+3;
					echo '<STYLE type="text/css">
						h'.$j.'{
							font-family: '.$fontfamily.';
							font-size: '.$fontsize.';
							color: '.$fontcolor.';
							font-weight: '.$fontweight.';
							line-height: 1.5em;
						}
					</STYLE>';
					 //border: 1px solid #666666;
				}
				
				// elemento word
				if($linhae['elementtype_id']=="7"){
				
					$SQL7 = "SELECT * FROM word where id = ".$linhae['element_id']."";
					$res7 = pg_query($SQL7);
					$linha7 = pg_fetch_array($res7);
					if($linha7['idiom_id']==$idiom){ 
						?>
						<div class="div<?php echo $i; ?>">
						<h<?php echo $j; ?>>
						<?php echo $linha7['name']; ?>
						<?php if(isset($linhae['layertype_id']) && $linhae['layertype_id']==6){ ?>
							<input type="text" name="<?php echo $piece_element; ?>">
						<?php } ?>
						<a href='piece_element.php?acao=excluir&activity=<?php echo $activity; ?>&piece_element=<?php echo $piece_element; ?>&piece_id=<?php echo $piece_id; ?>&semanticname=<?php echo $semanticname; ?>&goaldescription=<?php echo $goaldescription; ?>&pieceseq=<?php echo $pieceseq; ?>&activitytype_id=<?php echo $activitytype_id; ?>'>Del - </a>
						<?php
						echo "<a href='#' onClick=\"javascript:window.open('element.php?grouping=".$linhae['grouping']."&layertype_id=".$linhae['layertype_id']."&layername=".$linhae['layername']."&word=".$linhae['element_id']."&piece_id=".$piece_id."&acao=editar&piece_element=".$piece_element."&seq=".$seq."&element_id=".$linhae['element_id']."&element_type=".$linhae['elementtype_id']."&activitytype_id=".$activitytype_id."&divwidth=".$divwidth."&divheight=".$divheight."&divtop=".$divtop."&divleft=".$divleft."','', 'fullscreen=3,statusbar=no,menubar=no,resizable=no,scrollbars=no,titlebar=no,toolbar=no,left=160,top=400,width=800,height=300')\">Upd</a>";
						?></h></div>
						<?php
					}else{ 
			
						$SQLi = "SELECT w.id, w.name 
								 FROM word w 
										LEFT JOIN word_word ww on (ww.word1=w.word) or (ww.word2=w.word)
								WHERE (((ww.word1=".$linhae['element_id'].") or (ww.word2=".$linhae['element_id'].")) and
										  w.idiom_id=".$idiom.")";
	 
						$resi = pg_query($SQLi);
						$linhai = pg_fetch_array($resi);
						?><div class="div<?php echo $i; ?>"><h<?php echo $j; ?>><?php echo $linhai['id'].$linhai['name']; ?>
						<a href='piece_element.php?acao=excluir&activity=<?php echo $activity; ?>&piece_element=<?php echo $piece_element; ?>&piece_id=<?php echo $piece_id; ?>&semanticname=<?php echo $semanticname; ?>&goaldescription=<?php echo $goaldescription; ?>&pieceseq=<?php echo $pieceseq; ?>&activitytype_id=<?php echo $activitytype_id; ?>'>Del - </a>
						<?php
						echo "<a href='#' onClick=\"javascript:window.open('element.php?grouping=".$linhae['grouping']."&layertype_id=".$linhae['layertype_id']."&layername=".$linhae['layername']."&word=".$linhae['element_id']."&piece_id=".$piece_id."&acao=editar&piece_element=".$piece_element."&seq=".$seq."&element_id=".$linhae['element_id']."&element_type=".$linhae['elementtype_id']."&activitytype_id=".$activitytype_id."&divwidth=".$divwidth."&divheight=".$divheight."&divtop=".$divtop."&divleft=".$divleft."','', 'fullscreen=3,statusbar=no,menubar=no,resizable=no,scrollbars=no,titlebar=no,toolbar=no,left=210,top=480,width=860,height=300')\">Upd</a>";
						?></h></div><?php
					}
				}
				//elemento compound
				if($linhae['elementtype_id']=="8"){
				
					$SQL8 = "SELECT * FROM compound where id = ".$linhae['element_id']."";
					$res8 = pg_query($SQL8);
					$linha8 = pg_fetch_array($res8);
					if($linha8[2]==$idiom){ 
						?><div class="div<?php echo $i; ?>"><h<?php echo $j; ?>><?php echo $linha8[1]; ?>
						<a href='piece_element.php?acao=excluir&activity=<?php echo $activity; ?>&piece_element=<?php echo $piece_element; ?>&piece_id=<?php echo $piece_id; ?>&semanticname=<?php echo $semanticname; ?>&goaldescription=<?php echo $goaldescription; ?>&pieceseq=<?php echo $pieceseq; ?>&activitytype_id=<?php echo $activitytype_id; ?>'>Del - </a>
						<?php
						echo "<a href='#' onClick=\"javascript:window.open('element.php?grouping=".$linhae['grouping']."&layertype_id=".$linhae['layertype_id']."&layername=".$linhae['layername']."&compound=".$linhae['element_id']."&piece_id=".$piece_id."&acao=editar&piece_element=".$piece_element."&seq=".$seq."&element_id=".$linhae['element_id']."&element_type=".$linhae['elementtype_id']."&activitytype_id=".$activitytype_id."&divwidth=".$divwidth."&divheight=".$divheight."&divtop=".$divtop."&divleft=".$divleft."','', 'fullscreen=3,statusbar=no,menubar=no,resizable=no,scrollbars=no,titlebar=no,toolbar=no,left=210,top=480,width=860,height=300')\">Upd</a>";
						?></h></div><?php
					}else{ 
			
						$SQLi = "SELECT w.compound, name 
								 FROM compound w 
										LEFT JOIN compound_compound ww on (ww.compound1=w.compound) or (ww.compound2=w.compound)
								WHERE (((ww.compound1=".$linhae[3].") or (ww.compound2=".$linhae[3].")) and
										  ((w.idiom1_id=".$idiom.") OR (w.idiom2_id=".$idiom."))";
	 
						$resi = pg_query($SQLi);
						$linhai = pg_fetch_array($resi);
						?><div class="div<?php echo $i; ?>"><h<?php echo $j; ?>><?php echo $linhai[1]; ?>
						<a href='piece_element.php?acao=excluir&activity=<?php echo $activity; ?>&piece_element=<?php echo $piece_element; ?>&piece_id=<?php echo $piece_id; ?>&semanticname=<?php echo $semanticname; ?>&goaldescription=<?php echo $goaldescription; ?>&pieceseq=<?php echo $pieceseq; ?>&activitytype_id=<?php echo $activitytype_id; ?>'>Del - </a>
						<?php
						echo "<a href='#' onClick=\"javascript:window.open('element.php?grouping=".$linhae['grouping']."&layertype_id=".$linhae['layertype_id']."&layername=".$linhae['layername']."&compound=".$linhae['element_id']."&piece_id=".$piece_id."&acao=editar&piece_element=".$piece_element."&seq=".$seq."&element_id=".$linhae['element_id']."&element_type=".$linhae['elementtype_id']."&activitytype_id=".$activitytype_id."&divwidth=".$divwidth."&divheight=".$divheight."&divtop=".$divtop."&divleft=".$divleft."','', 'fullscreen=3,statusbar=no,menubar=no,resizable=no,scrollbars=no,titlebar=no,toolbar=no,left=210,top=480,width=860,height=300')\">Upd</a>";
						?></h></div><?php
					}
				}
				// elemento phrase
				if($linhae['elementtype_id']=="9"){
				
					$SQL9 = "SELECT * FROM phrase where id = ".$linhae['element_id']."";
					$res9 = pg_query($SQL9);
					$linha9 = pg_fetch_array($res9);
					
					if($linha9['idiom_id']==$idiom){
	 
					?><div class="div<?php echo $i; ?>"><h<?php echo $j; ?>><?php echo $linha9['name']; ?>
						<a href='piece_element.php?acao=excluir&activity=<?php echo $activity; ?>&piece_element=<?php echo $piece_element; ?>&piece_id=<?php echo $piece_id; ?>&semanticname=<?php echo $semanticname; ?>&goaldescription=<?php echo $goaldescription; ?>&pieceseq=<?php echo $pieceseq; ?>&activitytype_id=<?php echo $activitytype_id; ?>'>Del - </a>
						<?php
						echo "<a href='#' onClick=\"javascript:window.open('element.php?grouping=".$linhae['grouping']."&layertype_id=".$linhae['layertype_id']."&layername=".$linhae['layername']."&phrase=".$linhae['element_id']."&piece_id=".$piece_id."&acao=editar&piece_element=".$piece_element."&seq=".$seq."&element_id=".$linhae['element_id']."&element_type=".$linhae['elementtype_id']."&activitytype_id=".$activitytype_id."&divwidth=".$divwidth."&divheight=".$divheight."&divtop=".$divtop."&divleft=".$divleft."','', 'fullscreen=3,statusbar=no,menubar=no,resizable=no,scrollbars=no,titlebar=no,toolbar=no,left=210,top=480,width=860,height=300')\">Upd</a>";
						?></h></div><?php	

					}else{ 
			
						$SQLi = "SELECT p.phrase, name 
								 FROM phrase p 
										LEFT JOIN phrase_phrase pp on (pp.phrase1=p.phrase) or (pp.phrase2=p.phrase)
								WHERE (((pp.phrase1=".$linhae[3].") or (pp.phrase2=".$linhae[3].")) and
										  p.idiom=".$idiom.")";
	
						$resi = pg_query($SQLi);
						$linhai = pg_fetch_array($resi);
						
						if($linhai[1]<>""){
							?><div class="div<?php echo $i; ?>"><h<?php echo $j; ?>><?php echo $linhai[1]; ?>
							<a href='piece_element.php?acao=excluir&activity=<?php echo $activity; ?>&piece_element=<?php echo $piece_element; ?>&piece_id=<?php echo $piece_id; ?>&semanticname=<?php echo $semanticname; ?>&goaldescription=<?php echo $goaldescription; ?>&pieceseq=<?php echo $pieceseq; ?>&activitytype_id=<?php echo $activitytype_id; ?>'>Del - </a>
							<?php
							echo "<a href='#' onClick=\"javascript:window.open('element.php?grouping=".$linhae['grouping']."&layertype_id=".$linhae['layertype_id']."&layername=".$linhae['layername']."&phrase=".$linhae['element_id']."&piece_id=".$piece_id."&acao=editar&piece_element=".$piece_element."&seq=".$seq."&element_id=".$linhae['element_id']."&element_type=".$linhae['elementtype_id']."&activitytype_id=".$activitytype_id."&divwidth=".$divwidth."&divheight=".$divheight."&divtop=".$divtop."&divleft=".$divleft."','', 'fullscreen=3,statusbar=no,menubar=no,resizable=no,scrollbars=no,titlebar=no,toolbar=no,left=210,top=480,width=860,height=300')\">Upd</a>";
						?>
							</h></div><?php
						}else{
							?><div class="div<?php echo $i; ?>"><h<?php echo $j; ?>><?php echo $linha9[1]; ?>
							<a href='piece_element.php?acao=excluir&activity=<?php echo $activity; ?>&piece_element=<?php echo $piece_element; ?>&piece_id=<?php echo $piece_id; ?>&semanticname=<?php echo $semanticname; ?>&goaldescription=<?php echo $goaldescription; ?>&pieceseq=<?php echo $pieceseq; ?>&activitytype_id=<?php echo $activitytype_id; ?>'>Del - </a>
							<?php
							echo "<a href='#' onClick=\"javascript:window.open('element.php?grouping=".$linhae['grouping']."&layertype_id=".$linhae['layertype_id']."&layername=".$linhae['layername']."&phrase=".$linhae['element_id']."&piece_id=".$piece_id."&acao=editar&piece_element=".$piece_element."&seq=".$seq."&element_id=".$linhae['element_id']."&element_type=".$linhae['elementtype_id']."&activitytype_id=".$activitytype_id."&divwidth=".$divwidth."&divheight=".$divheight."&divtop=".$divtop."&divleft=".$divleft."','', 'fullscreen=3,statusbar=no,menubar=no,resizable=no,scrollbars=no,titlebar=no,toolbar=no,left=210,top=480,width=860,height=300')\">Upd</a>";
							?>
							</h></div><?php
						}
					}
				}
				// elemento paragraph
				if($linhae['elementtype_id']=="10"){
	
					$SQL10 = "SELECT * FROM paragraph where id = ".$linhae['element_id']."";
					$res10 = pg_query($SQL10);
					$linha10 = pg_fetch_array($res10);
	
					if($linha10['idiom_id']==$idiom){ 
						?>
						<div class="div<?php echo $i; ?>">
						<h<?php echo $j; ?> align="justify">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp
						<?php 
							echo nl2br ($linha10['name']);
						?>
						<a href='piece_element.php?acao=excluir&activity=<?php echo $activity; ?>&piece_element=<?php echo $piece_element; ?>&piece_id=<?php echo $piece_id; ?>&semanticname=<?php echo $semanticname; ?>&goaldescription=<?php echo $goaldescription; ?>&pieceseq=<?php echo $pieceseq; ?>&activitytype_id=<?php echo $activitytype_id; ?>'>Del - </a>
						<?php
						echo "<a href='#' onClick=\"javascript:window.open('element.php?grouping=".$linhae['grouping']."&layertype_id=".$linhae['layertype_id']."&layername=".$linhae['layername']."&paragraph=".$linhae['element_id']."&piece_id=".$piece_id."&acao=editar&piece_element=".$piece_element."&seq=".$seq."&element_id=".$linhae['element_id']."&element_type=".$linhae['elementtype_id']."&activitytype_id=".$activitytype_id."&divwidth=".$divwidth."&divheight=".$divheight."&divtop=".$divtop."&divleft=".$divleft."','', 'fullscreen=3,statusbar=no,menubar=no,resizable=no,scrollbars=no,titlebar=no,toolbar=no,left=155,top=470,width=800,height=300')\">Upd</a>";
						echo "</h></div>";
					}else{ 
			
						$SQLi = "SELECT p.id, name 
								 FROM paragraph p 
										LEFT JOIN paragraph_paragraph pp on (pp.paragraph1=p.id) or (pp.paragraph2=p.id)
								 WHERE (((pp.paragraph1=".$linhae['element_id'].") or (pp.paragraph2=".$linhae['element_id'].")) and
										  p.idiom_id=".$idiom.")";
	
						$resi = pg_query($SQLi);
						if(pg_num_rows($resi)>0){
							$linhai = pg_fetch_array($resi);
							?><div class="div<?php echo $i; ?>"><h<?php echo $j; ?>><?php echo $linhai['name'] ?>
							<a href='piece_element.php?acao=excluir&activity=<?php echo $activity; ?>&piece_element=<?php echo $piece_element; ?>&piece_id=<?php echo $piece_id; ?>&semanticname=<?php echo $semanticname; ?>&goaldescription=<?php echo $goaldescription; ?>&pieceseq=<?php echo $pieceseq; ?>&activitytype_id=<?php echo $activitytype_id; ?>'>Del - </a>
							<?php
							echo "<a href='#' onClick=\"javascript:window.open('element.php?grouping=".$linhae['grouping']."&layertype_id=".$linhae['layertype_id']."&layername=".$linhae['layername']."&paragraph=".$linhae['element_id']."&piece_id=".$piece_id."&acao=editar&piece_element=".$piece_element."&seq=".$seq."&element_id=".$linhae['element_id']."&element_type=".$linhae['elementtype_id']."&activitytype_id=".$activitytype_id."&divwidth=".$divwidth."&divheight=".$divheight."&divtop=".$divtop."&divleft=".$divleft."','', 'fullscreen=3,statusbar=no,menubar=no,resizable=no,scrollbars=no,titlebar=no,toolbar=no,left=210,top=480,width=860,height=300')\">Upd</a>";
							?></h></div><?php
						}else{
							?><div class="div<?php echo $i; ?>">
							  <h <?php echo $j; ?>>
							  <?php echo $linha10['name']; ?> 
							  - Não há tradução para a sua língua - 
							  <a href='piece_element.php?acao=excluir&activity=<?php echo $activity; ?>&piece_element=<?php echo $piece_element; ?>&piece_id=<?php echo $piece_id; ?>&semanticname=<?php echo $semanticname; ?>&goaldescription=<?php echo $goaldescription; ?>&pieceseq=<?php echo $pieceseq; ?>&activitytype_id=<?php echo $activitytype_id; ?>'>Del - </a>
							  <?php
							  echo "<a href='#' onClick=\"javascript:window.open('element.php?grouping=".$linhae['grouping']."&layertype_id=".$linhae['layertype_id']."&layername=".$linhae['layername']."&paragraph=".$linhae['element_id']."&piece_id=".$piece_id."&acao=editar&piece_element=".$piece_element."&seq=".$seq."&element_id=".$linhae['element_id']."&element_type=".$linhae['elementtype_id']."&activitytype_id=".$activitytype_id."&divwidth=".$divwidth."&divheight=".$divheight."&divtop=".$divtop."&divleft=".$divleft."','', 'fullscreen=3,statusbar=no,menubar=no,resizable=no,scrollbars=no,titlebar=no,toolbar=no,left=210,top=480,width=860,height=300')\">Upd</a>";
							  ?></h></div><?php
						}
					}
				}//if linha==9
			
			}//while($linhae = pg_fetch_array($rese)){
			
			if(isset($activitytype_id) && $activitytype_id==7){
				echo '<div id="Layer3" style="position:absolute; left:750px; top:500px; width:150px; height:75px; z-index:1">';
				echo "<input type='submit' name='OK'>";
				echo "</div>";
			}
			
		}elseif(($father==true)){
			$SQL = "SELECT * FROM piece WHERE father_id = ".$piece." ORDER BY seq";
			$res = pg_query($SQL);
			$l = pg_fetch_array($res);
			echo "<script> window.location='piece_element.php?semantic=".$semantic."&semanticname=".$semanticname."&activity=".$activity."&activityname=".$activityname."&activitydescription=".$activitydescription."&activitytype_id=".$activitytype_id."&goaldescription=".$goaldescription."&pieceseq=".$l['seq']."&piece_id=".$l['id']."&piecename=".$l['name_varchar']."&piecedescription=".$l['description']."&blockname=".$blockname."'; </script>";
		}
	}//if(isset($piece)){
?>
</form>
</div>

<?php
}else{ //if(isset($activity) && $activity!=""){ 
?>

<link href="synapse.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
function filtra(cod) {
  document.forms["activityform"].filtragem.value = cod;
}
//-->
</script>
</head>
<body>

<?php
    ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
    include("includes/topo.php");
    ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
?>	  

<div id='col1'>
<?php
	ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
    include("includes/menu.php");//?idiom=".$idiom."
    ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
?> 
</div>

<div id='coltripla'>
  <h1><?php echo $h1; ?></h1>
<?php 
	echo "<h2>".$h2.(isset($personagename)?$personagename:"").$personname."</h2>";
 	echo "<h3>".(isset($organizationname)?$organizationname:"").(isset($unityname)?" - ".$unityname:"")."</h3>";
	echo "<hr>";
	
	if(!isset($semantic)){
		
		echo "<h2>Escolha o Tema</h2>";
		
		//$SQLs = "SELECT * FROM activity_sel(".$idiom.")";
		//$query = pg_prepare($SQLs);
		//$res = pg_execute($query);

		
		$SQLs = "SELECT DISTINCT
							   ws.id,
							   ws.name_varchar
				 FROM semantic ws
						LEFT JOIN activity a ON a.semantic_id = ws.id
				 WHERE a.semantic_id is not null";
		
		
		$ress = pg_query($SQLs);
		
		while($linhas = pg_fetch_array($ress)){
			$semanticname = $linhas[1];
			echo "<h3><a href='piece_element.php?semantic=".$linhas[0]."&semanticname=".$semanticname."'>".$linhas[1]."</a></h3>";
		}
	}	
		
	if(isset($semantic) && $semantic!=""){
		
		echo "<h2 align='center'>".$semanticname."</h2>";
									
		$SQLad = "SELECT DISTINCT db.id, g.degreegrade_id, db.degreestage_id, db.name, ds.grade, db.grade, dg.grade
				  FROM activity a
						LEFT JOIN goal g ON g.id = a.goal_id
						LEFT JOIN degreegrade dg ON dg.id = g.degreegrade_id
						LEFT JOIN degreeblock db ON db.id = dg.degreeblock_id
						LEFT JOIN degreestage ds ON ds.id = db.degreestage_id
				  WHERE a.semantic_id = ".$semantic."
				  ORDER BY ds.grade, db.grade, dg.grade";

		$resad = pg_query($SQLad);
	
		while($linhaad = pg_fetch_array($resad)){
																					
			echo "<h3>Estágio: ".$linhaad['degreestage_id']." - Bloco: ".$linhaad['name']."</h3>";

			$SQLa = "SELECT a.* 
					 FROM activity a
							LEFT JOIN goal g ON g.id = a.goal_id 
					WHERE g.degreegrade_id = ".$linhaad['degreegrade_id']." AND ";
//			if($linhaad['1']!=""){
//				$SQLa .= "";
//			}else{
//				$SQLa .= "WHERE g.degreestage_id = ".$linhaad['1']." AND ";
//			}
			$SQLa .=  "a.semantic_id = ".$semantic." 
					 ORDER BY seq";

			$resa = pg_query($SQLa);

			while($linhaa = pg_fetch_array($resa)){
				
				$SQLs = "SELECT *
						 FROM semantic
						 WHERE id = ".$linhaa['semantic_id']."";

				$ress = pg_query($SQLs);
				$linhas = pg_fetch_array($ress);

				if($linhas['name_type']=='WORD'){
					$SQLsn = "SELECT name, idiom_id FROM word WHERE id=".$linhas['name']."";//idiom_sel(".$word_name = $linhas[1].", ".$idiom.")
				}elseif($linhas['name_type']=='COMPOUND'){
					$SQLsn = "SELECT name FROM compound WHERE id=".$linhas['name']."";//word_compound_idiom_sel(".$word_compound_name = $linhas[1].", ".$idiom.")
				}elseif($linhas['name_type']=='PHRASE'){
					$SQLsn = "SELECT name, idiom_id FROM phrase WHERE id=".$linhas['name']."";//(".$phrase_name = $linhas[1].", ".$idiom.")
				}

				$ressn = pg_query($SQLsn);
				$linhasn = pg_fetch_array($ressn);
				
				$SQLg = "SELECT g.*, dg.grade
						 FROM goal g
						 		LEFT JOIN degreegrade dg ON dg.id = g.degreegrade_id
						 WHERE g.id = ".$linhaa['goal_id']."";
				$resg = pg_query($SQLg);
				$linhag = pg_fetch_array($resg);
			
				?><p><a href="#" onClick="MM_openBrWindow('piece_element.php?semantic=<?php echo $semantic; ?>&semanticname=<?php echo $semanticname; ?>&activity=<?php echo $linhaa['id']; ?>&activitytype_id=<?php echo $activitytype_id; ?>&goaldescription=<?php echo $linhag['description']; ?>', 'activity',  'fullscreen=yes, channelmode=yes')"><?php echo $linhag['grade']." - ".$linhag['description']; ?></a></p><?php
	
			}//while($linha = pg_fetch_array($res)){
		}//while($linhaad = pg_fetch_array($resad)){
	}//if(isset($semantic) && $semantic!=""){

?>
</div>
<div id="base"><?php echo $base.date('Y');?> ::</div>
<?php } ?>
</body>
</html>