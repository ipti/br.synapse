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
?>

<html>
<head>
<title><?php echo $title; ?></title>
<meta http-equiv="block-Type" block="text/html; charset=iso-8859-1">
<link href="synapse.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
<!--
var form = "";
var submitted = false;
var error = false;
var error_message = "";

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
function filtra(cod) {
  document.forms['block_ins'].filtragem.value = cod;
}
function filtrablock(cod) {
  document.forms['blockactivity'].filtragem.value = cod;
}
//-->
</script>
<?php

if(isset($filtragem) && $filtragem==1){

	if(isset($father_id) && $father_id==""){
		$father_id="null";
	}
	if(isset($discipline_id) && $discipline_id==""){
		$discipline_id="null";
	}
	if(isset($semantic_id) && $semantic_id==""){
		$semantic_id="null";
	}

	$blockcontent_id = "#";

	foreach($Perg as $n => $v){
		$blockcontent_id .= $n."#";
	}
	
	if((isset($upd) && $upd==true) && (isset($block_id) && $block_id!="")){
		$SQL = "UPDATE block 
				SET name_varchar='".$blockname_varchar."', 
				    blockcontent_id='".$blockcontent_id."'
				WHERE id = ".$block_id."";
		$res = pg_query($SQL);
		$SQL = "DELETE FROM block_content WHERE block_id = ".$block_id."";
		$res = pg_query($SQL);
	}else{
		$SQL = "INSERT INTO block (name_varchar, blockcontent_id, discipline_id, semantic_id) 
						VALUES ('".$blockname_varchar."', '".$blockcontent_id."', ".$discipline_id.", ".$semantic_id.")";
		$res = pg_query($SQL);
		$SQL = "SELECT id FROM block ORDER BY id DESC";
		$res = pg_query($SQL);
		$l = pg_fetch_array($res);
	}
	
	foreach($Perg as $n => $v){
		$SQL = "INSERT INTO block_content (block_id, blockcontent_id) 
				VALUES (".((isset($upd) && $upd==true) && (isset($block_id) && $block_id!="")?$block_id:$l['id']).", ".$n.")";
		$res = pg_query($SQL);
	}
}

if(isset($filtragem) && $filtragem==2){
	$SQL = "INSERT INTO block_activity (block_id, activity_id, seq) 
			VALUES (".$block_id.", ".$activity_id.", ".$seq.")";
	$res = pg_query($SQL);
}

if(isset($filtragem) && $filtragem==3){
	$SQL = "DELETE FROM block_activity WHERE activity_id = ".$activity_id."";
	$res = pg_query($SQL);
}

if(isset($filtragem) && $filtragem==4){
	$SQL = "DELETE FROM block_activity WHERE block_id = ".$block_id."";
	$res = pg_query($SQL);
	$SQL = "DELETE FROM block WHERE id = ".$block_id."";
	$res = pg_query($SQL);
}
?>
</head>
<body>
<?php
	ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
    include("includes/topo1.php");
    ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
?>

<div id="col1">
<?php

if(isset($discipline_id) && $discipline_id!=""){
	$SQL = "SELECT name FROM discipline WHERE id = ".$discipline_id."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$discname = $linha['name'];
}
if(isset($semantic_id) && $semantic_id!=""){
	$SQL = "SELECT name_varchar FROM semantic WHERE id = ".$semantic_id."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$semname = $linha['name_varchar'];
}

	ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
    include("includes/menu.php");//?idiom=".$idiom."
    ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
?>
</div>
<div id="col1234">

<?php
echo "<h1>Blocos</h1></hr>";
echo "<h2>Conteúdos<a href='block.php?acao=0&blockins=0'> - Novo</h2></a>";
if(isset($upd) && $upd==true){
	echo "<h3><font color='red'>Editando o Bloco: </font>".$name."</h3>";
}
if((isset($acao) && ($acao==0 || $acao==10)) && (isset($blockins) && $blockins==0)){
	include("blockcontent_ins.php");
}

