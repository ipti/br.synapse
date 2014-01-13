<?php
session_start();
if(((isset($newscreen) && $newscreen==true) || (isset($newpiece) && $newpiece==true) || (isset($newpieceelement) && $newpieceelement==true)) || (isset($element_id) && $element_id!="") || (isset($piece_id) && $piece_id!="")){ ?>
	<table cellpadding="0" cellspacing="0" width="100%" border="1 solid">
		<tr>
			<form name="form13" action="activity.php" method="post" onSubmit="return check_form13(form13);">
			<td width="50" align="left"><p>
				<input type='radio' name='radio_name' value='word'>Pal<br>
				<input type='radio' name='radio_name' value='compound'>Com<br>
				<input type='radio' name='radio_name' value='phrase'>Fra<br>
				<input type='radio' name='radio_name' value='paragraph'>Par</p>
			</td>
			<td width="50" align="left">
				<p><input type='radio' name='radio_name' value='number'>Num</p>
			</td>
			<td bgcolor="#FFFFFF" valign="top">
				<?php 
				/* 
				<script type="text/javascript" src="nicEdit.js"></script > 
				<script type="text/javascript"> //<![CDATA[ bkLib.onDomLoaded(function() { nicEditors.allTextAreas() }); //]]> </script > 
				*/ 
				?>
				<textarea name="text" style="width: 100%; height: 100%;"></textarea>
			</td>
			<td width="150">
				<table width="100%">
					<tr>
						<td>
							<table width='100'>
								<tr>
									<td>
										<p><input type="radio" name="verbal" value="written">Escr
										<input type="radio" name="verbal" value="oral">Oral</p>
									</td>
								</tr>
								<tr>
									<td>
										<p><select name="layertype_id"> <?php //<input name='imgGravar' value='true' id='sub' type='image' title='Buscar' src='images/sel.gif' alt='Buscar' width='30' height='15' border='0' onClick=filtra13(1)>
										$SQL = "SELECT * FROM layertype ORDER BY name";
										$res = pg_query($SQL);
										while($linha = pg_fetch_array($res)){
											echo "<option value='".$linha['id']."'>".$linha['name']."</option>";
										} echo "</select></p>"; ?>
									</td>
								</tr>
							</table>
						</td>
						<td>
							<input type="submit" name="go" value="Sel" align="left" width="18" height="18" onClick="filtra13(1)">
							<input type="submit" name="go" value="Ins" align="left" width="18" height="18" onClick="filtra13(3)">
						</td>
					</tr>
				</table>
			</td>
				<input type='hidden' name='activity_id' value='<?php echo $activity_id; ?>'> 
				<input type='hidden' name='activitytype_id' value='<?php echo $activitytype_id; ?>'> 
				<input type="hidden" name="screen" value="<?php echo $screen; ?>">					
			<?php if(isset($piece_id) && $piece_id!=""){ ?>
				<input type="hidden" name="piece_id" value="<?php echo $piece_id; ?>">
				<input type="hidden" name="piecename" value="<?php echo $piecename; ?>">
			<?php } ?>
			<?php if(isset($newscreen) && $newscreen!=""){ ?>
				<input type="hidden" name="newscreen" value="<?php echo $newscreen; ?>">
			<?php } ?>
			<?php if(isset($totalscreen) && $totalscreen!=""){ ?>
				<input type="hidden" name="totalscreen" value="<?php echo $totalscreen; ?>">
			<?php } ?>
			<?php if(isset($newpiece) && $newpiece==true){ ?>
				<input type="hidden" name="newpiece" value="true">
			<?php } ?>
			<?php if(isset($newpieceelement) && $newpieceelement==true){ ?>
				<input type="hidden" name="newpieceelement" value="true">
			<?php } ?>
				<input type="hidden" name="discname" value="<?php echo $discname; ?>"> 
				<input type="hidden" name="goaldescription" value="<?php echo $goaldescription; ?>"> 
				<input type="hidden" name="semanticname" value="<?php echo $semanticname; ?>"> 
				<input type="hidden" name="blockname_varchar" value="<?php echo $blockname_varchar; ?>"> 
				<input type="hidden" name="block_content" value="<?php echo $block_content; ?>"> 
				<input type="hidden" name="activityname" value="<?php echo $activityname; ?>"> 
				<input type="hidden" name="layer_property_id" value="<?php echo $layer_property_id; ?>"> 
				<input type="hidden" name="activitydescription" value="<?php echo $activitydescription; ?>"> 
				<input type="hidden" name="typename" value="<?php echo $typename; ?>"> 
				<input type="hidden" name="filtragem" value="0">
			</form>
			
			<td width="180">
			<form name="form2" action="activity.php" method="post" onSubmit="return check_form2(form2)">
				<table width="100%">
					<tr>
						<td align="center">
							<p>
							<input type='radio' name='radio_name' value='image'>Img
							<input type='radio' name='radio_name' value='movie'>Mov
							<input type='radio' name='radio_name' value='music'>Msc
							<input type='radio' name='radio_name' value='noise'>Snd<br>
							<input type='text' name='name' size="14" onkeyup="up(this)">
							<input type='hidden' name='activity_id' value='<?php echo $activity_id; ?>'> 
							<input type='hidden' name='activitytype_id' value='<?php echo $activitytype_id; ?>'> 
							<input type="hidden" name="screen" value="<?php echo $screen; ?>">				
							<?php if(isset($piece_id) && $piece_id!=""){ ?>
								<input type="hidden" name="piece_id" value="<?php echo $piece_id; ?>">
								<input type="hidden" name="piecename" value="<?php echo $piecename; ?>">
							<?php } ?>
							<?php if(isset($newscreen) && $newscreen!=""){ ?>
								<input type="hidden" name="newscreen" value="<?php echo $newscreen; ?>">
							<?php } ?>
							<?php if(isset($totalscreen) && $totalscreen!=""){ ?>
								<input type="hidden" name="totalscreen" value="<?php echo $totalscreen; ?>">
							<?php } ?>
							<?php if(isset($newpiece) && $newpiece==true){ ?>
								<input type="hidden" name="newpiece" value="true">
							<?php } ?>
							<?php if(isset($newpieceelement) && $newpieceelement==true){ ?>
								<input type="hidden" name="newpieceelement" value="true">
							<?php } ?>
							<input type="hidden" name="discname" value="<?php echo $discname; ?>"> 
							<input type="hidden" name="goaldescription" value="<?php echo $goaldescription; ?>"> 
							<input type="hidden" name="semanticname" value="<?php echo $semanticname; ?>"> 
							<input type="hidden" name="blockname_varchar" value="<?php echo $blockname_varchar; ?>"> 
							<input type="hidden" name="block_content" value="<?php echo $block_content; ?>"> 
							<input type="hidden" name="activityname" value="<?php echo $activityname; ?>"> 
							<input type="hidden" name="activitydescription" value="<?php echo $activitydescription; ?>"> 
							<input type="hidden" name="typename" value="<?php echo $typename; ?>"> 
							<input type="hidden" name="layer_property_id" value="<?php echo $layer_property_id; ?>"> 
							<input type="hidden" name="layertype_id" value="<?php echo $layertype_id; ?>"> 
							<input type="hidden" name="filtragem" value="0">
							<input type="submit" name="go" value="Sel" align="left" width="18" height="18" onClick="filtra2(2)">
							</p>
						</td>
					</tr>
				</table>
			</form>
			</td>
		</tr>
	</table>
<?php //<input type='text' name='name' size="10" onkeyup="up(this)"> <INPUT TYPE="text" NAME="name" onBlur="upperMe()" size="10"> ;javascript:window.location.reload();
}else{
	echo "<h3><font color='red'>Selecione um ítem de </font>".$screenpiece."! Ou Insira um Novo Ítem ou uma Nova Página</h3>";
}//if(isset($piece_id) && $piece_id!=""){	
?>