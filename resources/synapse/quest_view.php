<?php
	session_start();
  	
      ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
      require("includes/conecta.php");
      ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

if(!(session_is_registered('person'))){
	echo "erro";
	header('Location: ' . "http://" . $_SERVER["SERVER_NAME"]."/synapse/index.php");	
}      
?>
<html>
<head>
<title>:: ENSCER - Ensinando o c&eacute;rebro :: Assessoria</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="synapse.css" rel="stylesheet" type="text/css">
</head>
<body>
 <div id="topoquest">
<br><img src="">
 <div id="tituloquest"><br>
  <h1>Portal Enscer</h1>
  <h1><?php echo $personname ?></h1>
</div>
</div>
<div id="questprint">
 <div align="center"><a href='javaScript:window.print()' class=link><img src='images/impressora.jpg' alt='Imprime a Página Atual' border="0"></a></div>
 <h3 align="center"><a href='javaScript:window.print()' class=link>Imprimir</a></h3>
 </div>
 <div id="questview">
 <hr>
<?php

	$ANCOD = $anCod;
	$QURESP = $quResp;
	if(isset($ANCOD) && $ANCOD>0){
		$SQL = "SELECT * FROM INTERVIEW WHERE INTERVIEW=".$ANCOD.";";
		$res= pg_query($SQL);
		$linha = pg_fetch_row($res);
		echo "<h3>Questionário realizado em: ".$linha[1]."</h3>";
		
		$QURESP = $linha[4];
		session_register('QURESP');

		$SQL = "SELECT DISTINCT ANSWER.*
				FROM ANSWER
				WHERE (((ANSWER.INTERVIEW)=".$ANCOD.") AND ((ANSWER.NAME)<>''))
				ORDER BY ANSWER.QUESTION;";

		$fanam = pg_query($SQL);
		while($l=pg_fetch_row($fanam)){
			$Resp[$l[3]][$l[4]]=$l[5];
		}
	}

	if(isset($QURESP) && $QURESP>0){

		$SQL = "SELECT QUESTIONARY.* 
				FROM QUESTIONARY 
				WHERE QUESTIONARY.QUESTIONARY=".$QURESP." 
				order by QUESTIONARY.SEQ";
				
		$quest=pg_query($SQL);
		//if(isset($ALCOD)){
			ksort($Resp);
			while($q=pg_fetch_row($quest)){
			
				$questcod = $q[0];
				
				$stmt="EXECUTE PROCEDURE QUESTIONARY_NAME_SEL(".$QURESP.", ".$idiom.")";				
				$query=pg_prepare($stmt);
				$res=pg_execute($query);				
				$qn=pg_fetch_row($res);
				
				$questnome=$qn[1];
				
				$SQL = "SELECT SECTION.* 
						FROM SECTION 
						WHERE SECTION.QUESTIONARY=" . $questcod . " 
						order by SECTION.SEQ";
				
				$sec=pg_query($SQL);
				
				$qun = "<h1><center>".$questnome."</center></h1>\n";
				$prime=0;
				$mostraqu=true;
				
				while($s=pg_fetch_row($sec)){
				
					$seccod = $s[0];
					
					$stmt="EXECUTE PROCEDURE SECTION_NAME_SEL(".$seccod.", ".$idiom.")";				
					$query=pg_prepare($stmt);
					$res=pg_execute($query);				
					$qn=pg_fetch_row($res);
				
					$secnome=$qn[1];				

					$SQL = "SELECT DISTINCT QUESTION.QUESTION, QUESTION.NAME, QUESTION.SECTION, QUESTION.SEQ 
							FROM (ANSWER 
									INNER JOIN QUESTION ON ANSWER.QUESTION = QUESTION.QUESTION)
									INNER JOIN ALTERNATIVE ON QUESTION.QUESTION = ALTERNATIVE.QUESTION
							WHERE (((ANSWER.INTERVIEW)=". $ANCOD .") AND 
								  ((QUESTION.SECTION)=" .$seccod. ") AND 
							      (((QUESTION.VIS_QUEST)=-1) or ((QUESTION.VIS_QUEST)=1))) 
							ORDER BY QUESTION.SEQ;";

					$perg=pg_query($SQL);
					
					if($prime==0){
						$prime=1;
					}else{
					}
															
					$sen= "<h2>".$secnome."</h2>\n";
					$mostrase=true;
					$pergatu = 0;
					while($p=pg_fetch_row($perg)){
						$pergcod = $p[0];

						$stmt="EXECUTE PROCEDURE QUESTION_NAME_SEL(".$pergcod.", ".$idiom.")";				
						$query=pg_prepare($stmt);
						$res=pg_execute($query);				
						$qn=pg_fetch_row($res);
					
						$pergnome=$qn[1];

						$SQL = "SELECT DISTINCT ALTERNATIVE.ALTERNATIVE, ALTERNATIVE.NAME, ALTERNATIVE.OBS, 
									  		    ALTERNATIVE.QUESTION, ALTERNATIVE.SEQ, ALTERNATIVE.KIND, 
												ALTERNATIVE.OPTION_FATHER, ALTERNATIVE.VALUE_INT, ALTERNATIVE.GROUPING
							FROM ANSWER 
								  INNER JOIN ALTERNATIVE ON ANSWER.QUESTION = ALTERNATIVE.QUESTION
							WHERE (((ANSWER.INTERVIEW)=".$ANCOD.") AND 
							      ((ALTERNATIVE.QUESTION)=".$pergcod.") AND 
								  (((ALTERNATIVE.VIS_QUEST)=1) OR ((ALTERNATIVE.VIS_QUEST)=-1)))
							ORDER BY ALTERNATIVE.SEQ;";

						$mostrape =true;
						$opc=pg_query($SQL);
						$pen= "<br><i><b><h3>".$p[3]."-".$pergnome."</b></i></h3>"."";
						$grp=-1;
						$pri=0;
						$pass = "";

						while($o=pg_fetch_row($opc)){

							$opccod = $o[0];
							
							$stmt="EXECUTE PROCEDURE ALTERNATIVE_NAME_SEL(".$opccod.", ".$idiom.")";				
							$query=pg_prepare($stmt);
							$res=pg_execute($query);				
							$qn=pg_fetch_row($res);
						
							$opcnome=$qn[1];
							
							$opcobs = $o[2];
							$opcsequencia = $o[4];
							$opctipo = $o[5];
							$opcpai = $o[6];
							$opcvalor = $o[7];
							$opcgrupo = $o[8];

							if($opctipo=="label"){
								$opn = "&nbsp&nbsp&nbsp&nbsp<b><i>".$opcnome."</i></b>";
								$mostraop=true;
							}

							if($opctipo=="text" && stristr($opcobs,"|")!=""){
								$opcgrupo = $opcgrupo + 1;
							}
//							if($Resp[$pergcod][$opcgrupo]!=""){

								if($mostraqu==true){
									$mostraqu = false;
									echo $qun;
								}
								if($mostrase){
									$mostrase = false;
									echo "<br><br>".$sen;
								}
								if($mostrape){
									$mostrape = false;
									echo "<br>".$pen;
								}
								if($mostraop){
									$mostraop = false;
									echo (($grp != -1)?"<br>":"").$opn;
								}

								if($opctipo=="radio" && $pass!=$Resp[$pergcod][$opcgrupo]){
									if($grp!=$opcgrupo || $grp==-1){
										echo "\n";
										echo("&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"  . ($Resp[$pergcod][$opcgrupo]) .($pergatu!=$pergcod?" ":""));
										$grp=$opcgrupo;
									}
								}else if($opctipo=="checkbox"){

									echo "\n";
									echo("&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"  . ($Resp[$pergcod][$opcgrupo]) . ($pergatu!=$pergcod?" ":""));
								}else if($opctipo=="text"){
									if($opcobs==""){

										echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<i><b>". $opcnome . "</b></i>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp".$Resp[$pergcod][$opcgrupo]. "";
									}else{
										$op1 = substr(stristr($opcobs,"|"), 1);
										$op2 = substr($opcobs,0,strpos($opcobs,"|"));

										if(strtolower($op1)=="mês"){
											echo "\n";
											echo("&nbsp&nbsp&nbsp&nbsp". $op2 . '&nbsp&nbsp&nbsp&nbsp<input type="' . $opctipo . '" name="Perg[' . $pergcod . '][' . ($opcgrupo - 1) . ']"' . ($perm?'readonly=true ':" ") . ($Resp[$pergcod][$opcgrupo]!=""?"value=".intval($Resp[$pergcod][$opcgrupo]/12):"") . ' size=5>');
											echo("&nbsp&nbsp&nbsp&nbsp". $op1 . '&nbsp&nbsp&nbsp&nbsp<input type="' . $opctipo . '" name="Perg[' . $pergcod . '][' . $opcgrupo . ']"' . ($perm?'readonly=true ':" ") . ($Resp[$pergcod][($opcgrupo)]!=""?"value=".(intval($Resp[$pergcod][$opcgrupo]%12)):"") . ' size=5><BR>');
										}elseif(strtoupper($op1)=="SEMANA"){
											echo "\n";
											echo("&nbsp&nbsp&nbsp&nbsp". $op2 . '&nbsp&nbsp&nbsp&nbsp<input type="' . $opctipo . '" name="Perg[' . $pergcod . '][' . ($opcgrupo - 1) . ']"' . ($perm?'readonly=true ':" ") . ($Resp[$pergcod][$opcgrupo]!=""?"value=".intval($Resp[$pergcod][$opcgrupo]/4):"") . ' size=5>');
											echo("&nbsp&nbsp&nbsp&nbsp". $op1 . '&nbsp&nbsp&nbsp&nbsp<input type="' . $opctipo . '" name="Perg[' . $pergcod . '][' . $opcgrupo . ']"' . ($perm?'readonly=true ':" ") . ($Resp[$pergcod][$opcgrupo]!=""?"value=".(intval($Resp[$pergcod][$opcgrupo]%4)):"") . ' size=5><BR>');
										}elseif(strtoupper($op1)=="GRAMAS"){
											echo "\n";
											echo("&nbsp&nbsp&nbsp&nbsp". $op2 . '&nbsp&nbsp&nbsp&nbsp<input type="' . $opctipo . '" name="Perg[' . $pergcod . '][' . ($opcgrupo - 1) . ']"' . ($perm?'readonly=true ':" ") . ($Resp[$pergcod][$opcgrupo]!=""?"value=".intval($Resp[$pergcod][$opcgrupo]/1000):"") . ' size=5>');
											echo("&nbsp&nbsp&nbsp&nbsp". $op1 . '&nbsp&nbsp&nbsp&nbsp<input type="' . $opctipo . '" name="Perg[' . $pergcod . '][' . $opcgrupo . ']"' . ($perm?'readonly=true ':" ") . ($Resp[$pergcod][$opcgrupo]!=""?"value=".(intval($Resp[$pergcod][$opcgrupo]%1000)):"") . ' size=5><BR>');
										}
									}
								}else if($opctipo=="textarea"){
									$txt =str_replace("\n", "<BR>", $Resp[$pergcod][$opcgrupo]);
									$txt =str_replace("\\r\\n", "<BR>", $txt);
									$j=0;
									$s=$txt;

									echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp" . $opcnome.'<br><h3><p align="justify">' . ($Resp[$pergcod][$opcgrupo]!=""?$s:"") . '</p></h3><br>';
								}

								if($pergatu!=$pergcod){
									$pergatu=$pergcod;
								}
							//}
						}
					}
				}
			}
		//}
	}
?>
 </div>
</body>
</html>
