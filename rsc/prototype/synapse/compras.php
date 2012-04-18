<?php

session_start();

ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
require("includes/conecta.php");
ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
require("includes/funcoes.php");
ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

setlocale(LC_MONETARY, 'pt_br');

if(isset($limpa)){
	unset($codPed);
}

if($boleto==true){
	redireciona("http://".$_SERVER['SERVER_NAME']."/synapse/boleto.php");
}

if(isset($pedAtualiza) && $pedAtualiza==true){
	echo $txtDataPagto;				

	$txtDataPedido = $txtDataPedido!=""?"'" . date("Y-m-d H:i:s",cvdate($txtDataPedido)) . "'":"NULL";
	$txtDataVcto = $txtDataVcto!=""?"'" . date("Y-m-d H:i:s",cvdate($txtDataVcto)) . "'":"NULL";
	$txtDataEnvio = $txtDataEnvio!=""?"'" . date("Y-m-d H:i:s",cvdate($txtDataEnvio)) . "'":"NULL";
	$txtDataPagto = $txtDataPagto!=""?"'" . date("Y-m-d H:i:s",cvdate($txtDataPagto)) . "'":"NULL";
	$txtComentario = $txtComentario!=""?"'" . date("Y-m-d H:i:s",cvdate($txtComentario)) . "'":"NULL";

	$SQL = "UPDATE activity_order SET paymentoption= '" . $optPagamento . "', orderdate=" . $txtDataPedido . ", paymentslip='" . $txtBoleto . "', paymentdate=" . $txtDataPagto . ",";
	$SQL .= "duedate=" . $txtDataVcto . ", dispatchdate=" . $txtDataEnvio . ", amount='" . $txtTotal . "', canceled= '" . $chkCancelado . "', peaberto='" . $chkAberto . "' WHERE pecod=" . $codPed;
	$res=pg_query($SQL,$idcon) or die("ERRO AO ATUALIZAR: " . pg_error());
	pg_query("COMMIT");

	$pedAtualiza=false;
}

