<?php
session_start();
//echo "degreestage: ".$degreestage."<br>";
//echo "degreeblock: ".$degreeblock."<br>";
//echo "degreegrade: ".$degreegrade."<br>";
$SQLc1 = " SELECT DISTINCT ac.id, ac.name_varchar ";
$SQLc1 .= " FROM activitycontent ac
					LEFT JOIN goal_content gc ON gc.activitycontent_id = ac.id 
					LEFT JOIN goal g ON g.id = gc.goal_id ";
$SQLc1 .=" WHERE ac.father_id is null AND 
			  ac.discipline_id = ".$discipline." ";

ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
include("goal/goal_contenthabilityi.php");
ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

$resc1 = pg_query($SQLc1);
//echo "SQLc1: ".$SQLc1;
echo "<hr>";
if(pg_num_rows($resc1)>0){
	while($linhai = pg_fetch_array($resc1)){
	
		$SQLc = "SELECT DISTINCT ac.id, ac.name_varchar, ac.grade
				FROM activitycontent ac
						LEFT JOIN goal_content gc ON gc.activitycontent_id = ac.id 
						LEFT JOIN goal g ON g.id = gc.goal_id 
						LEFT JOIN degreegrade dg ON dg.id = g.degreegrade_id
						LEFT JOIN degreeblock db ON db.id = dg.degreeblock_id
						LEFT JOIN degreestage ds ON ds.id = db.degreestage_id";
		$SQLc .=" WHERE ac.father_id = ".$linhai['id']." ";
	
		ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
		include("goal/goal_contenthabilityc.php");
		ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
	
		$SQLc .= " AND gc.activitycontent_id is not null";
	
		if(isset($degreegrade) && $degreegrade!=""){
			$SQLc .=  " AND dg.id=".$degreegrade;
		}
		if(isset($degreeblock) && $degreeblock!=""){
			$SQLc .=  " AND db.id=".$degreeblock;
		}
		if(isset($degreestage) && $degreestage!=""){
			$SQLc .=  " AND ds.id=".$degreestage;
		}
		
		$SQLc .= " ORDER BY ac.grade";
		$resc = pg_query($SQLc);
//echo "SQLc: ".$SQLc."<br>";
		if(pg_num_rows($resc)>0){
			echo "<h1>".$linhai['name_varchar']."</h1>";
			while($linhac = pg_fetch_array($resc)){
		
				echo "<h2>".$linhac['name_varchar']."</h2>";
				echo "<p><table width='100%' border='1' cellspacing='0'><tr><td><h3 align='center'>Objetivo</h3></td><td width='15'>Es</td><td width='15'>Bl</td><td width='15'>Gr</td></tr>";
		
				$SQL = "SELECT g.*, g.grade as goalgrade, 
								ds.name as stagename, ds.grade as stagegrade, ds.id as degreestage_id,
								db.name as blockname, db.grade as blockgrade, db.id as degreeblock_id,
								dg.name as gradename, dg.grade as gradegrade, dg.id as degreegrade_id
						FROM goal g 
							LEFT JOIN degreegrade dg ON dg.id = g.degreegrade_id
							LEFT JOIN degreeblock db ON db.id = dg.degreeblock_id
							LEFT JOIN degreestage ds ON ds.id = db.degreestage_id
						WHERE g.discipline_id=".$discipline." ";
			
				$SQL .=	  " AND content_id like '%#".$linhac['id']."#%'";
				
				ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
				include("goal/goal_contenthability.php");
				ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
		
			if(isset($degreegrade) && $degreegrade!=""){
				$SQL .=  " AND dg.id=".$degreegrade;
			}
			if(isset($degreestage) && $degreestage!=""){
				$SQL .=  " AND ds.id=".$degreestage;
			}
			if(isset($degreeblock) && $degreeblock!=""){
				$SQL .=  " AND db.id=".$degreeblock;
			}
				$SQL .= " ORDER BY ds.grade, db.grade, dg.name, g.name_varchar";
				$res = pg_query($SQL);//echo $SQL;
				
				while($linha = pg_fetch_array($res)){

					$description = $linha['description'];
					echo "<tr><td><h3>";
						echo "<a href='goal.php?goal_id=".$linha['id'];
						echo "&degreestage=".$linha['degreestage_id']."&degreeblock=".$linha['degreeblock_id']."&degreegrade=".$linha['degreegrade_id'];
						ini_set("allow_url_fopen",1); ini_set("allow_url_include",1); 
						include("goal/content_link.php"); 
						ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
						echo "'>";
							echo $linha['id']."-".$description;
						echo "</a>";
					echo "</h3></td>";

					echo "<td>".$linha['stagegrade']."</td>";
					echo "<td>".$linha['blockgrade']."</td>";
					echo "<td>";
						echo "<a href='#goal_anchor' onClick=\"javascript:window.open('edit_degree.php?goal_id=".$linha['id']."', 'editdegree', 'width=400; height=80;')\">";
							echo $linha['gradename'];
						echo "</a>";
					echo "</td></tr>";

				}//while($linha = pg_fetch_array($res)){
				echo "</table></p>";
			}//while($linha = pg_fetch_array($res)){
		}
	}//while($linhab = pg_fetch_array($resb)){
}
?>