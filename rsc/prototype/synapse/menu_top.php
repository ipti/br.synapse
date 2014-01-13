<?php
  if(isset($idiom) && $idiom=="7"){
  	$home="Início";
	$news="Notícias";
	$activity="Tema";
	$performance="Performance";
	$questedita="Edita Quest";
	$questionary="Questionário";
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
	$activity="Aktivitäten";
	$performance="Erfüllung";
	$questedita="Herausgeben blick";
	$questionary="Überblick";
	$register="Meine Registrierung";
	$contact="Meine Berührung";
	$logout="Log Out";
  }
  ?>
<div id="menu2acesso">
  <ul>
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
		echo '<li class="dest"><a href="content.php">Conteúdos</a></li>';
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
</ul>
</div>
