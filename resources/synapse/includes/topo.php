<div id="topo" ><img src="<?php echo 'http://' . $_SERVER['SERVER_NAME']; ?>/synapse/images/<?php echo $logo; ?>" width="201" height="87" alt="ENSCER"><img src="<?php echo 'http://' . $_SERVER['SERVER_NAME']; ?>/synapse/images/top_degrade.gif" width="85" height="87"></div>

<div id="foldertop">
<?php
	if(isset($proj) && $proj==3){
		echo '<h1 align="center">Desempenho Escolar Inclusivo na Perspectiva Multidisciplinar</h1>';
	}else{
	}
?>
</div>

<?php
	if(isset($proj) && $proj==3){
	}else{
?>
<div id="contatotop"> 
    <p><strong><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME']; ?>/synapse/index.php">Login</a><br>
    <a href="<?php echo 'http://' . $_SERVER['SERVER_NAME']; ?>/synapse/contact.php">Entrar em Contato</a><br>
	<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME']; ?>/synapse/contact.php?viewcont=true">Ver Meus Contatos</a></strong></p>
<?php
	echo "<p><a href='index.php?idiom='17''>DE</a> - <a href='index.php?idiom='7''>PT</a> - <a href='index.php?idiom='16''>EN</a></p>";
	}
?>
</div>
	
<div id="menutop"> 
  <ul>
    <strong> 
    <li class="zero"></li>
    </strong>
<?php
	if(isset($proj) && $proj==3){
	
	}else{
?>
    <li class="inicio"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME']; ?>/index.php">INÍCIO</a></li>
    <li class="larga"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME']; ?>/pesquisas/index.php">PESQUISAS</a></li>
    <li class="larga"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME']; ?>/assessoria.php">ASSESSORIA</a></li>
    <li class="larga"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME']; ?>/parceiros/index.php">PARCEIROS</a></li>
    <li class="apoio">Material de Apoio</li>
    <li class="meio"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME']; ?>/material/artigos/index.php">ARTIGOS</a></li>
    <li class="meio"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME']; ?>/material/livros/index.php">LIVROS</a></li>
    <li class="meio"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME']; ?>/material/cursos/index.php">CURSOS</a></li>
    <li class="cd"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME']; ?>/material/cds/cds.php">CDs</a></li>
    <li class="meio"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME']; ?>/material/gibis/index.php">GIBIS</a></li>
    <li class="larga"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME']; ?>/material/revistas/index.php">REVISTAS</a></li>
    <li class="larga"><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME']; ?>/material/brinquedos/index.php">BRINQUEDOS</a></li>
<?php } ?>
  </ul>
</div>