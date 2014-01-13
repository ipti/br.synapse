<?php
	 session_start();
	
	 $pr ="";
	 $j=(sizeof($_SESSION["produtos"]));
	 for ($i=1;$i<=$j;$i++){
	     $pr .= " id <> " . $_SESSION['produtos'][$i]['id'];
	     if($i<>$j){
	         $pr .= " and";
	     }
	 }
	 if($pr <> ""){
     	 $SQL = "SELECT * FROM activity WHERE ".$pr;
	 }else{
	 	 $SQL = "SELECT * FROM activity WHERE activity.active <> 0";
	 }
   	 $res = pg_query($SQL);
   	 $i = 1;
?>
<form name='maisprod' action=http://<?php echo $_SERVER['SERVER_NAME']  ?>/synapse/fechapedido.php method=POST>
     <h2>Confira também estes produtos:</h2>
		<p>
     	 <?
     	 if(pg_num_rows($res)> 0 ){
		     while($linha = pg_fetch_array($res)){
			 if($linha['active'] > 0){
     	         echo '<BR><input type="hidden" name="codprods['.$i.']" value="' . $linha["id"] . '"><input type="text" name="maisprods[' . $i . ']" size=1 value="0"> x <a href="http://'. $_SERVER['SERVER_NAME'] . $linha["prLink"].'" target="_blank">' . $linha["g_name"] . ' </a> = R$ ' .  substr(money_format("%.2n", $linha["value"]),0,-3);
     	         echo "\n";
     	         $i++;
				 }
     	     }
 	     }
     	 ?>
 <p>
    <input type="image" src="images/adicionar.gif" name="sub">
    <a href="fechapedido.php#compras"><img src="images/voltar.gif" width="60" height="18" border="0"></a></p>
</form>
</p>
