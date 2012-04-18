<?php
//---__________________________________________________________________________________________________________ NEURO	
//-------------------------------------------------------------------------------------- Anatomia
echo "<td>";
	echo "<table>";
		echo "<tr><td colspan='2'>Anatomia:<br> <select name='anatomia' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 1545 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($anatomia)?$anatomia:"")."'>".(isset($anatomianame)?$anatomianame:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		
		if(isset($anatomia) && $anatomia!=""){
			echo "<tr><td>Sub:</td><td> <select name='subanatomia' onChange=document.goal_ins.submit()>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$anatomia." ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($subanatomia)?$subanatomia:"")."'>".(isset($subanatomianame)?$subanatomianame:"")."</option>";
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
		echo "<tr><td colspan='2'>Cognição:<br><select name='cognicao' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 1535 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($cognicao)?$cognicao:"")."'>".(isset($cognicaoname)?$cognicaoname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		
		if(isset($cognicao) && $cognicao!=""){
			echo "<tr><td>Sub:</td><td> <select name='subcognicao' onChange=document.goal_ins.submit()>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$cognicao." ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($subcognicao)?$subcognicao:"")."'>".(isset($subcognicaoname)?$subcognicaoname:"")."</option>";
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
		echo "<tr><td colspan='2'>Comportamento:<br><select name='comportamento' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 1552 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($comportamento)?$comportamento:"")."'>".(isset($comportamentoname)?$comportamentoname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		
		if(isset($comportamento) && $comportamento!=""){
			echo "<tr><td>Sub:</td><td> <select name='subcomportamento' onChange=document.goal_ins.submit()>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$comportamento." ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($subcomportamento)?$subcomportamento:"")."'>".(isset($subcomportamentoname)?$subcomportamentoname:"")."</option>";
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
		echo "<tr><td colspan='2'>Degeneração:<br><select name='degeneracao' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 1538 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($degeneracao)?$degeneracao:"")."'>".(isset($degeneracaoname)?$degeneracaoname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		
		if(isset($degeneracao) && $degeneracao!=""){
			echo "<tr><td>Sub:</td><td> <select name='subdegeneracao' onChange=document.goal_ins.submit()>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$degeneracao." ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($subdegeneracao)?$subdegeneracao:"")."'>".(isset($subdegeneracaoname)?$subdegeneracaoname:"")."</option>";
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
		echo "<tr><td colspan='2'>Desenvolvimento:<br><select name='desenvolvimentoneuro' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 1537 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($desenvolvimentoneuro)?$desenvolvimentoneuro:"")."'>".(isset($desenvolvimentoneuroname)?$desenvolvimentoneuroname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		
		if(isset($desenvolvimentoneuro) && $desenvolvimentoneuro!=""){
			echo "<tr><td>Sub:</td><td> <select name='subdesenvolvimento' onChange=document.goal_ins.submit()>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$desenvolvimentoneuro." ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($subdesenvolvimento)?$subdesenvolvimento:"")."'>".(isset($subdesenvolvimentoname)?$subdesenvolvimentoname:"")."</option>";
			echo "<option value=''></option>";
			while($linhafu = pg_fetch_array($resfu)){
				echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
		
		echo "<tr><td colspan='2'>Evolução:<br><select name='evolucao' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 1606 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($evolucao)?$evolucao:"")."'>".(isset($evolucaoname)?$evolucaoname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		
		if(isset($evolucao) && $evolucao!=""){
			echo "<tr><td>Sub:</td><td> <select name='subevolucao' onChange=document.goal_ins.submit()>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$evolucao." ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($subevolucao)?$subevolucao:"")."'>".(isset($subevolucaoname)?$subevolucaoname:"")."</option>";
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
		echo "<tr><td colspan='2'>Emoção:<br><select name='emocao' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 1544 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($emocao)?$emocao:"")."'>".(isset($emocaoname)?$emocaoname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		
		if(isset($emocao) && $emocao!=""){
			echo "<tr><td>Sub:</td><td> <select name='subemocao' onChange=document.goal_ins.submit()>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$emocao." ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($subemocao)?$subemocao:"")."'>".(isset($subemocaoname)?$subemocaoname:"")."</option>";
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
		echo "<tr><td colspan='2'>Fisiologia:<br><select name='fisiologia' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 1546 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($fisiologia)?$fisiologia:"")."'>".(isset($fisiologianame)?$fisiologianame:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		
		if(isset($fisiologia) && $fisiologia!=""){
			echo "<tr><td>Sub:</td><td> <select name='subfisiologia' onChange=document.goal_ins.submit()>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$fisiologia." ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($subfisiologia)?$subfisiologia:"")."'>".(isset($subfisiologianame)?$subfisiologianame:"")."</option>";
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
		echo "<tr><td colspan='2'>Histologia:<br><select name='histologia' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 1536 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($histologia)?$histologia:"")."'>".(isset($histologianame)?$histologianame:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		
		if(isset($histologia) && $histologia!=""){
			echo "<tr><td>Sub:</td><td> <select name='subhistologia' onChange=document.goal_ins.submit()>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$histologia." ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($subhistologia)?$subhistologia:"")."'>".(isset($subhistologianame)?$subhistologianame:"")."</option>";
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
		echo "<tr><td colspan='2'>Motor:<br><select name='motor' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 1533 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($motor)?$motor:"")."'>".(isset($motorname)?$motorname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		
		if(isset($motor) && $motor!=""){
			echo "<tr><td>Sub:</td><td> <select name='submotor' onChange=document.goal_ins.submit()>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$motor." ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($submotor)?$submotor:"")."'>".(isset($submotorname)?$submotorname:"")."</option>";
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
		echo "<tr><td colspan='2'>Sensorial:<br><select name='sensorial' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 1534 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($sensorial)?$sensorial:"")."'>".(isset($sensorialname)?$sensorialname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		
		if(isset($sensorial) && $sensorial!=""){
			echo "<tr><td>Sub:</td><td> <select name='subsensorial' onChange=document.goal_ins.submit()>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$sensorial." ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($subsensorial)?$subsensorial:"")."'>".(isset($subsensorialname)?$subsensorialname:"")."</option>";
			echo "<option value=''></option>";
			while($linhafu = pg_fetch_array($resfu)){
				echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
	echo "</table>";
echo "</td>";
?>