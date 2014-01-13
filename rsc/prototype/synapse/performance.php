<?php
	session_start();
   	
       ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
       include("includes/conecta.php");
       ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

if(!(session_is_registered('person'))){
	echo "erro";
	header('Location: ' . "http://" . $_SERVER["SERVER_NAME"]."/synapse/index.php");	
}
/*	
	$filename = 'registros/performance' . time() . '.sql';
  	if(!file_exists($filename)){
		if (!$handle = fopen($filename, 'w')) {
	  		echo "Arquivo não aberto ($fn)";
	  		exit;
	  	}else{
	  		echo "<h1>Arquivo criado em" . dirname($PHP_SELF) . "/" . $filename . "</h1>";
	  	}
	}

	if (fwrite($handle, $resum) === FALSE){
		echo "Erro ao gravar($filename)";
	}

    fclose($handle);
*/

if(isset($idiom) && $idiom=="7"){
$h1="Performance";
$h2="Bem Vindo:";
}

if(isset($idiom) && $idiom=="16"){
$h1="Performance";
$h2="Welcome:";
}

?>

<script language="javascript"><!--
var form = "";
var submitted = false;
var error = false;
var error_message = "";

function check_ckbx_personage(form_name) {
	var total_ckbx_personage = 0;
	var max = form.ckbx_personage.length;
	for (var idx = 0; idx < max; idx++) {
		if (eval("form.ckbx_personage[" + idx + "].checked") == true) {
			total_ckbx_personage += 1;
		}
	}
	alert("You selected " + total_ckbx_personage + " boxes.");
	//document.getElementById('personage_sel').getElementsByTagName('personage');
}

function check_form(form_name) {
  		
		if (submitted == true) {
    		alert("Este formulário já foi enviado. Por favor pressione OK e aguarde o processo ser completado.");
    		return false;		
  		}
		
		error = false;
		form = form_name;
		error_message = "Erros ocorreram durante o envio de seu formulário.\n\nPor favor, faça as seguintes correções:\n\n";
		  		
		check_ckbx_personage("performance");
  		
		if (error == true) {
    		alert(error_message);
    		return false;
  		} else {
    		submitted = true;
    		return true;
  		}
}

//--></script>

