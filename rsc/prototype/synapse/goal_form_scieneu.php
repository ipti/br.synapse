<?php
//_______________________________________________________________________________________________________________- BIO ou NEURO
//echo "<td>";
echo "<table>";
	echo "<tr>";
		echo "<td>";
			echo "<table>";
			echo "<tr><td>Sistemas:</td><td> <select name='sistemas' onChange=document.goal_ins.submit()>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 1348 ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($sistemas)?$sistemas:"")."'>".(isset($sistemasname)?$sistemasname:"")."</option>";
			echo "<option value=''></option>";
			while($linhafu = pg_fetch_array($resfu)){
				echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
			
			if(isset($sistemas) && $sistemas!=""){
				echo "<tr><td>SubSistemas:</td><td> <select name='subsistemas' onChange=document.goal_ins.submit()>";
				$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$sistemas." ORDER BY name_varchar";
				$resfu = pg_query($SQLfu);
				echo "<option value='".(isset($subsistemas)?$subsistemas:"")."'>".(isset($subsistemasname)?$subsistemasname:"")."</option>";
				echo "<option value=''></option>";
				while($linhafu = pg_fetch_array($resfu)){
					echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
				}
				echo "</select></td></tr>";
			}
			if(isset($subsistemas) && $subsistemas!=""){
				echo "<tr><td>SubSistemas1:</td><td> <select name='subsistemas1' onChange=document.goal_ins.submit()>";
				$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$subsistemas." ORDER BY name_varchar";
				$resfu = pg_query($SQLfu);
				echo "<option value='".(isset($subsistemas1)?$subsistemas1:"")."'>".(isset($subsistemas1name)?$subsistemas1name:"")."</option>";
				echo "<option value=''></option>";
				while($linhafu = pg_fetch_array($resfu)){
					echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
				}
				echo "</select></td></tr>";
			}
			if(isset($subsistemas1) && $subsistemas1!=""){
				echo "<tr><td>SubSistemas2:</td><td> <select name='subsistemas2' onChange=document.goal_ins.submit()>";
				$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$subsistemas1." ORDER BY name_varchar";
				$resfu = pg_query($SQLfu);
				echo "<option value='".(isset($subsistemas2)?$subsistemas2:"")."'>".(isset($subsistemas2name)?$subsistemas2name:"")."</option>";
				echo "<option value=''></option>";
				while($linhafu = pg_fetch_array($resfu)){
					echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
				}
				echo "</select></td></tr>";
			}
			if(isset($subsistemas2) && $subsistemas2!=""){
				echo "<tr><td>SubSistemas3:</td><td> <select name='subsistemas3' onChange=document.goal_ins.submit()>";
				$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$subsistemas2." ORDER BY name_varchar";
				$resfu = pg_query($SQLfu);
				echo "<option value='".(isset($subsistemas3)?$subsistemas3:"")."'>".(isset($subsistemas3name)?$subsistemas3name:"")."</option>";
				echo "<option value=''></option>";
				while($linhafu = pg_fetch_array($resfu)){
					echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
				}
				echo "</select></td></tr>";
			}
			echo "</table>";
		echo "</td>";
		
		echo "<td>";
			echo "<table>";	
				echo "<tr><td>Citologia:</td><td> <select name='citologia' onChange=document.goal_ins.submit()>";
				$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 1068 ORDER BY name_varchar";
				$resfu = pg_query($SQLfu);
				echo "<option value='".(isset($citologia)?$citologia:"")."'>".(isset($citologianame)?$citologianame:"")."</option>";
				echo "<option value=''></option>";
				while($linhafu = pg_fetch_array($resfu)){
					echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
				}
				echo "</select></td></tr>";
				
				if(isset($citologia) && $citologia!=""){
					echo "<tr><td>Subcitologia:</td><td> <select name='subcitologia' onChange=document.goal_ins.submit()>";
					$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$citologia." ORDER BY name_varchar";
					$resfu = pg_query($SQLfu);
					echo "<option value='".(isset($subcitologia)?$subcitologia:"")."'>".(isset($subcitologianame)?$subcitologianame:"")."</option>";
					echo "<option value=''></option>";
					while($linhafu = pg_fetch_array($resfu)){
						echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
					}
					echo "</select></td></tr>";
				}
				if(isset($subcitologia) && $subcitologia!=""){
					echo "<tr><td>Subcitologia1:</td><td> <select name='subcitologia1' onChange=document.goal_ins.submit()>";
					$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$subcitologia." ORDER BY name_varchar";
					$resfu = pg_query($SQLfu);
					echo "<option value='".(isset($subcitologia1)?$subcitologia1:"")."'>".(isset($subcitologia1name)?$subcitologia1name:"")."</option>";
					echo "<option value=''></option>";
					while($linhafu = pg_fetch_array($resfu)){
						echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
					}
					echo "</select></td></tr>";
				}
				if(isset($subcitologia1) && $subcitologia1!=""){
					echo "<tr><td>Subcitologia2:</td><td> <select name='subcitologia2' onChange=document.goal_ins.submit()>";
					$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$subcitologia1." ORDER BY name_varchar";
					$resfu = pg_query($SQLfu);
					echo "<option value='".(isset($subcitologia2)?$subcitologia2:"")."'>".(isset($subcitologia2name)?$subcitologia2name:"")."</option>";
					echo "<option value=''></option>";
					while($linhafu = pg_fetch_array($resfu)){
						echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
					}
					echo "</select></td></tr>";
				}
				if(isset($subcitologia2) && $subcitologia2!=""){
					echo "<tr><td>Subcitologia3:</td><td> <select name='subcitologia3'>";
					$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$subcitologia2." ORDER BY name_varchar";
					$resfu = pg_query($SQLfu);
					echo "<option value='".(isset($subcitologia3)?$subcitologia3:"")."'>".(isset($subcitologia3name)?$subcitologia3name:"")."</option>";
					echo "<option value=''></option>";
					while($linhafu = pg_fetch_array($resfu)){
						echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
					}
					echo "</select></td></tr>";
				}
			echo "</table>";
		echo "</td>";

		echo "<td>";
			echo "<table>";
				echo "<tr><td>Tecidos:</td><td> <select name='tecidos' onChange=document.goal_ins.submit()>";
				$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 1273 ORDER BY name_varchar";
				$resfu = pg_query($SQLfu);
				echo "<option value='".(isset($tecidos)?$tecidos:"")."'>".(isset($tecidosname)?$tecidosname:"")."</option>";
				echo "<option value=''></option>";
				while($linhafu = pg_fetch_array($resfu)){
					echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
				}
				echo "</select></td></tr>";
				if(isset($tecidos) && $tecidos!=""){
					echo "<tr><td>SubTecidos:</td><td> <select name='subtecidos' onChange=document.goal_ins.submit()>";
					$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$tecidos." ORDER BY name_varchar";
					$resfu = pg_query($SQLfu);
					echo "<option value='".(isset($subtecidos)?$subtecidos:"")."'>".(isset($subtecidosname)?$subtecidosname:"")."</option>";
					echo "<option value=''></option>";
					while($linhafu = pg_fetch_array($resfu)){
						echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
					}
					echo "</select></td></tr>";
				}
				if(isset($subtecidos) && $subtecidos!=""){
					echo "<tr><td>SubTecidos1:</td><td> <select name='subtecidos1'>";
					$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$subtecidos." ORDER BY name_varchar";
					$resfu = pg_query($SQLfu);
					echo "<option value='".(isset($subtecidos1)?$subtecidos1:"")."'>".(isset($subtecidos1name)?$subtecidos1name:"")."</option>";
					echo "<option value=''></option>";
					while($linhafu = pg_fetch_array($resfu)){
						echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
					}
					echo "</select></td></tr>";
				}
			echo "</table>";
		echo "</td>";
	echo "</tr>";
echo "</table>";
//echo "</td>";
?>