if(isset($block_id) && $block_id!=""){
	$SQL = "SELECT blockcontent_id FROM block WHERE id = ".$block_id."";
	$res = pg_query($SQL);
	$l = pg_fetch_array($res);
	$blockcontent = $l['blockcontent_id'];
}

$SQL = "SELECT * FROM blockcontent WHERE father_id is null";
$res = pg_query($SQL);
$i = 0;

echo "<form name='block_ins' action='block.php'>";
echo "<table border='1' width='95%'><tr>";

while($l = pg_fetch_array($res)){
	$i ++;
	echo "<td valign='top'>";
	echo "<p><strong>".$l['name_varchar']."</strong>";
	echo " <a href='block.php?ia=".$i."&acao=1&blockins=0&blockcontentname=".$l['name_varchar']."&blockFather=".$l['id']."'>+</a></p>";
	if((isset($acao) && ($acao==1 || $acao==10)) && (isset($blockins) && $blockins==0) && (isset($ia) && $ia==$i)){
		include("blockcontent_ins.php");
	}	
	$SQL1 = "SELECT * FROM blockcontent WHERE father_id = ".$l['id']."";
	$res1 = pg_query($SQL1);
	$i1 = 0;
	
	while($l1 = pg_fetch_array($res1)){
		$i1 ++;
		$l1id = "#".$l1['id']."#";
		if((isset($blockcontent) && $blockcontent!="") && (strstr($blockcontent, $l1id))){
			echo "<input type='checkbox' name='Perg[".$l1['id']."]' value='Perg[".$l1['id']."]' checked='yes'>";
		}else{
			echo "<input type='checkbox' name='Perg[".$l1['id']."]' value='Perg[".$l1['id']."]'>";
		}
		echo "<a href='block.php?blockcontentname=".$l1['name_varchar']."&content_id=".$l1['id']."'>".$l1['name_varchar']."</a>";
		echo "<a href='block.php?ia=".$i."&ia1=".$i1."&acao=2&blockins=0&blockcontentname=".$l1['name_varchar']."&blockFather=".$l1['id']."'> +</a>";
		if((isset($acao) && ($acao==2 || $acao==10)) && (isset($blockins) && $blockins==0) && (isset($ia) && $ia==$i) && (isset($ia1) && $ia1==$i1)){
			include("blockcontent_ins.php");
		}
		$SQL2 = "SELECT * FROM blockcontent WHERE father_id = ".$l1['id']."";
		$res2 = pg_query($SQL2);
		echo "<ul>";
		$i2 = 0;
		
		while($l2 = pg_fetch_array($res2)){
			$i2 ++;
			$l2id = "#".$l2['id']."#";
			if( (isset($blockcontent) && $blockcontent!="") && (strstr($blockcontent, $l2id)) ){
				echo "<li><input type='checkbox' name='Perg[".$l2['id']."]' value='Perg[".$l2['id']."]' checked='yes'>";
			}else{
				echo "<li><input type='checkbox' name='Perg[".$l2['id']."]' value='Perg[".$l2['id']."]'>";
			}
			echo "<a href='block.php?blockcontentname=".$l2['name_varchar']."&content_id=".$l2['id']."'>".$l2['name_varchar']."</a>";
			echo " <a href='block.php?ia=".$i."&ia2=".$i2."&acao=3&blockins=0&blockcontentname=".$l2['name_varchar']."&blockFather=".$l2['id']."'>+</a></li>";
			if((isset($acao) && ($acao==3 || $acao==10)) && (isset($blockins) && $blockins==0) && (isset($ia) && $ia==$i) && (isset($ia2) && $ia2==$i2)){
				include("blockcontent_ins.php");
			}
			$SQL3 = "SELECT * FROM blockcontent WHERE father_id = ".$l2['id']."";
			$res3 = pg_query($SQL3);
			echo "<ul>";
			$i3 = 0;
			
			while($l3 = pg_fetch_array($res3)){
				$i3 ++;
				$l3id = "#".$l3['id']."#";
				if( (isset($blockcontent) && $blockcontent!="") && (strstr($blockcontent, $l3id)) ){
					echo "<li><input type='checkbox' name='Perg[".$l3['id']."]' value='Perg[".$l3['id']."]' checked='yes'>";
				}else{
					echo "<li><input type='checkbox' name='Perg[".$l3['id']."]' value='Perg[".$l3['id']."]'>";
				}
				echo "<a href='block.php?blockcontentname=".$l3['name_varchar']."&content_id=".$l3['id']."'>".$l3['name_varchar']."</a>";
				echo " <a href='block.php?ia=".$i."&ia3=".$i3."&acao=4&blockins=0&blockcontentname=".$l3['name_varchar']."&blockFather=".$l3['id']."'>+</a></li>";
				if((isset($acao) && ($acao==4 || $acao==10)) && (isset($blockins) && $blockins==0) && (isset($ia) && $ia==$i) && (isset($ia3) && $ia3==$i3)){
					include("blockcontent_ins.php");
				}
				$SQL4 = "SELECT * FROM blockcontent WHERE father_id = ".$l3['id']."";
				$res4 = pg_query($SQL4);
				echo "<ul>";
				$i4 = 0;
				
				while($l4 = pg_fetch_array($res4)){
					$i4 ++;
					$l4id = "#".$l4['id']."#";
					if( (isset($blockcontent) && $blockcontent!="") && (strstr($blockcontent, $l4id)) ){
						echo "<li><input type='checkbox' name='Perg[".$l4['id']."]' value='Perg[".$l4['id']."]' checked='yes'>";
					}else{
						echo "<li><input type='checkbox' name='Perg[".$l4['id']."]' value='Perg[".$l4['id']."]'>";
					}
					echo "<a href='block.php?blockcontentname=".$l4['name_varchar']."&content_id=".$l4['id']."'>".$l4['name_varchar']."</a>";
					echo " <a href='block.php?ia=".$i."&ia4=".$i4."&acao=5&blockins=0&blockcontentname=".$l4['name_varchar']."&blockFather=".$l4['id']."'>+</a></li>";
					if((isset($acao) && ($acao==5 || $acao==10)) && (isset($blockins) && $blockins==0) && (isset($ia) && $ia==$i) && (isset($ia4) && $ia4==$i4)){
						include("blockcontent_ins.php");
					}
				}
				echo "</ul>";
			}
			echo "</ul>";
		}
		echo "</ul>";
	}
	echo "</td>";
}
echo "<tr><td colspan='".$i."' align='right'>";
echo "Name: <input type='text' name='blockname_varchar' size='30' value='".$blockname_varchar."'>";

