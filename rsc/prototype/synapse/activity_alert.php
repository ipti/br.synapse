<?php
session_start();
//echo "<table width='100%' border='1 solid'><tr><td>";
if((isset($newscreen) && $newscreen==true) || (isset($newpiece) && $newpiece==true) || (isset($newpieceelement) && $newpieceelement==true) || (isset($element_id) && $element_id!="")){ ?>
	<div style="top:0; left:5; width:100%; height:20; background-color: #FF0000; layer-background-color: #FF0000; border: 1px none #000000;">
		<?php if(isset($newscreen) && $newscreen==true){ ?>
				<h12>Você está Inserindo uma Nova Questão em uma Nova Tela</h12>
		<?php }elseif((isset($newpiece) && $newpiece==true)){ ?>
				<h12>Você está Inserindo uma Nova Questão na <?php echo $screen; ?>ª Tela<?php //echo $screenpiece; ?></h12>
		<?php }elseif(isset($newpieceelement) && $newpieceelement==true){ ?>
				<h12>Você está Inserindo um Novo Elemento na <?php echo $pieceseq; ?>ª Questão</h12>
		<?php }elseif(isset($element_id) && $element_id!=""){ ?>
				<h12>Você está Editando o Elemento <?php echo $layer; ?></h12>
		<?php } ?>
	</div><?php 
} 
//echo "</td></tr></table>"; 
?>
