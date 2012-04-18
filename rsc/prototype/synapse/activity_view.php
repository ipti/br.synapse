<?php
echo "<table  width='100%' border='1' cellspacing='0'>";
//echo '<tr><td><a name="goal_anchor"></a>&snbp</td></tr>';
echo "<tr><td colspan='4'><h3 align='center'>".$description."</h3></td></tr>";

if(!isset($editar)){
	echo "<tr><td colspan='4'>";
		echo "<form name='description' action='goal.php' method='POST'>";
			echo "<textarea cols='100' rows='1' name='txtdescriptiongoal'>".$description."</textarea>";
			echo "<input type='hidden' name='goal_id' value='".$goal_id."'>";
			ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
			include("goal/content_form.php");
			ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
			echo "<input type='hidden' name='upddescriptiongoal' value='true'>";
			echo "<input type='submit' value='Upd' style='width:35px; height:20px;'>";
		echo "</form>";
	echo "</td></tr>";
}

echo "<tr><td colspan='4'>";
	echo "<p><strong>Conteúdos:</strong> ".$activitycontent;
		$SQLch = "SELECT contenthability_id FROM goal WHERE id=".$goal_id;
		$resch = pg_query($SQLch);
		$li = pg_fetch_array($resch);
		echo $li['contenthability_id']." - ";
		echo "<a href='goal.php?editar=true&goal_id=".$goal_id;
								ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
									include("goal/content_link.php");
								ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
			echo "'>Editar";
		echo "</a>";
	echo "</p>";
echo "</td></tr>";

$it = 0;
	echo "<tr><td colspan='4'><table border='1' width='100%' cellspacing='0'>";
	echo "<tr align='center'><td>Tema</td><td>Código</td><td>Arquivos</td><td>Nome</td><td>Descrição</td><td>Tipo</td></tr>";

	$SQLt = "SELECT a.*, (at.name) as typename, s.name_varchar as semanticname, s.id as semantic_id
			 FROM activity a
					LEFT JOIN activitytype at ON at.id = a.activitytype_id
					LEFT JOIN semantic s ON s.id = a.semantic_id
			 WHERE ";
	$SQLt .= "a.goal_id = ".$goal_id."
			ORDER BY s.name_varchar";
	$rest = pg_query($SQLt);

	if(pg_num_rows($rest)>0){

		while($linhat = pg_fetch_array($rest)){
			
			$it ++; ?>
			<tr align='right'><td><?php echo $linhat['semanticname']; ?></td>
			<td><a href="#" onClick="MM_openBrWindow('activity.php?semanticname=<?php echo $linhas1['name_varchar']; ?>&activity_id=<?php echo $linhat['id']; ?>&activitytype_id=<?php echo $linhat['activitytype_id']; ?>&goaldescription=<?php echo $description; ?>&stagename=<?php echo $stagename; ?>&blockname=<?php echo $blockname; ?>&goalgrade=<?php echo $goalgrade; ?>', 'activity',  'address=no, toolbar=no, menubar=no, status=no, location=no, top=0, left=0, width=1010, height=710')"><?php
			echo $linhat['id']; ?>
			</a></td><?php //goal_anchor
			echo "<td>";
			if($discipline==1){
				$discf = "lang";
			}elseif($discipline==2){
				$discf = "math";
			}elseif($discipline==3){
				$discf = "scie";
			}
			$path = "../acesso/material/temas/".(((isset($linhat['semanticname'])) && ($linhat['semanticname']!=""))?($linhat['semanticname']."/"):"DISC/").$discf."/";
	
			if(is_dir($path)){
				$dir=opendir($path);
				while(($arquivos=readdir($dir)) !== false){
					if($arquivos=="." or $arquivos=="..") continue; {
						$arquivo = before($arquivos, "_");
						$ext = after($arquivos, "_");
						$seq = before($ext, ".");
						if($arquivo==$linhat['id']){
							echo "<a href='".$path.$arquivos."' target='_blank' class='link'> - ".$seq." </a>";
						}
					}
				}
			}
			echo "<a href='goal.php?goal_id=".$goal_id."&iat=".$it."&activity_id=".$linhat['id']."&discf=".$discf."&semantic=".$linhat['semantic_id'];
			ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
				include("goal/content_link.php");
			ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
	//			echo "#goal_anchor";
			echo "'>+</a>";
			echo "</td>";?>
			
			<form name="activity" action="goal.php">
			<td><input type="text" name="activityname" size="4" value="<?php echo $linhat['name_varchar']; ?>"></td>
			<td><input type="text" name="activitydescription" size="40" value="<?php echo $linhat['description']; ?>"></td>
			<td><select name='activitytype_id'><?php
				echo "<option value='".$linhat['activitytype_id']."'>".$linhat['typename']."</option>";			
				$SQLat = "SELECT * FROM activitytype ORDER BY NAME";
				$resat = pg_query($SQLat);
				while($linhaat = pg_fetch_array($resat)){
					echo "<option value=".$linhaat['id'].">".$linhaat['name']."</option>";
				}?>
			</select>
			<input type="hidden" name="activity_id" value="<?php echo $linhat['id']; ?>">
			<?php
			ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
				include("goal/content_form.php");
			ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
			?>						
			<input type="hidden" name="goal_id" value="<?php echo $goal_id; ?>">
			<input type="hidden" name="updactivity" value="true">
			<input type="submit" value="OK"></td>
			</form>
			</tr><?php
			
			if((isset($activity_id) && $activity_id!="") && $iat==$it){ ?>
			
				<tr> 
				<form name="anexo" action="goal.php" method="POST" enctype="multipart/form-data">
				  <td colspan='7'><input type="file" size="20" name="anexado"> 
					<input type="hidden" name="iat" value="<?php echo $iat; ?>"> 
					<input type="hidden" name="activity_id" value="<?php echo $activity_id; ?>"> 
					<input type="hidden" name="semantic" value="<?php echo $semantic; ?>"> 
					<?php	
					ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
						include("goal/content_form.php");
					ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
					?>
					<input type="hidden" name="path" value="<?php echo $path; ?>"> 
					<input type='hidden' name='goal_id' value='<?php echo $goal_id; ?>'> 
					<input type="hidden" name="anexar" value=""> 
					<input type="submit" value="Inserir" onClick="filtraanexo(1)" style="border: 1pt solid #222222; background-color:#444444; color: #EEEEEE; width: 60px; height:20px;">
					</td>
				</form>
				</tr><?php
			}//if((isset($activity) && $activity!="") && $iat==$it){
		}//while($linhat = pg_fetch_array($res)){activity
	}else{
		echo "<tr><td colspan='4'><h3 align='center'><font color='red'>Não há atividades para esse objetivo</font></h3></td></tr>";
	}
	echo "</table></td></tr>";
echo "<tr><td colspan='4'><h3 align='right'><a href='#' onclick=\"javascript:window.open('activity_ins.php?goal_id=".$goal_id."&blockname=".$blockname."&";
echo "degreeblock=".$degreeblock."&acao=1','',',,,width=600,height=300')\"><font color='red'>Inserir</font> Nova Atividade</a></h3></td></tr>";
echo "</table>";//goal_anchor
?>