echo "Disc: <select name='discipline_id'>";
$SQLdb = "SELECT *
		FROM discipline";
$resdb = pg_query($SQLdb);
if(isset($discipline_id) && $discipline_id!=""){
	echo "<option value='".$discipline_id."'>".$discname."</option>";
}
echo "<option value=''></option>";
while($linhadb = pg_fetch_array($resdb)){
	echo "<option value='".$linhadb['id']."'>".$linhadb['name']."</option>";
}
echo "</select>";

echo "Sem: <select name='semantic_id'>";
$SQLdb = "SELECT *
		FROM semantic
		ORDER BY name_varchar";
$resdb = pg_query($SQLdb);
if(isset($semantic_id) && $semantic_id!=""){
	echo "<option value='".$semantic_id."'>".$semname."</option>";
}
echo "<option value=''></option>";
while($linhadb = pg_fetch_array($resdb)){
	echo "<option value='".$linhadb['id']."'>".$linhadb['name_varchar']."</option>";
}
echo "</select>";

echo "<input type='hidden' name='filtragem' value=''>";
if(isset($upd) && $upd==true){
	echo "<input type='hidden' name='upd' value='true'>";
	echo "<input type='hidden' name='block_id' value='".$block_id."'>";
	echo "<input type='submit' value='Upd' onClick=filtra(1)>";
}else{
	echo "<input type='submit' value='Ins' onClick=filtra(1)>";
}
echo "<input type='submit' value='Sel' onClick=filtra(5)>";
echo "</td></tr>";
echo "</tr></table>";
echo "</form>";
echo "<hr>";
if((isset($filtragem) && $filtragem==5) || (isset($content_id) && $content_id!="")){
	$SQL = "SELECT * FROM block WHERE ";	
	$i = 0;
	if(isset($Perg) && $Perg!=""){
		foreach($Perg as $n => $v){
			$i ++;
			if($i==1){
				$SQL .= "blockcontent_id LIKE '%#".$n."#%' ";
			}
			if($i>1){
				$SQL .= "AND blockcontent_id LIKE '%#".$n."#%' ";
			}
		}
	}
	if(isset($discipline_id) && $discipline_id!=""){
		if($i>0){
			$SQL .= " AND ";	
		}
		$i ++;
		$SQL .= "discipline_id = ".$discipline_id."";
	}
	if(isset($semantic_id) && $semantic_id!=""){
		if($i>0){
			$SQL .= " AND ";	
		}
		$i ++;
		$SQL .= "semantic_id = ".$semantic_id."";
	}
	if(isset($blockname_varchar) && $blockname_varchar!=""){
		if($i>0){
			$SQL .= " AND ";	
		}
		$i ++;
		$SQL .= "lower(name_varchar) LIKE '%".strtolower($blockname_varchar)."%'";
	}
	if(isset($content_id) && $content_id!=""){
		if($i>0){
			$SQL .= " AND ";	
		}
		$SQL .= " blockcontent_id LIKE '%#".$content_id."#%'";
	}
	$res = pg_query($SQL);

	while($l = pg_fetch_array($res)){
		$SQLn = "SELECT bbc.id, bc.name_varchar
				 FROM block_content bbc
						LEFT JOIN blockcontent bc ON bc.id = bbc.blockcontent_id
				 WHERE bbc.block_id = ".$l['id']."
				 ORDER BY bbc.id";
		$resn = pg_query($SQLn);
		$name = "";
		while($ln = pg_fetch_array($resn)){
			$name .= "| ".$ln['name_varchar']." | ";
		}
		$ig++;
		echo "<h3><a href='block.php?block_id=".$l['id']."&name=".$name."&content_id=".$content_id."&blockname_varchar=".$l['name_varchar']."&discipline_id=".$l['discipline_id']."&semantic_id=".$l['semantic_id']."'>".$name."</a>";
		echo "<a href='block.php?block_id=".$l['id']."&upd=true&name=".$name."&content_id=".$content_id."&blockname_varchar=".$l['name_varchar']."&discipline_id=".$l['discipline_id']."&semantic_id=".$l['semantic_id']."'> - Editar</a>";
		echo " - <a href='block.php?newactivity=true&igo=".$ig."&block_id=".$l['id']."&name=".$name."&content_id=".$content_id."&blockname_varchar=".$l['name_varchar']."&discipline_id=".$l['discipline_id']."&semantic_id=".$l['semantic_id']."&newactivity=true'>Inserir</a></h3>";

		if((isset($newactivity) && $newactivity==true) && ($igo==$ig)){
			echo '<form name="blockactivity" action="block.php" method="post">';
			echo "<p>Ativ: ";
			echo '<select name="activity_id">';
			echo '<option value=""></option>';
				
			$SQLa = "SELECT a.*
					FROM activity a 
					WHERE a.goal_id is null";
						
			if((isset($discipline_id) && $discipline_id!="")){ 
				$SQLa = "SELECT a.*, g.name_varchar
						FROM activity a 
							 LEFT JOIN goal g ON g.id = a.goal_id
						WHERE g.discipline_id = ".$discipline_id."";
			}
			if(isset($goal_id) && $goal_id!=""){ 
				$SQLa = "SELECT a.*, g.name_varchar
						FROM activity a 
							 LEFT JOIN goal g ON g.id = a.goal_id
						WHERE a.goal_id = ".$goal_id."";
			}
			if((isset($discipline_id) && $discipline_id!="") && (isset($semantic_id) && $semantic_id!="")){ 
				$SQLa = "SELECT a.*, g.name_varchar
						FROM activity a 
							 LEFT JOIN goal g ON g.id = a.goal_id							 
						WHERE g.discipline_id = ".$discipline_id." AND
							  a.semantic_id = ".$semantic_id."";
			}
			if((isset($semantic_id) && $semantic_id!="") && (isset($goal_id) && $goal_id!="")){ 
				$SQLa = "SELECT a.*, g.name_varchar
						FROM activity a 
							 LEFT JOIN goal g ON g.id = a.goal_id							 
						WHERE a.semantic_id = ".$semantic_id." AND
							  a.goal_id = ".$goal_id."";
			}
			$resa = pg_query($SQLa);
			echo "<option value='".(isset($activity_id)?$activity_id:"")."'>".(isset($activityname)?$activityname:"")."</option>";
			echo "<option value=''></option>";
			while($linhaa = pg_fetch_array($resa)){
				echo "<option value='".$linhaa['id']."'>".$linhaa['name_varchar']."</option>";
			}
			echo "</select>";
			echo " | Pai: <select name='father_id'>";
			echo '<option value=""></option>';
			$SQLf = "SELECT ba.*, g.name_varchar
					FROM block_activity ba
							LEFT JOIN activity a ON a.id = ba.activity_id
							LEFT JOIN goal g ON g.id = a.goal_id
					WHERE block_id = ".$block_id."";
			$resf = pg_query($SQLf);
			if(pg_num_rows($res)>0){
				while($lf=pg_fetch_array($resf)){
					echo "<option value'".$lf['id']."'>".$lf['name_varchar']."</option>";
				}
			}
			echo "</select>";
			echo ' | Seq*: <input type="text" name="seq" size="2">';
			if(isset($block_id) && $block_id!=""){
				echo "<input type='hidden' name='block_id'' value='".$block_id."'>";
				echo "<input type='hidden' name='name'' value='".$name."'>";
			}
			echo "<input type='hidden' name='block_id'' value='".$l['id']."'>";
			echo "<input type='hidden' name='name'' value='".$name."'>";
			echo "<input type='hidden' name='content_id'' value='".$content_id."'>";
			echo "<input type='hidden' name='blockname_varchar'' value='".$l['name_varchar']."'>";
			echo "<input type='hidden' name='discipline_id'' value='".$l['discipline_id']."'>";
			echo "<input type='hidden' name='semantic_id'' value='".$l['semantic_id']."'>";
			echo "<input type='hidden' name='newactivity'' value='true'>";
			echo "<input type='hidden' name='igo'' value='".$ig."'>";
			echo "<input type='hidden' name='block_father'' value='".$block_father."'>";
			echo "<input type='hidden' name='filtragem' value=''>";
			echo "<input type='submit' onClick='filtrablock(2)'>";
			echo "<a href='#' onclick=\"javascript:window.open('activity_ins.php?acao=1', '', 'width=600, height=300')\">+</a></p>";
				
			echo "<p>Disc: <select name='discipline_id' onChange=document.blockactivity.submit()>";
			$SQLfu = "SELECT * FROM discipline";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($discipline_id)?$discipline_id:"")."'>".(isset($discname)?$discname:"")."</option>";
			echo "<option value=''></option>";
			while($linhafu = pg_fetch_array($resfu)){
				echo "<option value='".$linhafu['id']."'>".$linhafu['name']."</option>";
			}
			echo "</select>";
			echo " | Sem: ";
			echo "<select name='semantic_id' onChange=document.blockactivity.submit()>";
			$SQLfu = "SELECT * FROM semantic ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($semantic_id)?$semantic_id:"")."'>".(isset($semname)?$semname:"")."</option>";
			echo "<option value=''></option>";
			while($linhafu = pg_fetch_array($resfu)){
				echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
			}
			echo "</select></p>";
			echo "<p>Obj: ";
			echo "<select name='goal_id' onChange=document.blockactivity.submit()>";
			if(isset($discipline_id) && $discipline_id!=""){
				$SQLfu = "SELECT * FROM goal WHERE discipline_id = ".$discipline_id."";
				$resfu = pg_query($SQLfu);
				echo "<option value='".(isset($goal_id)?$goal_id:"")."'>".(isset($goalname)?$goalname:"")."</option>";
				echo "<option value=''></option>";
				while($linhafu = pg_fetch_array($resfu)){
					echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
				}
			}
			echo "</select></p>";
			echo "</form>";
		}
	
		if(isset($block_id) && $block_id==$l['id']){
			$SQLa = "SELECT a.*, (ba.id) as blockactivity_id, ba.seq, s.name_varchar as semname, (at.name) as typename
					FROM block_activity ba
							LEFT JOIN activity a ON a.id = ba.activity_id
							LEFT JOIN block b ON b.id = ba.block_id
							LEFT JOIN semantic s ON s.id = a.semantic_id
							LEFT JOIN activitytype at ON at.id = a.activitytype_id
					WHERE b.id = ".$block_id;
			$resa = pg_query($SQLa);
			if(pg_num_rows($resa)>0){
				while($linhat=pg_fetch_array($resa)){
					if($linhat['goal_id']!=""){
						$SQLg = "SELECT description FROM goal WHERE id = ".$linhat['goal_id']."";
						$resg = pg_query($SQLg);
						$lg = pg_fetch_array($resg);
					}
					echo "<p><a href='#'";
					echo "onClick=\"MM_openBrWindow('activity.php?";
					echo "semantic_id=".$linhat['semantic_id']."&";
					echo "semanticname=".$semname."&";
					echo "discipline_id=".$linhat['discipline_id']."&";
					echo "discname=".$discname."&";
					echo "activityname=".$linhat['name_varchar']."&";
					echo "activitydescription=".$linhat['description']."&";
					echo "activity_id=".$linhat['id']."&";
					echo "activitytype_id=".$linhat['activitytype_id']."&";
					echo "goaldescription=".$lg['description']."&";
					echo "block_content=".$name."&";
					echo "blockname_varchar=".$l['name_varchar'];
					echo "', 'activity',  'address=no, toolbar=no, menubar=no, status=no, location=no, width=1010, height=710')\">";
					if($linhat['goal_id']!=""){
						echo $linhat['seq']." - ".$lg['description'];
					}else{
						echo $linhat['seq']." - ".$linhat['name_varchar']; ?> - <?php echo $linhat['description']; 
					}
					echo "</a>";
					echo "<a href='#' onClick=\"javascript:window.open('activity_ins.php?blockactivity_id=".$l['blockactivity_id']."&activity_id=".$l['id']."&";
					echo "activityname=".$l['name_varchar']."&activitydescription=".$l['description']."&activitytype_id=".$l['activitytype_id']."&";
					echo "typename=".$l['typename']."&seq=".$l['seq']."&acao=1&editar=true','','width=600,height=300')\"> - Editar</a>";
					echo "</p>";
				}
			}else{
				echo "<p><font color='red'>Não há atividades inseridas nesse bloco</font></p>";
			}
		}//if(isset($block_id)){
	}//while($l = pg_fetch_array($res)){
}//if(isset($filtragem) && $filtragem==5){
?>
</div>
<div id="base1"><?php echo $base.date('Y');?> ::</div>
</body>
</html>