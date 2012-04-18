<?
    session_start();
	
    ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
    require("includes/conecta.php");
    ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
    
	
    ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
    require("includes/funcoes.php");
    ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
    
	if($todos==true){
		//session_unregister('codPed');
		$codPed="";
	}
	setlocale(LC_MONETARY, 'pt_br');
	if($boleto==true){
	    redireciona("http://".$_SERVER['SERVER_NAME']."/synapse/boleto.php");
	}
	
	if(isset($pedAtualiza) && $pedAtualiza==true){

		$txtDataPedido = $txtDataPedido!=""?"'" . date("Y-m-d H:i:s",cvdate($txtDataPedido)) . "'":"NULL";
	    $txtDataVcto = $txtDataVcto!=""?"'" . date("Y-m-d H:i:s",cvdate($txtDataVcto)) . "'":"NULL";
	    $txtDataEnvio = $txtDataEnvio!=""?"'" . date("Y-m-d H:i:s",cvdate($txtDataEnvio)) . "'":"NULL";
	    $txtDataPagto = $txtDataPagto!=""?"'" . date("Y-m-d H:i:s",cvdate($txtDataPagto)) . "'":"NULL";
	    $txtComentario = $txtComentario!=""?"'" . date("Y-m-d H:i:s",cvdate($txtComentario)) . "'":"NULL";


	    $SQL = "UPDATE activity_order SET paymentoption= '".$optPagamento."', 
										  orderdate=" . $txtDataPedido . ", 
										  paymentslip='" . $txtBoleto . "', 
										  paymentdate=" . $txtDataPagto . ",
										  duedate=" . $txtDataVcto . ", 
										  dispatchdate=" . $txtDataEnvio . ", 
										  amount=".$txtTotal." 
				WHERE id=".$codPed;
		$res=pg_query($SQL);
	}
	
	if(isset($codPed) && $codPed > 0){
	    $SQL = "SELECT * FROM activity_order WHERE id=".$codPed;
	    $res = pg_query($SQL);
		$linha = pg_fetch_array($res);
		
		$peCod = $linha['id'];
		session_register(peCod);
	    $clCod = $linha['person_id'];
	    session_register(clCod);
	    $peFormaPgto = $linha['paymentoption'];
	    $peDataPedido = $linha['orderdate']=="0000-00-00 00:00:00"?"":date("d/m/Y H:i:s",strtotime($linha['orderdate']));
		session_register(peDataPedido);
	    $peNumBoleto = $linha['paymentslip'];
	    $peDataPgto = $linha['paymentdate']==""?"":date("d/m/Y",strtotime($linha[6]));
	    $peDataVcto = $linha['duedate']==""?"":date("d/m/Y",strtotime($linha[7]));
		session_register(peDataVcto);
	    $peDataEnvio = $linha['dispatchdate']==""?"":date("d/m/Y",strtotime($linha[8]));
	    $peTotal = $linha['amount'];
	    session_register(peTotal);
		$peCancelado = $linha['canceled'];
	    $peAberto = $linha['open'];

 		if((isset($codUsu) && $codUsu > 0) || (isset($clCod) && $clCod>0)){
 			
			$selectSQL = "SELECT person.*, login.password, (city.name) as cityname
						  FROM person 
						  		LEFT JOIN login ON login.person_id=person.id 
								LEFT JOIN city ON city.id=person.city_id
						  WHERE person.id =" . $clCod;
		    $resultado = pg_query($selectSQL);
		    $linha = pg_fetch_array($resultado);
			$usuario = $linha['name'];
            session_register("usuario");
            $codUsu = $linha['id'];
            session_register("codUsu");
            $clEmail = $linha['email'];
			session_register("clEmail");
            $clTelefone = $linha['phone'];
            session_register("clTelefone");
            $clCelPhone = $linha['celphone'];
            session_register("clCelPhone");
            $clPassword = $linha['password'];
            session_register("clPassword");	
			$clLogra = $linha['addresstype'];
           	session_register("clLogra");			
			$clRua = $linha['address'];
           	session_register("clRua");
            $clNum = $linha['number'];
            session_register("clNum");
            $clComplemento = $linha['complement'];
           	session_register("clComplemento");
            $clBairro = $linha['clBairro'];
            session_register("clBairro");
            $clCidade = $linha['cityname'];
            session_register("clCidade");
            $clEstado = $linha['state_id'];
            session_register("clEstado");
            $clCEP = $linha['postalcode'];
            session_register("clCEP");
            $optTipo = "Cliente";
		}
?>
<html>
<head>
<title>Pedidos</title>
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

<form action="" method="post">
  <input type="hidden" name="pedAtualiza" value="true">
  <table width="560" border="0" cellpadding="2" cellspacing="0">
      <tr> 
        <td><strong>Data: </strong></td>
        <td><input name="txtDataPedido" type="text" size="25" <? if(isset($peDataPedido)) echo "value='" . $peDataPedido . "'" ; ?>> 
        </td>
        <td><strong>C&oacute;digo: </strong></td>
        <td> 
   <? if(isset($peCod)) echo $peCod ; ?>
        </td>
      </tr>

      <tr> 
        <td colspan="2"><h2>Dados Pessoais</h2></td>
        <td colspan="2"><h2>Endere&ccedil;o</h2></td>
      </tr>
      <tr> 
        <td width="16%"><strong>Nome: </strong><? echo ($clCod);?></td>
        <td width="31%"><? if(isset($usuario)){ echo $usuario;} ?></td>
        <td width="18%"><strong>Endereço:</strong></td>
        <td width="35%"><? if(isset($clRua)){ echo $clLogra. $clRua.", ".$clNum;}?></td>
      </tr>
      <tr> 
		<td><strong>Bairro: </strong></td>
        <td><? if(isset($clBairro)){ echo $clBairro;}?></td>        
		<td><strong>Complemento:</strong></td>
        <td><? if(isset($clComplemento)){ echo $clComplemento;} ?></td>
      </tr>
      <tr> 
        <td><strong> E-mail: </strong></td>
        <td><? if(isset($clEmail)){ echo $clEmail;}?></td>
        <td><strong>CEP: </strong></td>
        <td><? if(isset($clCEP)){ echo $clCEP;}?></td>
      </tr>
      <tr> 
        <td><strong>Fone: </strong></td>
        <td><? if(isset($clTelefone)){ echo $clTelefone;} ?></td>
        <td><strong>Cidade:</strong></td>
        <td><? if(isset($clCidade)){ echo $clCidade;}?></td>
      </tr>
      <tr> 
        <td><strong>Fax: </strong></td>
        <td><? if(isset($clCelPhone)){ echo $clCelPhone;}?></td>
        <td><strong>UF: </strong></td>
        <td><? if(isset($clEstado)){ echo $clEstado;}?></td>
      </tr>
      
    <tr> 
        <td colspan="4"><div align="center"> <h2 align="left">Pagamento</h2></div></td>
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
        <td><input name="txtTotal" type="text" size="25" align="right" <? if(isset($peTotal)) echo " value=" . number_format($peTotal, 2, '.', '.'); ?>></td>
        <td><strong>Situa&ccedil;&atilde;o:</strong></td>
        <td><input name="chkCancelado" type="checkbox" value="1" <? if(isset($peCancelado)&&$peCancelado==1) echo "checked"; ?> >
          Cancelado 
          <input name="chkAberto" type="checkbox" value="1" <? if(isset($peAberto)&&$peAberto==1) echo "checked"; ?> >
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
		$SQL = "SELECT * FROM order_detail WHERE activity_order=".$codPed."";
		$res = pg_query($SQL);
		$tq=0;
		$tt=0;
	    while($linha = pg_fetch_array($res)){
  		    $SQL = "SELECT activity.id, activity.value, (goal.name_varchar) as g_name 
					FROM activity 
							LEFT JOIN goal ON goal.id=activity.goal_id
					WHERE activity.id=".$linha['activity_id']."";
			$res2 = pg_query($SQL);
			$linha2 = pg_fetch_array($res2);
			$tt = ($linha[3] * $linha2['value']) + $tt;
			$tq = $linha[3] + $tq;
			echo '<tr><td><div align="center">' . $linha[2] . '</div></td><td>' . $linha2['g_name'] . '</td><td><div align="center">'. $linha[3] . '</div></td><td><div align="right">'. number_format($linha2['prPrecoUnit'], 2, ',', '.') . '</div></td><td><div align="right">' . number_format($linha[3] * $linha2['value'], 2, ',', '.').  '</div></td></tr>';
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
    <p> 
      <input name="sub" type="image" alt="Atualizar" src="../imagens/atualizar.gif">
      &nbsp;&nbsp;&nbsp; &nbsp; <a href="http://<? echo $_SERVER['SERVER_NAME']; ?>/synapse/boleto.php?pedAtualiza=true" target="_blank">
      <img src="../imagens/boleto.gif" border="0"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="http://<? echo $_SERVER['SERVER_NAME']; ?>/synapse/etiq.php" target="_blank"><img src="../imagens/etiqueta.gif" width="60" height="18" border="0"></a> 
    </p>
</form>
</div>
<div id="base">:: ENSCER - Ensinando o Cérebro :: <? echo date(Y);?> ::</div>
</body>
</html>
<? }else{ ?>
<html>
<head>
<title>Pedidos</title>
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
<h1>Histórico de Pedidos</h1>
<h3><a href=pedido.php?acao=1>Boletos Enviados ou Depósitos</a>
&nbsp&nbsp&nbsp<a href=pedido.php?acao=2>Boletos ou Depósitos Pagos</a>
&nbsp&nbsp&nbsp&nbsp<a href=pedido.php?acao=3>Cancelados</a></h3>
	<p>	<?
		//Cria uma lista com todos os pedidos
		    $SQL = "SELECT activity_order.*, person.name 
				    FROM person INNER JOIN activity_order ON person.id = activity_order.person_id ";
		    if($acao==""){
		    	$SQL.= "WHERE ((activity_order.dispatchdate) is NULL) AND ((activity_order.paymentoption)='Boleto') AND ((activity_order.canceled)=false) ORDER BY orderdate DESC";
		    }elseif($acao==1){
		    	$SQL.= "WHERE (((activity_order.dispatchdate) is NOT NULL) OR ((activity_order.paymentoption)='Depósito')) AND ((activity_order.canceled)=false) ORDER BY orderdate DESC";
		    }elseif($acao==2){
		    	$SQL.= "WHERE ((activity_order.canceled)=false) ORDER BY orderdate DESC";
		    }elseif($acao==3){
		    	$SQL.= "WHERE ((activity_order.canceled)=true) ORDER BY orderdate DESC";
		    }
		    $res = pg_query($SQL);
		    while($linha = pg_fetch_array($res)){
   			    if($linha['paymentslip'] == ""){
                    echo '<b>Em: <a href="http://' . $_SERVER['SERVER_NAME'] . '/synapse/pedido.php?codPed='. $linha['id'] . '">' . date("d-m-Y H:i", strtotime($linha[4])) . '</a> - ' . $linha['name'] .  ' - ' . $linha["paymentoption"] . '</b><br>'	;
       			}else{
  					echo 'Em: <a href="http://' . $_SERVER['SERVER_NAME'] . '/synapse/pedido.php?codPed='. $linha['id'] . '">' . date("d-m-Y H:i", strtotime($linha[4])) . '</a> - ' . $linha['name'] . ' - <font color=red><b>' . $linha["paymentslip"] . '</b></font><br>';       			
       			}
	    	}
		}
?></p>
</div>
</body>
</html>
