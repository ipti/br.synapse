<?php  
    session_start();
    
       ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
       require("includes/conecta.php");
       ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

if(!(session_is_registered('person'))){
	echo "erro";
	header('Location: ' . "http://" . $_SERVER["SERVER_NAME"]."/synapse/index.php");	
}
       
if($codQuest!=""){

		if((isset($UPDATE) && $UPDATE>0) || (isset($UPAREL) && $UPAREL>0)){
		
			if($UPAREL>0){ 
				$UPDATE = $UPAREL; 
			}
			
			$SQL = "SELECT * FROM INTERVIEW WHERE INTERVIEW='".$UPDATE."'";
			$res=pg_query($SQL);
			$l = pg_fetch_row($res);

			$ANCOD = $l[0];
			$ANDATA = $l[1];
			$codQuest=$l[4];
			session_register('ANCOD');
			session_register('ANDATA');
			$dt = $ANDATA;
			
			$SQLup = "UPDATE INTERVIEW 
					  SET INTERVIEW_DATE='".$txtAno."-".$txtMes."-".$txtDia."' 
					  WHERE INTERVIEW=".$ANCOD.";";
			$rup = pg_query($SQLup);
			
			$SQL = "SELECT A.ANSWER
					FROM ((ANSWER A 
						LEFT JOIN QUESTION Q ON Q.QUESTION = A.QUESTION) 
						LEFT JOIN SECTION S ON S.SECTION = Q.SECTION) 
						LEFT JOIN INTERVIEW I ON I.INTERVIEW = A.ANSWER
					WHERE I.INTERVIEW='".$UPDATE."' AND S.SEQ='".$secprox."';";

			$resp=pg_query($SQL);

			while($lresp = pg_fetch_row($resp)){
				$rescod = $lresp[0];
				$S = "DELETE from ANSWER WHERE ANSWER=".$rescod.";";
				$del=pg_query($S);
			}
			
		}else{
			$dt = date("Y-m-d");
			
			if((isset($Perg) && $Perg>0) && (!isset($ANCOD))){
			
				$SQL = "INSERT INTO INTERVIEW(INTERVIEW, INTERVIEW_DATE, SYSUSER, ACTOR, QUESTIONARY, QUEST_DATE) 
					    VALUES(NULL, '".$dt."',".$actor.",".$actor.",".$codQuest.",'".$txtAno."-".$txtMes."-".$txtDia."')";

				$res=pg_query($SQL);
				pg_query("COMMIT");
				pg_query("COMMIT");
				
				$SQL = "SELECT * FROM INTERVIEW WHERE INTERVIEW_DATE='" . $dt .  "' ORDER BY INTERVIEW DESC";
				$res=pg_query($SQL);
				$l = pg_fetch_row($res);
				
				$ANCOD = $l[0];
				$ANDATA = $l[1];
				list($alano, $almes, $aldia) = split("-",$l[5]);
				
				session_register('ANCOD');
				session_register('ANDATA');
				session_register('alano');
				session_register('almes');
				session_register('aldia');
				$dt="";
			}
		}

		foreach($Perg as $ocod => $o){
			//ksort($o);

	    	foreach($o as $cod => $l){
				//ksort($l);
		
				foreach($l as $grp => $v){

						if($ocod == "radio"){
							$stmt="Select * from ANSWER_SEL('".$v."', ".$idiom.", ".$cod.", ".$grp.")"; 
							$query = pg_prepare($stmt);
							$perg = pg_execute($query);
							$resr = pg_query($stmt);	
							$linhar = pg_fetch_row($resr);
							$opccod = $linhar[0];
					
							$grvgrp = $grp;
							if(strpos($v,"Perg[".$opccod."][".$cod."][".$grp."]")>0){ 
								$v=	substr($v,0,strpos($v,"Perg[".$opccod."][".$cod."][".$grp."]")); 
							}	
						}else{
							$grvgrp = $grp;
							if(strpos($v,"Perg[".$ocod."][".$cod."][".$grp."]")>0){ 
								$v=	substr($v,0,strpos($v,"Perg[".$ocod."][".$cod."][".$grp."]")); 
							}							
						}	

						$SQL1 = "SELECT * FROM ALTERNATIVE WHERE QUESTION=".$cod." AND GROUPING=".$grp;
						$res1 =pg_query($SQL1);
						$r = pg_fetch_row($res1);
						$op1 =$r[4];

						if($op1<>""){
							$tp = strtolower(after($op1,"|"));
							if($tp == "semana"){
								$v="";
								$v = (($Perg[$ocod][$cod][$grp] * 4) + $Perg[$ocod][$cod][($grp+1)]); 
								$grvgrp =$grvgrp + 1;
							}elseif ($tp == "mês"){
								$v = "";
								$v = (($Perg[$ocod][$cod][$grp] * 12) + $Perg[$ocod][$cod][($grp+1)]); 
								$grvgrp =$grvgrp + 1;
							}elseif ($tp == "gramas"){
								$v = "";
								$v = (($Perg[$ocod][$cod][$grp] * 1000) + $Perg[$ocod][$cod][($grp+1)]);
								$grvgrp =$grvgrp + 1;
							}
						}

						if($r[6] <> ""){
							if($ocod == "radio"){
								$grvgrp = str_replace("'","\"",$grvgrp);
								$SQL = "INSERT INTO ANSWER (ANSWER, INTERVIEW, ALTERNATIVE, QUESTION, GROUPING, NAME) 
									    VALUES (NULL, ".$ANCOD.", ".$opccod.", ".$cod.", ".$grvgrp.", '".$v."')";
								$res=pg_query($SQL);  
							}else{
								if($v!=""){
									$grvgrp = str_replace("'","\"",$grvgrp);
									$SQL = "INSERT INTO ANSWER (ANSWER, INTERVIEW, ALTERNATIVE, QUESTION, GROUPING, NAME) 
											VALUES (NULL, ".$ANCOD.", ".$ocod.", ".$cod.", ".$grvgrp.", '".$v."')";
									$res=pg_query($SQL);
								}
							}
							
						}
					}
				}
			
		if(isset($UPDATE) && $UPDATE>0){
			echo "<script> window.location='questionary.php?codQuestPai=".$codQuestPai."&codQuest=".$codQuest."&questpainome=".$questpainome."&questnome=".$questnome."&arel=".$ANCOD."'; </script>";
		}else{
			echo "<script> window.location='questionary.php?codQuestPai=".$codQuestPai."&codQuest=".$codQuest."&questpainome=".$questpainome."&questnome=".$questnome."'; </script>";
		}
	}
}
?>