<?php
	if(isset($proj) && $proj==3){
		echo '<a href="sysuser.php"><img src="images/portal_capes.jpg" border="0"></a>';
	}else{
		echo '<a href="sysuser.php"><img src="images/portal_enscer.gif" border="0"></a>';
	}
?>
<div id="menu2acesso"> 
  
  <?php
  if(isset($idiom) && $idiom=="7"){
  	$home="In�cio";
	$news="Not�cias";
	$activity="Tema";
	$performance="Performance";
	$questedita="Edita Quest";
	$questionary="Question�rio";
	$register="Meu Cadastro";
	$contact="Meus Contatos";
	$logout="Sair";
  }
  
  if(isset($idiom) && $idiom=="16"){
  	$home="Home";
	$news="News";
	$activity="Activities";
	$performance="Performance";
	$questedita="Edita Quest";
	$questionary="Questionary";
	$register="My Registration";
	$contact="My Contacts";
	$logout="Log Out";
  }
  
  if(isset($idiom) && $idiom=="17"){
  	$home="Haus";
	$news="Nachricht";
	$activity="Aktivit�ten";
	$performance="Erf�llung";
	$questedita="Herausgeben blick";
	$questionary="�berblick";
	$register="Meine Registrierung";
	$contact="Meine Ber�hrung";
	$logout="Log Out";
  }
  ?>
     
  <ul>
    <strong>
    <li class="dest"><a href="sysuser.php"><?php echo $home; ?></a></li>
    <li class="dest"><a href="contact.php"><?php echo $contact; ?></a></li> 
	
	<?php
	if(isset($actor)){
		echo '<li class="dest"><a href="person_ins.php">'.$register.'</a></li>';
	}
	if($personage==1){
		echo '<li class="dest"><a href="pedido.php">Pedidos</a></li>';
		echo '<li class="dest"><a href="actor_ins.php">Pessoas</a></li>';	
		echo "<li></li>";
	}
	if($personage==1 || $personage==3){
		echo "<li class=titdest>Atividades</li>";
		echo '<li class="dest"><a href="block.php">Blocos</a></li>';
		echo '<li class="dest"><a href="content.php">Conte�dos</a></li>';
		echo '<li class="dest"><a href="goal.php">Objetivos</a></li>';
		echo "<li class='dest'><a href='element.php?menu=true'>Elementos</a></li>";
		echo '<li class="dest"><a href="activity.php">Temas</a></li>';
		echo '<li class="dest"><a href="language.php">Language</a></li>';		
		echo '<li class="dest"><a href="../acesso/material.php" target="_blank">Material</a></li>';
	}elseif($personage==2){
		//echo '<li class="dest"><a href="compras.php?limpa=true">Minhas Compras</a></li>';
	}
	if($personage==4){
		echo '<li class="dest"><a href="block.php">Blocos</a></li>';
	}
	?>
	<li></li>
    <li class="dest"><a href="logout.php"><?php echo $logout; ?></a></li>
    </strong> 
  </ul>
</div>