if(isset($codPed) && $codPed!=0){

	$SQL = "SELECT * FROM activity_order WHERE id=".$codPed."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$peCod = $linha['id'];
	session_register(peCod);
	$peFormaPgto = $linha['paymentoption'];
	$peDataPedido = $linha['orderdate']=="0000-00-00 00:00:00"?"":date("d/m/Y H:i:s",strtotime($linha['orderdate']));
	session_register(peDataPedido);
	$peNumBoleto = $linha['paymentslip'];
	$peDataPgto = $linha['paymentdate']==""?"":date("d/m/Y",strtotime($linha['paymentdate']));
	$peDataVcto = $linha['duedate']==""?"":date("d/m/Y",strtotime($linha['duedate']));
	session_register(peDataVcto);
	$peDataEnvio = $linha['dispatchdate']==""?"":date("d/m/Y",strtotime($linha['dispatchdate']));
	$peTotal = $linha['amount'];
	session_register(peTotal);
	$peCancelado = $linha['canceled'];
	$peAberto = $linha['open'];
?>

<html>
<head>
<title>:: ENSCER - Ensinando o c&eacute;rebro :: Minhas Compras</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="<?php echo "http://" . $_SERVER['SERVER_NAME']; ?>/enscercss.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php 
	ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
	include("http://" . $_SERVER['SERVER_NAME'] . "/includes/topo.php");
	ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
?>

<div id="col1"> 
<?php 
	ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
	include("includes/menu.php");
	ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
?>
</div>

<div id="coltripla">
<h1>Minhas Compras</h1>
<h2><?php echo "$usuario"; ?></h2>
<hr>

<form action="" method="post">

  <input type="hidden" name="pedAtualiza" value="true">

    <table width="560" border="0" cellpadding="2" cellspacing="0">

      <tr> 
        <td width="16%"><h2><strong>Data: </strong></h2></td>
        <td width="31%"><input name="txtDataPedido" type="text" size="25" <? if(isset($peDataPedido)) echo "value='" . $peDataPedido . "'" ; ?>> 
        </td>
        <td width="18%">&nbsp;</td>
        <td width="35%">&nbsp; </td>
      </tr>
      <tr> 
        <td colspan="4"><div align="center"> 
            <h2 align="left">Pagamento</h2>
          </div></td>
      </tr>
      <tr> 
        <td><strong>Pagamento: 
          <label></label>
          </strong></td>
        <td><input type="radio" name="optPagamento" value="Boleto" <? if(isset($peFormaPgto)&& $peFormaPgto=="Boleto") echo "checked" ;?>> 
          <label>Boleto 
          <input type="radio" name="optPagamento" value="Depósito" <? if(isset($peFormaPgto)&& $peFormaPgto=="Depósito") echo "checked"; ?>>
          Dep&oacute;sito </label></td>
        <td><strong>Boleto Envio:</strong></td>
        <td><input name="txtDataEnvio" type="text" size="25" <? if(isset($peDataEnvio)) echo " value='" . $peDataEnvio . "'"; ?>></td>
      </tr>
      <tr> 
        <td><strong>Boleto No. </strong></td>
        <td><input name="txtBoleto" type="text" size="25" <? if(isset($peFormaPgto) && $peFormaPgto=="Boleto"){ echo " value='" . $peNumBoleto . "'"; }else{ echo " value='Depósito'";} ?>></td>
        <td><strong>Pagamento: </strong></td>
        <td><input name="txtDataPagto" type="text" size="25" <? if(isset($peDataPgto)) echo " value='" . $peDataPgto . "'"; ?>> 
        </td>
      </tr>
      <tr> 
        <td><strong>Vencimento: </strong></td>
        <td><input name="txtDataVcto" type="text" size="25" <? if(isset($peDataVcto)) echo " value='" . $peDataVcto . "'"; ?>> 
        </td>
        <td><strong>Pedido Envio: </strong></td>
        <td><input name="txtComentario" type="text" size="25" <? if(isset($peComentario)) echo " value='" . $peComentario . "'"; ?>></td>
      </tr>
      <tr> 
        <td><strong>Valor Total: </strong></td>
        <td><input name="txtTotal" type="text" size="25" align="right" <? if(isset($peTotal)) echo " value=" . number_format($peTotal, 2, ',', '.'); ?>></td>
        <td><strong>Situa&ccedil;&atilde;o:</strong></td>
        <td><input name="chkCancelado" type="checkbox" value="1" <? if(isset($peCancelado)&&$peCancelado==true) echo "checked"; ?> >
          Cancelado 
          <input name="chkAberto" type="checkbox" value="1" <? if(isset($peAberto)&&$peAberto==true) echo "checked"; ?> >
          Confirmado</td>
      </tr>
      <tr> 
        <td colspan="4"><h2>Pedido </h2></td>
      </tr>
    </table>
    <table width="560" border="1" cellpadding="2">
      <tr> 
        <td width="4%"><div align="center"><strong>C&oacute;d</strong></div></td>
        <td width="66%"><div align="center"><strong>Produto</strong></div></td>
        <td width="10%"><div align="center"><strong>Qtde</strong></div></td>
        <td width="10%"><div align="center"><strong>Valor Unit&aacute;rio</strong></div></td>
        <td width="10%"><div align="center"><strong>Total</strong></div></td>
      </tr>
      <?

		$SQL = "SELECT * FROM order_detail WHERE activity_order=".$codPed;
		$res = pg_query($SQL);
		$tq=0;
		$tt=0;

	    while($linha = pg_fetch_array($res)){
  		    $SQL = "SELECT activity.id, activity.value, (goal.name_varchar) as g_name 
					FROM activity 
						LEFT JOIN goal ON goal.id=activity.goal_id
					WHERE activity.id=".$linha['activity_id'];
			$res2 = pg_query($SQL);
			$linha2 = pg_fetch_array($res2);
			$tt = ($linha['quantity'] * $linha2['value']) + $tt;
			$tq = $linha['quantity'] + $tq;
			echo '<tr><td><div align="center">' . $linha['activity'] . '</div></td><td>' . $linha2['g_name'] . '</td><td><div align="center">'. $linha['quantity'] . '</div></td><td><div align="right">'. number_format($linha2['value'], 2, ',', '.') . '</div></td><td><div align="right">' . number_format($linha[3] * $linha2['value'], 2, ',', '.').  '</div></td></tr>';
		}

		$tt = number_format($tt, 2, ',', '.');
		$peTotal = $tt;
		$txtTotal = $tt;
?>
      <tr> 
        <td colspan="2"><div align="right"><strong>Total&nbsp;</strong>&nbsp;</div></td>
        <td> <div align="center"><? echo $tq ?></div></td>
        <td></td>
        <td><div align="right"><? echo $tt ?></div></td>
      </tr>
    </table>

</form>
</div>
<?
}else{
?>
<html>
<head>
<title>:: ENSCER - Ensinando o c&eacute;rebro :: Minhas Compras</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../enscercss.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php 
	ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
	include("../includes/topo.php");
	ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
?>
<div id="col1"> 

<?php 
	ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
	include("includes/menu.php");
	ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
?>

</div>
<div id="coltripla">
<h1>Minhas Compras</h1>
<h2><?php echo "$usuario"; ?></h2>
<hr>
<?
//Cria uma lista com todos os pedidos
	$SQL = "SELECT activity_order.*
			FROM activity_order
			WHERE activity_order.person_id=".$person." 
			ORDER BY orderdate DESC";
	$res = pg_query($SQL);

	echo "<h2>Pedidos realizados:</h2>";

	if(pg_num_rows($res)>0){
		while($linha = pg_fetch_array($res)){
			echo "<h3>Em: <a href='http://" . $_SERVER['SERVER_NAME'] . "/synapse/compras.php?codPed=". $linha[0] . "'>".formatadata($linha['orderdate'], "d-m-Y H:i")."</a><br></h3>";
		}
	}else{
		echo "<h3>Não há pedidos.<?h3>";
	}

/*
	echo "<hr>";
	echo "<h2>Materiais Disponíveis:</h2>";

	$SQL = "SELECT ni_niveis.ninome, ni_niveis.nicod, te_temas.tenome, te_temas.tepasta, di_disciplinas.dinome, di_disciplinas.dicod, maxus.clcod
			FROM (((maxus INNER JOIN ma_matapoio ON maxus.macod = ma_matapoio.macod) 
			INNER JOIN ni_niveis ON ma_matapoio.manivel = ni_niveis.nicod) 
			INNER JOIN te_temas ON ma_matapoio.matema = te_temas.tecod) 
			INNER JOIN di_disciplinas ON ma_matapoio.madisc = di_disciplinas.dicod
			WHERE (((maxus.clcod)=".$codUsu."));";
	$res = pg_query($SQL,$idcon);
	if(pg_num_rows($res)>0){

		while($linha = pg_fetch_array($res)){
			if($linha['dicod']==9){
				$disc="mat";
			}
			echo "<a href='../acesso/material/nivel".$linha['nicod']."/".$linha['tepasta']."/".$disc."/n".$linha['nicod']."_".$linha['tepasta']."_".$disc.".rar'><h3>".$linha['ninome']." - ".$linha['tenome']." - ".$linha['dinome']."</h3></a>";
		}
		echo "<a href='enscer.rar'><h3>Programa de Instalação</h3></a>";
	}else{
		echo "<h3>Não há Material Disponível.<?h3>";
	}
*/
}
?>
</div>
<div id="base">:: ENSCER - Ensinando o Cérebro :: <? echo date(Y);?> ::</div>
</body>
</html>