<html>
<head>
<title><?php echo $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="synapse.css" rel="stylesheet" type="text/css">
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
	echo "<h2>".$h2." ".$personagename." ".$personname."</h2>";
 	echo "<h3>".$organizationname.($unityname!=""?" - ".$unityname:"")."</h3>";
	echo "<hr>";
	
	if(!isset ($unity_sel)){
		echo "<h3>Escolha uma unidade para gerar um relatório</h3>";
	}else{	
		echo "<h2>Relatório de performance dos atores da unidade: ".$unity_name."</h2>";		


if(isset($processar) && $processar == true){

//echo "<h3>".$ckbx_personage1."</h3>";
//echo "<h3>".$ckbx_personage2."</h3>";

echo "<h3>".$personage_total."</h3>";
$i=1;
for($i; $i<$personage_total; $i++){
$check_personage = $ckbx_personage.$i;
	if($check_personage!=""){
		echo "<h3>".$check_personage."</h3>";
	}
}
/*
$stmt="Select * from PERFORMANCE_UNITY_SEL('".$unity_sel.", ".$personage_sel."')";
$query = pg_prepare($stmt);
$rs=pg_execute($query);
while($row = pg_fetch_row($rs)){
	echo $row[15]."<br>";
}
*/
}else{
?>
		
<form name="performance" method="post" action="performance.php" onSubmit='return check_form(performance);'>
<table width="90%" height="374" border="0">  

<tr><td colspan="5"><input name="imgProcessar" id="btnProc" type="image" title=" Processar " src="images/processar.gif" alt="Processar" width="60" height="18" border="0"></tr>


<?php //---------------------------------------------------------------------------ACTIVITY ?>
   <tr><td colspan='5'><h2 align='center'>Activity</h2></td></tr>
		
	<tr><td><h3>Activities</h3></td> 
	<td>Row <input type='checkbox' name='r_activity' id='checkbox' /></td>
	<td>GroupBy <input type='checkbox' name='gr_activity' id='checkbox' /></td>
	<td>Colunm <input type='checkbox' name='c_activity' id='checkbox' /></td>
	<td>GroupBy <input type='checkbox' name='gc_activity' id='checkbox' /></td></tr>
	
	<tr><td><h3>Piece</h3></td> 
	<td>Row <input type='checkbox' name='r_piece' id='checkbox' /></td>
	<td>GroupBy <input type='checkbox' name='gr_piece' id='checkbox' /></td>
	<td>Colunm <input type='checkbox' name='c_piece' id='checkbox' /></td>
	<td>GroupBy <input type='checkbox' name='gc_piece' id='checkbox' /></td></tr>
	
	<tr><td><h3>Date</h3></td> 
	<td>Row <input type='checkbox' name='r_date' id='checkbox' /></td>
	<td>GroupBy <input type='checkbox' name='gr_date' id='checkbox' /></td>
	<td>Colunm <input type='checkbox' name='c_date' id='checkbox' /></td>
	<td>GroupBy <input type='checkbox' name='gc_date' id='checkbox' /></td></tr>


<tr><td colspan='5'><h2 align='center'>Actor</h2></td></tr>
	
<tr><td colspan='5'><h3>Personage</h3></td></tr>
<?php	
//---------------------------------------------------------------------------ACTOR
$stmt="Select * from PERSONAGE_SEL('".$unity_sel."')";
$query = pg_prepare($stmt);
$rs=pg_execute($query);
$i=0;
echo "<div id='personage_sel'>";
while($row = pg_fetch_row($rs)){
$i = $i+1;
	echo "<tr><td>".$row[2]."".$i."</td>"; //<?php echo $i; 
?>     
	<td>Row <input type='checkbox' name='ckbx_personage' value='<?php echo $row[1]; ?>' id='personage_row' /></td>
	<td>GroupBy <input type='checkbox' name='personage_grow' value='<?php echo $row[1]; ?>' id='personage_grow' /></td>
	<td>Colunm <input type='checkbox' name='ckbx_personage' value='<?php echo $row[1]; ?>' id='personage_column' /></td>
	<td>GroupBy <input type='checkbox' name='personage_gcolumn' value='<?php echo $row[1]; ?>' id='personage_gcolumn' /></td></tr>
    <input type="hidden" name="personage_total" value="<?php echo $i; ?>">
<?php
}	
echo "</div>";
?>
	<tr><td><h3>Sex</h3></td> 
	<td>Row <input type='checkbox' name='r_sex' id='checkbox' /></td>
	<td>GroupBy <input type='checkbox' name='gr_sex' id='checkbox' /></td>
	<td>Colunm <input type='checkbox' name='c_sex' id='checkbox' /></td>
	<td>GroupBy <input type='checkbox' name='gc_sex' id='checkbox' /></td></tr>
	
	<tr><td><h3>Birthday</h3></td> 
	<td>Row <input type='checkbox' name='r_birthday' id='checkbox' /></td>
	<td>GroupBy <input type='checkbox' name='gr_birthday' id='checkbox' /></td>
	<td>Colunm <input type='checkbox' name='c_birthday' id='checkbox' /></td>
	<td>GroupBy <input type='checkbox' name='gc_birthday' id='checkbox' /></td></tr>
	

<tr><td colspan='5'><h2 align='center'>Mark</h2></td></tr>
	
<tr><td colspan='5'><h3>Mark Type</h3></td></tr>
<?php	
//---------------------------------------------------------------------------MARK	
	$SQL = "select * from MARK_TYPE";
	$res = pg_query($SQL);
	while($linha = pg_fetch_row($res)){
		echo "<tr><td>".$linha[1]."</td>";
?>		 
		<td>Row <input type='checkbox' name='r_<?php echo $linha[1]; ?>' id='checkbox' /></td>
		<td>GroupBy <input type='checkbox' name='gr_<?php echo $linha[1]; ?>' id='checkbox' /></td>
		<td>Colunm <input type='checkbox' name='c_<?php echo $linha[1]; ?>' id='checkbox' /></td>
		<td>GroupBy <input type='checkbox' name='gc_<?php echo $linha[1]; ?>' id='checkbox' /></td></tr>
<?php	} ?>
	
	<tr><td><h3>Mark Time</h3></td> 
	<td>Row <input type='checkbox' name='r_time' id='checkbox' /></td>
	<td>GroupBy <input type='checkbox' name='gr_time' id='checkbox' /></td>
	<td>Colunm <input type='checkbox' name='c_time' id='checkbox' /></td>
	<td>GroupBy <input type='checkbox' name='gc_time' id='checkbox' /></td></tr>

	<tr><td><h3>Value Txt</h3></td> 
	<td>Row <input type='checkbox' name='r_valuetxt' id='checkbox' /></td>
	<td>GroupBy <input type='checkbox' name='gr_valuetxt' id='checkbox' /></td>
	<td>Colunm <input type='checkbox' name='c_valuetxt' id='checkbox' /></td>
	<td>GroupBy <input type='checkbox' name='gc_valuetxt' id='checkbox' /></td></tr>
	
	<tr><td><h3>Value Int</h3></td> 
	<td>Row <input type='checkbox' name='r_valueint' id='checkbox' /></td>
	<td>GroupBy <input type='checkbox' name='gr_valueint' id='checkbox' /></td>
	<td>Colunm <input type='checkbox' name='c_valueint' id='checkbox' /></td>
	<td>GroupBy <input type='checkbox' name='gc_valueint' id='checkbox' /></td></tr>
	
	<tr><td><h3>Value Num</h3></td> 
	<td>Row <input type='checkbox' name='r_valuenum' id='checkbox' /></td>
	<td>GroupBy <input type='checkbox' name='gr_valuenum' id='checkbox' /></td>
	<td>Colunm <input type='checkbox' name='c_valuenum' id='checkbox' /></td>
	<td>GroupBy <input type='checkbox' name='gc_valuenum' id='checkbox' /></td></tr>
	

<tr><td colspan='5'><h2 align='center'>GOAL</h2></td></tr>
<?php	
//---------------------------------------------------------------------------GOAL
$stmt="Select * from GOAL_SEL";
$query = pg_prepare($stmt);
$rs=pg_execute($query);
while($row = pg_fetch_row($rs)){
	echo "<tr><td><h3>".$row[6]."</h3></td>"; 
?>
	<td>Row <input type='checkbox' name='r_".$row[6]."' id='checkbox' /></td>
	<td>GroupBy <input type='checkbox' name='gr_".$row[6]."' id='checkbox' /></td>
	<td>Colunm <input type='checkbox' name='c_".$row[6]."' id='checkbox' /></td>
	<td>GroupBy <input type='checkbox' name='gc_".$row[6]."' id='checkbox' /></td></tr>
<?php } ?>

</td>
</table>
<input type="hidden" name="processar" value="true">
<input type="hidden" name="unity_sel" value="<?php echo $unity_sel; ?>">
<input type="hidden" name="unity_name" value="<?php echo $unity_name; ?>">
</form>

        
<?php }	} ?>
</div>
<div id="base"><?php echo $base.date('Y');?> ::</div>	
</body></html>