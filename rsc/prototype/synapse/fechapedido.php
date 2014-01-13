<?php 

ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
require("includes/conecta.php");
ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);         
	  
ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
require("includes/funcoes.php");
ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
      
session_start();

if(isset($person)){
	//mostra todos os produtos na cesta
	//permite alterar a qunatidade e excluir o produto
	//vai para a página de confirmação
	setlocale(LC_MONETARY, 'pt_BR');
	
	if((sizeof($_SESSION["produtos"]))>0){ 
		$pedido=true;
		session_register('pedido');
	?> 

		<head>
		<link href="<?php echo 'http://' . $_SERVER['SERVER_NAME']; ?>/enscercss.css" rel="stylesheet" type="text/css">
		</head>
		
		<body>
		<?php 
			 ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
			 include("http://" . $_SERVER["SERVER_NAME"] . "/includes/topo.php");
			 ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
		?>
		
		<div id="col1">
		<?
		if(!isset($ADMIN)){
			ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
		    include("includes/menu.php");
		    ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
				
			ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
			include("http://" . $_SERVER["SERVER_NAME"] . "/includes/menu_vendas.php");
			ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
			
		}else{
			ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
			include("http://" . $_SERVER["SERVER_NAME"] . "/includes/menu_admin.php");
			ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
		}
		?>
		</div>
		
		<div id="coltripla"> 
		  <h1>Fechar Pedido<a name="topo"></a></h1>
		  <h3>Para concluir seu pedido, confira <a href="fechapedido.php#dados" class="link">Seus 
			Dados</a>, <a href="fechapedido.php#compras" class="link">Suas Compras</a>, 
			selecione a <a href="fechapedido.php#compras" class="link">Forma de Pagamento</a> 
			e Clique em <a href="fechapedido.php#compras" class="link">Confirmar</a>!</h3>
		  <h3><font color="#FF0000">ATEN&Ccedil;&Atilde;O:</font> Nosso softwares n&atilde;o 
			funcionam com o Windows Vista.</h3>
		  <hr>
		  <table width="560" border="0" cellspacing="0" cellpadding="0">
			<tr> 
			  <td><h2>Suas Compras:<a name="compras"></a></h2></td>
			  <td><h2>Forma de Pagamento:</h2></td>
			</tr>
			<tr> 
			  <td width="371"><form name=fechaPedido action=<? echo "http://".$_SERVER['SERVER_NAME'].$PHP_SELF ?> method="post">
				  <?
					 $total = 0;
					 $inseridet = true;
					 $atualizar = true;
					 
					 if (!(isset($horas))){
					
						 $horas = date("Y-m-d H:i:s");
						 session_register("horas");

						 $SQL = "INSERT INTO activity_order (person_id, paymentoption, orderdate, paymentslip, paymentdate, duedate, dispatchdate, amount, canceled, open)";
						 $SQL .= "VALUES (".$_SESSION['person'].", NULL, '".$horas."', NULL, NULL, NULL, NULL,". $total .", NULL, '1')";
						 pg_query($SQL);

						 $inseridet = true;
						 $atualizar = false;
					
					 }else if(isset($horas) && isset($atualizar) && $atualizar == true){
						   $inseridet = false;
						   $atualizar = true;
					 }
					 
					 $SQL = "SELECT * 
							 FROM activity_order 
							 WHERE (orderdate >= '" . $horas . "') and 
								   (person_id=" . $_SESSION['person'] . ") 
							 ORDER BY orderdate DESC";
					 $res = pg_query($SQL);

					 $linha = pg_fetch_array($res);
					 $codPed = $linha['id'];
					 $totalPed = $linha['amount'];
					 $temPed = false;

					 $SQL = "SELECT * 
							 FROM order_detail 
							 WHERE order_detail.activity_order=".$codPed."";
					 $res = pg_query($SQL);
					 $linha = pg_fetch_array($res);
					 $temPed = true;
					 
					 if (isset($maisprods)){
						for ($i=1;$i<=(sizeof($maisprods));$i++){
							if($maisprods[$i] > 0){
								$tem=false;
								for ($j=1;$j<=(sizeof($_SESSION["produtos"]));$j++){
									if($codprods[$i]==$_SESSION["produtos"][$j]['id']){
										$tem = true;
										break 1;
									}
								}
								if(!$tem){
									$SQL = "SELECT * FROM activity WHERE id = ". $codprods[$i];
									$res = pg_query($SQL);
									$linha = pg_fetch_array($res);
									$SQL = "SELECT * FROM order_detail WHERE order_detail.activity = " . $codprods[$i] . " and order_detail.activity_order=". $codPed;
									$res1 = pg_query($SQL);
									
									if(pg_num_rows($res1)==0){
										$_SESSION['produtos'][(sizeof($produtos)+1)] = $linha;
										$_SESSION['produtos'][(sizeof($produtos))][13] = $maisprods[$i];
										$SQL = "INSERT INTO order_detail (activity_order, activity, quantity) VALUES (".$codPed.", ". $linha['id'] .", ". $maisprods[$i].")";
										pg_query($SQL);
										pg_query("COMMIT");
										//echo "Inserido";
									}//else echo "Não Inserido";
								}
							}
						 }
					 }
					 $temProd = false;
					 for ($i=1;$i<=(sizeof($_SESSION["produtos"]));$i++){
						 $temProd = 0;
						 if(isset($prods[$i]) && $atualizar == true){ // or
							 //echo "Atualizar".$i."-".$prods[$i];
							 //if($_SESSION['produtos'][$i][13] != $prods[$i]){
							   $_SESSION['produtos'][$i][13] = $prods[$i];
							   $SQL = "SELECT * FROM order_detail WHERE activity_order=" . $codPed . " and activity_id=" .  $_SESSION['produtos'][$i]['id'];
							   $res = pg_query($SQL);
							   $linha = pg_fetch_array($res);
							   $codDet = $linha['id'];
							   $atualizar = true;
							   $SQL = "UPDATE order_detail SET quantity=" . $prods[$i] . " WHERE id =" . $codDet."";
							   pg_query($SQL);
							   pg_query("COMMIT");
							   //UPDATE
							// }
						 }else if($temPed == true) {
							  $prods[$i] = $_SESSION['produtos'][$i][13];
							  $SQL = "SELECT * FROM order_detail WHERE activity_order=".$codPed." and activity_id=".$_SESSION['produtos'][$i]['id']."";
							  $res = pg_query($SQL);
							  $num = pg_num_rows($res);
							  $linha = pg_fetch_array($res);
							  $codDet = $linha[0];
							  //echo $_SESSION['produtos'][$i]['prCod'] . " - " . $codPed . " " . $num;
							  if($num>0){
								$temProd = 1;
							  }
							  if($temProd == 0 ){
								  $SQL = "INSERT INTO order_detail (activity_order, activity_id, quantity) VALUES (". $codPed .", ". $_SESSION['produtos'][$i]['id'] .", ". $_SESSION['produtos'][$i][13] .")";
								  pg_query($SQL);
								  pg_query("COMMIT");
							  }else{
								  $SQL = "UPDATE order_detail SET quantity=" .$prods[$i] . " WHERE id =" . $codDet;
								  pg_query($SQL);
								  pg_query("COMMIT");
							  }
						 }else if($inseridet == true){
								  $SQL = "INSERT INTO order_detail (activity_order, activity, quantity) VALUES (". $codPed .", ". $_SESSION['produtos'][$i]['id'] .", ". $_SESSION['produtos'][$i][13] .")";
								  pg_query($SQL);
								  pg_query("COMMIT");
						 }
						 echo '<input type="text" name="prods[' . $i . ']" size=1 value=' . $_SESSION['produtos'][$i][13] . "> x " . $_SESSION['produtos'][$i]['g_name'] . " = R$ " .  substr(money_format('%.2n', ($_SESSION['produtos'][$i]['value']*$_SESSION['produtos'][$i][13])),0,-3) . "<BR>";
						 $total = ($_SESSION['produtos'][$i][13] * $_SESSION['produtos'][$i]['value']) + $total;
					 }
					 for($i=sizeof($_SESSION['produtos'])+1;$i<=sizeof($prods);$i++){
						 if($prods[$i]>0){
							 echo "Inserido mais produtos no pedido";
						 }
					 }
					 $inseridet = false;
		
					 if($totalPed != $total){                 
						 $SQL = "UPDATE activity_order SET amount = ".$total." WHERE id = ".$codPed."";
						 pg_query($SQL);
						 pg_query("COMMIT");
					 }
					 if (!(session_is_registered("codPed"))){
						 session_register("codPed");
						 session_register("total");
					 }
					 ?>
				  <h3><input type="image" src="images/atualizar.gif" name="sub">
					Para ver outros produtos, <a href="fechapedido.php#mais" class="link">Clique 
					Aqui!</a> </h3>
				</form>
				
			  </td>
			  <td width="160" valign="top"><form action="http://<? echo $_SERVER['SERVER_NAME']?>/synapse/confirmapedido.php" method=post>
				   <p><input name="pagamento" type="radio" value="Boleto" checked>
				  Boleto 
				  <input type="radio" name="pagamento" value="Depósito">
				  Dep&oacute;sito</p>
				  <h2>____________________<br>
					Total R$ <? echo substr(money_format('%.2n', $total),0,-3); ?> </h2>
				  <p><input name="sub" type="image" src="images/confirmar.gif">
				</form></td>
			</tr>
		  </table>
		  <hr>
		  <table width="550" border="0" cellspacing="0" cellpadding="0">
			<tr> 
			  <td colspan="2"><h2>Seus Dados:<a name="dados"></a></h2></td>
			</tr>
			<tr> 
			  <td width="429"><h3>Nome: <?php echo $personname; ?> <br>
				  Endereço: <?php echo $addresstype." ".$address.", " .$number; ?>
				  <?php if(isset($complement) && $complement!=""){echo " - ".$complement;} ?> 
				  <br> CEP: <?php echo $postalcode; ?> - <?php echo $cityname; ?> - <?php echo $state; ?></h3></td>
			  <td width="121"><p><a href="person_ins.php"><img src="images/mudaend.gif" border="0" alt="Continuar" title=" Continuar "></a></p>
				<p><a href="fechapedido.php#topo"><img src="images/confirmar.gif" width="121" height="18" border="0"></a></p></td>
			</tr>
		  </table>
		  <hr>
		  <p><a name="mais"></a> 
			<? 
			ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
			include('maisprod.php');
			ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
				  
	}//if((sizeof($_SESSION["produtos"]))>0){ 
}else{//isset($person){
	$pedido = true;
	session_register('pedido');
	redireciona("http://". $_SERVER['SERVER_NAME'] ."/synapse/index.php");
}

?>
</p>
</div>
<div id="base">:: ENSCER - Ensinando o Cérebro :: <? echo date('Y');?> ::</div>
</body>