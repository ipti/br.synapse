<?php
    
   ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
   require("includes/conecta.php");
   ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
   
   ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
   require("includes/funcoes.php");
   ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

if(!(session_is_registered('person'))){
	echo "erro";
	header('Location: ' . "http://" . $_SERVER["SERVER_NAME"]."/synapse/index.php");	
}
       	
	session_start();
	
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
<div id="coldupla2">
<h1>Pedido Concluído (No. <? echo $codPed; ?> )</h1>

	    <br><h2> Seu Pedido, de número <? echo $codPed; ?>, foi realizado com sucesso. </h2>
	
	    <?
   		    $SQL = "UPDATE activity_order SET paymentoption='".$pagamento."', open=true, canceled=false WHERE id=".$codPed."";
			pg_query($SQL);
            pg_query("COMMIT");
			$texto = "Dados do Pedido\n";
	    	$texto .= "Nome: ". $personname ."\n";
	        $texto .= "Endereço: ".$addresstype." ".$address .", ".$number. "\n";
	        $texto .= "Comp: ". $complement . "\n";
	        $texto .= "Bairro: ". $clBairro . "\n";
	        $texto .= "CEP: ". $postalcode . "\n";
	        $texto .= "Cidade: ". $cityname . "\n";
	        $texto .= "Estado: ". $state . "\n";
	        $texto .= "Pagamento: " . $paymentoption . "\n";

		 if($pagamento == 'Boleto'){
?>
			<h3>Você receberá um boleto bancário no valor da sua compra. <br>
			Basta pagá-lo até a data de vencimento em qualquer banco. <br>
			Após o pagamento enviaremos automaticamente seus produtos para o endereço do seu cadastro.
			</h3>
			
			<h3>Nome: <?php echo $personname; ?> <br>
			Endereço: <?php echo $addresstype." ".$address.", ".$number; ?>
			<?php if (isset($complement) && $complement!=""){echo " - ".$complement;} ?>
			<?php echo "<br>".$clBairro; ?> - CEP: <?php echo $postalcode; ?> - <?php echo $cityname; ?> - <?php echo $state; ?>
			</h3>		 
	    
  <?php }else{ ?>
  
  <h3>Deposite o total da sua compra ( <? setlocale(LC_MONETARY, 'pt_BR'); echo substr(money_format('%.2n', $total),0,-3);?>) na seguinte conta: <br>
    Banco Real <br>
    Agência 0912 <br>
    Conta 0000653 <br>
    EINA - Estudos em Inteligência Natural e Artificial Ltda<br>
    Cnpj: 01.785.137/0001-61<br>
    <br>
    Após o depósito envie o comprovante por fax (11) 3379-2010 ou E-mail: contato@enscer.com.br
    <br>
    Assim que recebermos seu comprovante, enviaremos seu pedido para o endereço
    do seu cadastro. </h3>
			
		 <h3>Nome: <?php echo $personname; ?> <br>
         Endereço: <?php echo $addresstype." ".$address.", ".$number; ?>
         <?php if (isset($complement) && $complement!=""){echo " - ".$complement;} ?>
	     <?php echo "<br>".$clBairro; ?> - CEP: <?php echo $postalcode; ?> - <?php echo $cityname; ?> - <?php echo $state; ?>
		 </h3>
		 
	    <?
	  $texto .= "\nDeposite o total da sua compra ( " . substr(money_format('%.2n', $total),0,-3). ") na seguinte conta:\n Banco Real \n Agência 0912 \n Conta 0000653 \n EINA - Estudos em Inteligência Natural e Artificial Ltda \n Cnpj: 01.785.137/0001-61 \n Após o depósito envie o comprovante por fax (11) 3379-2010 ou E-mail: atendimento@enscer.com.br \n Assim que recebermos seu comprovante, enviaremos seu pedido para o endereço do seu cadastro.\n";
   }
	 //}else{   <-- <br><h2> Falha no envio do pedido ...</h2>
	 ?>

	
	 </div>
	 <div id="col4"> 
<div id="relac">
<h2>Suas Compras:</h2>
</div>
<?php
	 
	 if((sizeof($_SESSION["produtos"]))>0){
       $total = 0;
       for ($i=1;$i<=(sizeof($_SESSION["produtos"]));$i++){
           $texto .= $_SESSION['produtos'][$i][13] . $_SESSION['qtde'][$i] . " x " . $_SESSION['produtos'][$i]['g_name']."\n";
           echo "<p>" . $_SESSION['produtos'][$i][13] . $_SESSION['qtde'][$i] . " x " . $_SESSION['produtos'][$i]['g_name'];
           $total = ($_SESSION['produtos'][$i][13] * $_SESSION['produtos'][$i]['value']) + $total;
       }
       setlocale(LC_MONETARY, 'pt_BR');
       echo "<br>______________________________<br><h2> " . substr(money_format('%.2n', $total),0,-3);
       echo "</h2>";
	   $texto .= " " . substr(money_format('%.2n', $total),0,-3);
    }
	
mail($emailusu,"[Pedido - ENSCER]", $texto, "From: contato@enscer.com.br") or die("Erro ao enviar e-mail");
mail("contato@enscer.com.br","[Novo Pedido]", $texto, "From: " . $emailusu) or die("Erro ao enviar e-mail");
?>
</div>
</body>
<div id="base">:: ENSCER - Ensinando o Cérebro :: <? echo date('Y');?> ::</div>