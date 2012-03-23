<?php
echo "<td>";	
	echo "<table>";
		echo "<tr><td>Habilidade1: </td><td><select name='habilidade' onChange=document.goal_ins.submit()>";
		$SQLh = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 11 ORDER BY name_varchar";	
		$resh = pg_query($SQLh);
		echo "<option value='".(isset($habilidade)?$habilidade:"")."'>".(isset($habilidadename)?$habilidadename:"")."</option>";
		echo "<option value=''></option>";
		while($linhah = pg_fetch_array($resh)){
			$habilidadename = $linhah['name_varchar'];
			echo "<option value='".$linhah['id']."'>".$linhah['name_varchar']."</option>";
		}
		echo "</select></td></tr>";		
		if(isset($habilidade) && $habilidade!=""){
			$SQLhs = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$habilidade." ORDER BY name_varchar";
			$reshs = pg_query($SQLhs);
			if(pg_num_rows($reshs)>0){
				echo "<tr><td>SubHabilidade:</td><td> <select name='subhabilidade'>";
				echo "<option value='".(isset($subhabilidade)?$subhabilidade:"")."'>".(isset($subhabilidadename)?$subhabilidadename:"")."</option>";
				echo "<option value=''></option>";
				while($linhahs = pg_fetch_array($reshs)){
					echo "<option value='".$linhahs['id']."'>".$linhahs['name_varchar']."</option>";
				}
				echo "</select></td></tr>";
			}
		}
		echo "<tr><td>Habilidade2:</td><td> <select name='habilidade1'>";
		$SQLh = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 11 ORDER BY name_varchar";	
		$resh = pg_query($SQLh);
		echo "<option value='".(isset($habilidade1)?$habilidade1:"")."'>".(isset($habilidade1name)?$habilidade1name:"")."</option>";
		echo "<option value=''></option>";
		while($linhah = pg_fetch_array($resh)){
			echo "<option value='".$linhah['id']."'>".$linhah['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		
		echo "<tr><td>Condições: </td><td><select name='condicoes'>";
		$SQLh = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 429 ORDER BY name_varchar";	
		$resh = pg_query($SQLh);
		echo "<option value='".(isset($condicoes)?$condicoes:"")."'>".(isset($condicoesname)?$condicoesname:"")."</option>";
		echo "<option value=''></option>";
		while($linhah = pg_fetch_array($resh)){
			echo "<option value='".$linhah['id']."'>".$linhah['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		//-------------------------------------------------------------------------------------- MODALIDADE
		echo "<tr><td>Modalidade: </td><td><select name='modalidade' onChange=document.goal_ins.submit()>";
		$SQLt = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 20 ORDER BY name_varchar";
		$rest = pg_query($SQLt);
		echo "<option value='".(isset($modalidade)?$modalidade:"")."'>".(isset($modalidadename)?$modalidadename:"")."</option>";
		echo "<option value=''></option>";
		while($linhat = pg_fetch_array($rest)){
			echo "<option value='".$linhat['id']."'>".$linhat['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		if(isset($modalidade) && $modalidade!=""){
			echo "<tr><td>SubModalidade: </td><td><select name='submodalidade'>";
			$SQLt = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$modalidade." ORDER BY name_varchar";
			$rest = pg_query($SQLt);
			echo "<option value='".(isset($submodalidade)?$submodalidade:"")."'>".(isset($submodalidadename)?$submodalidadename:"")."</option>";
			echo "<option value=''></option>";
			while($linhat = pg_fetch_array($rest)){
				echo "<option value='".$linhat['id']."'>".$linhat['name_varchar']."</option>";
				$SQLst = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$linhat['id']." ORDER BY name_varchar";
				$resst = pg_query($SQLst);
				while($linhast = pg_fetch_array($resst)){
					echo "<option value='".$linhast['id']."'>->".$linhast['name_varchar']."</option>";
					$SQLst1 = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$linhast['id']." ORDER BY name_varchar";
					$resst1 = pg_query($SQLst1);
					while($linhast1 = pg_fetch_array($resst1)){
						echo "<option value='".$linhast1['id']."'>-->".$linhast1['name_varchar']."</option>";
					}
				}
			}
			echo "</select></td></tr>";
		}
	echo "</table>";
echo "</td>";
?>