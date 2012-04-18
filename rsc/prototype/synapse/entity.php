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

?>
	
<head>
<title><?php echo $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<?php if(isset($semantic_father) && $semantic_father!=""){ ?>

<link href="activity.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body scroll=no>

<div id="topo"><img src="images/logo_enscer.gif" alt="Visite o site do Enscer - Ensinando o C&eacute;rebro!" width="201" height="87" border="0"><img src="images/top_degrade.gif" width="85" height="87"></div>


<div id="fechar"><a href=javascript:window.close()><img src="images/botao_fechar.gif" border="0"></a></div>


<div id="menu"> 
<?php

	$SQLs = "SELECT * FROM word_semantic WHERE semantic_father = ".$semantic_father."";
	$ress = pg_query($SQLs);
//	echo "<h2>".$m_theme."</h2>";
	while($linhas = pg_fetch_row($ress)){
	
		$SQLw = "SELECT name, word_idiom FROM word WHERE word=".$linhas[4]."";
		$resw = pg_query($SQLw);
		$linhaw = pg_fetch_row($resw);
		echo "<h1>".$linhaw[0]."</h1>";
		
		$semantic = $linhas[0];
		
		$SQLa = "SELECT * FROM activity WHERE semantic = ".$semantic."";
		$resa = pg_query($SQLa);
			while($linhaa = pg_fetch_row($resa)){
				
				$SQLaw = "SELECT name, word_idiom FROM word WHERE word=".$linhaa[8]."";
				$resaw = pg_query($SQLaw);
				$linhaaw = pg_fetch_row($resaw);
				echo "<h3><a href='activity.php?semantic_father=".$semantic_father."&semantic_fathername=".$semantic_fathername."&semantic=".$linhas[0]."&semanticname=".$linhaw[0]."&activity=".$linhaa[0]."&activityname=".$linhaaw[0]."'>".$linhaaw[0]."</a></h3>";
		
			}

		$SQLc = "SELECT * FROM word_semantic WHERE semantic_father = ".$semantic."";
		$resc = pg_query($SQLc);
		$count = 0;
		while ($row[$count] = pg_fetch_assoc($resc)){
	    	$count++;
		}
				
		if(($count)>1){

			for ($i=0; ; $i++){
		
				if($semantic==""){
					break;
				}
				
				$SQLt = "SELECT * FROM word_semantic WHERE semantic_father = ".$semantic."";
				$rest = pg_query($SQLt);
				while($linhat = pg_fetch_row($rest)){
					
					$semantic = $linhat[0];
					
					$SQLw = "SELECT name, word_idiom FROM word WHERE word=".$linhat[4]."";
					$resw = pg_query($SQLw);
					$linhaw = pg_fetch_row($resw);
					echo "<h2>".$linhaw[0]."</h2>";
					
					$SQLa = "SELECT * FROM activity WHERE semantic = ".$semantic."";
					$resa = pg_query($SQLa);
					
					while($linhaa = pg_fetch_row($resa)){
					
						$SQLaw = "SELECT name, word_idiom FROM word WHERE word=".$linhaa[8]."";
						$resaw = pg_query($SQLaw);
						$linhaaw = pg_fetch_row($resaw);
						echo "<h3><a href='activity.php?semantic_father=".$semantic_father."&semantic_fathername=".$semantic_fathername."&semantic=".$linhas[0]."semanticname=".$linhaw[0]."&activity=".$linhaa[0]."&activityname=".$linhaaw[0]."'>".$linhaaw[0]."</a></h3>";
					
					}
				}
				$semantic="";
			}
		}
	}
	
	if(isset($activity) && $activity!=""){
		
		$SQLp = "SELECT * FROM piece WHERE activity = ".$activity."";
		$resp = pg_query($SQLp);
		echo "<h2>".$m_piece."</h2>";
		while($linhap = pg_fetch_row($resp)){
			
			$SQLw = "SELECT name, word_idiom FROM word WHERE word=".$linhap[10]."";
			$resw = pg_query($SQLw);
			$linhaw = pg_fetch_row($resw);
		
			if($linhaw[1]==$idiom){ 

				echo "<p><a href='activity.php?semantic_father=".$semantic_father."&semantic_fathername=".$semantic_fathername."&activity=".$activity."&activityname=".$activityname."&piece=".$linhap[0]."&piecename=".$linhaw[0]."'>".$linhaw[0]."</a></p>";


 			}else{ 
		
				$SQLi = "SELECT w.name 
						 FROM word w 
						 		LEFT JOIN word_word ww on (ww.word1=w.word) or (ww.word2=w.word)
						 WHERE (((ww.word1=".$linhap[10].") or (ww.word2=".$linhap[10].")) and
					 			  w.word_idiom=".$idiom.")";
 
				$resi = pg_query($SQLi);
				$linhai = pg_fetch_row($resi);
				echo "<p><a href='activity.php?group=".$group."&block=".$block."&blockname=".$blockname."&activity=".$activity."&activityname=".$activityname."&piece=".$linhap[0]."&piecename=".$linhai[0]."'>".$linhai[0]."</a></p>";
 		    }
		}
	}
?>
</div>

<div id="titulo">

<?php
  session_register('groupname');
  echo "<h1>".(isset($semantic_fathername)?$semantic_fathername:"")."</h1>";
  echo "<h2>".(isset($activityname)?$activityname:"").": ".(isset($piecename)?$piecename:"")."</h2>";
  echo "<h3></h3>";
?>

</div>

<div id="conteudo">

<?php

	if(isset($piece) && $piece!=""){

		$SQLe = "SELECT * FROM piece_element WHERE piece = ".$piece." ORDER BY seq";
		$rese = pg_query($SQLe);
		$i=1;

		while($linhae = pg_fetch_row($rese)){
		$i++;
		
		$SQLen = "SELECT * FROM entity_element WHERE element = ".$linhae[3].";";
		$resen = pg_query($SQLen);
		$count = 0;
		while ($row[$count] = pg_fetch_assoc($resen)){
		    $count++;
		}

		?>
        	<STYLE>
				.div<?php echo $i; ?>{ 
					position:absolute;
					width: <?php echo $linhae[12] ?> ;
					height: <?php echo $linhae[13] ?>;
					top: <?php echo $linhae[17] ?>;
					left: <?php echo $linhae[16] ?>;
				}
			</STYLE>
            

         <?php	//border: 1px solid #666666;

			// elemento imagem
			if($linhae[4]=="2"){
				
				$cod_data = $linhae[3];

				echo "<div class='div".$i."' onclick='MM_openBrWindow('untitled-2.html','teste','width=200,height=200')'>";
				
				echo '<iframe src="activity_image.php?data_cod='.$cod_data.'&count='.$count.'" name="'.$i.'" scrolling="no" marginwidth="0" marginheight="0" height="'.$linhae[13].'" width="'.$linhae[12].'" frameborder="0" allowtransparency="yes">';
				echo '</iframe>';		
				echo "</div>";
				
			}
			
			?> 
            
			<STYLE type="text">
			<?php $j=$i+3 ?>
				h<?php echo $j; ?>{
				font-name: <?php echo $linhae[28]?>;
				font-size: <?php echo $linhae[29]?>;
				font-color: <?php echo $linhae[30]?>;
				font-style: <?php echo $linhae[31]?>;
				}
			</STYLE>
			<?php
			
			// elemento paragrafo
			if($linhae[4]=="7"){
			
				$SQL7 = "SELECT * FROM word where word = ".$linhae[3]."";
				$res7 = pg_query($SQL7);
				$linha7 = pg_fetch_row($res7);
				if($linha7[8]==$idiom){ 

					?>
					<div class="div<?php echo $i; ?>"><h<?php echo $j; ?>><?php echo $linha7[1]; ?></h></div>
					<?php

 				}else{ 
		
					$SQLi = "SELECT w.word, name 
							 FROM word w 
							 		LEFT JOIN word_word ww on (ww.word1=w.word) or (ww.word2=w.word)
						 	WHERE (((ww.word1=".$linhae[2].") or (ww.word2=".$linhae[2].")) and
					 				  w.word_idiom=".$idiom.")";
 
					$resi = pg_query($SQLi);
					$linhai = pg_fetch_row($resi);
					?>
					<div class="div<?php echo $i; ?>"><h<?php echo $j; ?>><?php echo $linhai[1]; ?></h></div>
					<?php
 		    	}
			}
			
			if($linhae[4]=="8"){
			
				$SQL8 = "SELECT * FROM phrase where phrase = ".$linhae[3]."";
				$res8 = pg_query($SQL8);
				$linha8 = pg_fetch_row($res8);
				if($linha8[2]==$idiom){ 
                    
				echo "<div class='div".$i."'>";
                echo "<font size=".$linhae[29]." name=".$linhae[28]." color=".$linhae[30]." style=".$linhae[31].">";
                    
			    if ($count>0){	
					echo '<a href="entity.php?element='.$linhae[2].'" class="link" target=_blank>'; 
				}
					
				echo $linha8[1]; 

                if ($count>0){	
					echo '</a>'; 
				}

                echo "</font>";
                echo "</div>";

 				}else{ 
		
					$SQLi = "SELECT p.phrase, name 
							 FROM phrase p 
							 		LEFT JOIN phrase_phrase pp on (pp.phrase1=p.phrase) or (pp.phrase2=p.phrase)
						 	WHERE (((pp.phrase1=".$linhae[2].") or (pp.phrase2=".$linhae[2].")) and
					 				  p.word_idiom=".$idiom.")";
 
					$resi = pg_query($SQLi);
					$linhai = pg_fetch_row($resi);
					?>
					<div class="div<?php echo $i; ?>"><h<?php echo $j; ?>><?php echo $linhai[1]; ?></h></div>
					<?php
 		    	}
			}
			
			if($linhae[4]=="9"){

				$SQL9 = "SELECT * FROM paragraph where paragraph = ".$linhae[3]."";
				$res9 = pg_query($SQL9);
				$linha9 = pg_fetch_row($res9);
				if($linha9[3]==$idiom){ 

					?>
					<div class="div<?php echo $i; ?>"><h<?php echo $j; ?>><?php echo $linha9[2]; ?></h></div>
					<?php

 				}else{ 
		
					$SQLi = "SELECT p.paragraph, name 
							 FROM paragraph p 
							 		LEFT JOIN paragraph_paragraph pp on (pp.paragraph1=p.paragraph) or (pp.paragraph2=p.paragraph)
						 	WHERE (((pp.paragraph1=".$linhae[2].") or (pp.paragraph2=".$linhae[2].")) and
					 				  p.word_idiom=".$idiom.")";
 
					$resi = pg_query($SQLi);
					$linhai = pg_fetch_row($resi);
					?>
					<div class="div<?php echo $i; ?>"><h<?php echo $j; ?>><?php echo $linhai[1] ?></h></div>
					<?php
 		    	}
			}//if linha==9
		
		}//while

	}//if isset piece

?>
</div>

<?php	}else{ ?>

<link href="synapse.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
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
    include("http://".$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF'])."/includes/menu.php?idiom=".$idiom."");
    ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
?> 

</div>

<div id='coltripla'>

  <h1><?php echo $h1; ?></h1>
  
  
<?php 
/*
function after($str, $delim) {
	$strtmp = stristr($str,$delim);
	$strtmp = substr($strtmp,strlen($delim));
	return $strtmp;
}

function before($str, $delim) {
	$strtmp = strtolower($str);
	$delim = strtolower($delim);
	$pfim = strpos($strtmp,$delim);
	if($pfim > 0){
		return substr($str,0,strpos($strtmp,$delim));
	}else{
		return "";
	}
}

$SQL = "SELECT * FROM DEGREE order by grade";
$res = pg_query($SQL);
while($linha = pg_fetch_row($res)){
	$degree = $linha[0];
	$SQLf = "SELECT * FROM DEGREE WHERE DEGREE_FATHER = ".$degree." ";
	$resf = pg_query($SQLf);
	$count = 0;
	while ($row[$count] = pg_fetch_assoc($resf)){
	   	$count++;
	}

	if(($count)<1){
		$name = "";	
		$degree_father = $linha[2];
		$name = $linha[3].$linha[1];
		for($i=0; ; $i++){
		
			if($degree_father==""){
				break;
			}

			$SQLd = "SELECT * FROM DEGREE WHERE DEGREE = ".$degree_father."";
			$resd = pg_query($SQLd);
			$linhad = pg_fetch_row($resd);
			$degree_father = $linhad[2];
			$name .= " - ".$linhad[3].$linhad[1];			
		}
		
		$name1 = before($name, "-");
		$name2 = after($name, "-");
		$name3 = before($name2, "-");
		$name4 = after($name2, "-");
		$namef = $name4." - ".$name3." - ".$name1;
//		echo $namef."<br>";	
//		echo $name4."<br>";
//		echo $name3."<br>";
//		echo $name1."<br>";
//		echo $name."<br><br>";
	}	
}
*/
/*
$SQL = "SELECT * FROM DEGREE WHERE DEGREE_FATHER IS NULL";
$res = pg_query($SQL);
while($linha = pg_fetch_row($res)){

	$degree = $linha[0];
	$name = $linha[1];
	for($i=0; ; $i++){
		
		if($degree==""){
			break;
		}

		$SQLd = "SELECT * FROM DEGREE WHERE degree_father = ".$degree." order by grade";
		$resd = pg_query($SQLd);
		while($linhad = pg_fetch_row($resd)){
			$degree = $linhad[0];
				$name .= " - ".$linhad[1];
			$SQLa = "SELECT * FROM DEGREE WHERE DEGREE_FATHER = ".$degree." order by grade";
			$resa = pg_query($SQLa);
			while($linhaa = pg_fetch_row($resa)){
				$name .= " - ".$linhaa[1];	
				echo $name."<br>";
				//$name = ($name) - ($linhaa[1]);
				$name = "";
			}
			//$name="";
		}	
		$degree="";
	}	
}	
	
*/	

	echo "<h2>".$h2." ".$personagename." ".$personname."</h2>";
 	echo "<h3>".$organizationname.($unityname!=""?" - ".$unityname:"")."</h3>";
	echo "<hr>";
	
	$SQL = "SELECT s.word_semantic, s.name, s.semantic_father 
			FROM word_semantic s 
					LEFT JOIN activity a ON a.semantic = s.word_semantic
			WHERE a.semantic is not null";
	$res = pg_query($SQL);
	$semantic_fathera = 0;
	while($linha = pg_fetch_row($res)){
	
		$semantic_father = $linha[2];
		
			for ($i=1; ; $i++){
			 
				if($semantic_father==""){
					
					if(isset($linhas)){
					
						if($linhas[3]!=""){
						
							$SQLw = "SELECT name, word_idiom FROM word WHERE word=".$linhas[3]."";
							$resw = pg_query($SQLw);
							$linhaw = pg_fetch_row($resw);
			
							if($linhaw[1]==$idiom){ 
	?>
								<h3><a href="#" onClick="MM_openBrWindow('activity.php?semantic_father=<?php echo $linhas[0]; ?>&semantic_fathername=<?php echo $linhaw[0]; ?>','activity',  'fullscreen=yes, channelmode=yes')"><?php echo $linhaw[0]; ?></a></h3>
	 <?php 
							}else{ 
			
							$SQLi = "SELECT w.name 
									 FROM word w 
										LEFT JOIN word_word ww on (ww.word1=w.word) or (ww.word2=w.word)
									 WHERE (((ww.word1=".$linhas[3].") or (ww.word2=".$linhas[3].")) and
											  w.word_idiom=".$idiom.")";
	 
							$resi = pg_query($SQLi);
							$linhai = pg_fetch_row($resi);
	 ?>
							<h3><a href="#" onClick="MM_openBrWindow('activity.php?semantic_father=<?php echo $linhas[0]; ?>&semantic_fathername=<?php echo $linhai[0]; ?>', 'activity',  'fullscreen=yes, channelmode=yes')"><?php echo $linhai[0]; ?></a></h3>
	 <?php //toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,copyhistory=no,resizable=no
						  }
						  
					 }	
				}	
					break;					
			}

				$SQLs = "SELECT s.word_semantic, s.name, s.semantic_father, s.word 
						 FROM word_semantic s 
						 WHERE word_semantic=(".$semantic_father.")";
				$ress = pg_query($SQLs);
				$linhas = pg_fetch_row($ress);
				$semantic_father = $linhas[2];
					
		}
	}
?>
 
</div>
<div id="base">:: ENSCER - Ensinando o Cérebro :: <?php echo date(Y);?> ::</div>
<?php } ?>
</body>
</html>