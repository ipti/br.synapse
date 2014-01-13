<?php
//-------------------------------------------------------------------------------------- AMBIENTE 1
echo "<td>";
	echo "<table>";
		echo "<tr><td>Ambiente1:</td><td> <select name='ambiente1' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 315 AND id <> 319 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($ambiente1)?$ambiente1:"")."'>".(isset($ambiente1name)?$ambiente1name:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		
		if(isset($ambiente1) && $ambiente1!=""){
			echo "<tr><td>Subambiente:</td><td> <select name='subambiente' onChange=document.goal_ins.submit()>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$ambiente1." ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($subambiente)?$subambiente:"")."'>".(isset($subambientename)?$subambientename:"")."</option>";
			echo "<option value=''></option>";
			while($linhafu = pg_fetch_array($resfu)){
				echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
		if(isset($subambiente) && $subambiente!=""){
			echo "<tr><td>Subambiente1:</td><td> <select name='subambiente1'>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$subambiente." ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($subambiente1)?$subambiente1:"")."'>".(isset($subambiente1name)?$subambiente1name:"")."</option>";
			echo "<option value=''></option>";
			while($linhafu = pg_fetch_array($resfu)){
				echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
		//-------------------------------------------------------------------------------------- AMBIENTE 2
		echo "<tr><td>Ambiente2:</td><td> <select name='ambiente2'>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 315 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($ambiente2)?$ambiente2:"")."'>".(isset($ambiente2name)?$ambiente2name:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		
		echo "<tr><td>TipoAmbiente:</td><td> <select name='tipoambiente'>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 319 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($tipoambiente)?$tipoambiente:"")."'>".(isset($tipoambientename)?$tipoambientename:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		
		echo "<tr><td>Ecologia:</td><td> <select name='ecologia' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 362 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($ecologia)?$ecologia:"")."'>".(isset($ecologianame)?$ecologianame:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		
		if(isset($ecologia) && $ecologia!=""){
			echo "<tr><td>SubEcologia:</td><td> <select name='subecologia' onChange=document.goal_ins.submit()>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$ecologia." ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($subecologia)?$subecologia:"")."'>".(isset($subecologianame)?$subecologianame:"")."</option>";
			echo "<option value=''></option>";
			while($linhafu = pg_fetch_array($resfu)){
				echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
		
		if(isset($ecologia) && $ecologia!=""){
			echo "<tr><td>SubEcologiaA:</td><td> <select name='subecologia1a' onChange=document.goal_ins.submit()>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$ecologia." ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($subecologia1a)?$subecologia1a:"")."'>".(isset($subecologia1aname)?$subecologia1aname:"")."</option>";
			echo "<option value=''></option>";
			while($linhafu = pg_fetch_array($resfu)){
				echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
		
		if(isset($subecologia) && $subecologia!=""){
			echo "<tr><td>SubEcologia1:</td><td> <select name='subecologia1' onChange=document.goal_ins.submit()>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$subecologia." ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($subecologia1)?$subecologia1:"")."'>".(isset($subecologia1name)?$subecologia1name:"")."</option>";
			echo "<option value=''></option>";
			while($linhafu = pg_fetch_array($resfu)){
				echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
		
		if(isset($subecologia1) && $subecologia1!=""){
			echo "<tr><td>SubEcologia2:</td><td> <select name='subecologia2' onChange=document.goal_ins.submit()>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$subecologia1." ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($subecologia2)?$subecologia2:"")."'>".(isset($subecologia2name)?$subecologia2name:"")."</option>";
			echo "<option value=''></option>";
			while($linhafu = pg_fetch_array($resfu)){
				echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
		if(isset($subecologia2) && $subecologia2!=""){
			echo "<tr><td>SubEcologia3:</td><td> <select name='subecologia3'>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$subecologia2." ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($subecologia3)?$subecologia3:"")."'>".(isset($subecologia3name)?$subecologia3name:"")."</option>";
			echo "<option value=''></option>";
			while($linhafu = pg_fetch_array($resfu)){
				echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}		
	echo "</table>";
echo "</td>";
//-------------------------------------------------------------------------------------- TIPO AMBIENTE
echo "<td>";
	echo "<table>";
		echo "<tr valign='top'><td>Seres:</td><td> <select name='seres' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 317 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($seres)?$seres:"")."'>".(isset($seresname)?$seresname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		
		echo "<tr valign='top'><td>Seres1:</td><td> <select name='seres1'>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 317 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($seres1)?$seres1:"")."'>".(isset($seres1name)?$seres1name:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";	

		echo "<tr><td>Abióticos:</td><td> <select name='abioticos' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 363 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($abioticos)?$abioticos:"")."'>".(isset($abioticosname)?$abioticosname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";

		if(isset($abioticos) && $abioticos!=""){
			echo "<tr><td>SubAbióticos:</td><td> <select name='subabioticos' onChange=document.goal_ins.submit()>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$abioticos." ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($subabioticos)?$subabioticos:"")."'>".(isset($subabioticosname)?$subabioticosname:"")."</option>";
			echo "<option value=''></option>";
			while($linhafu = pg_fetch_array($resfu)){
				echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
	
		if(isset($subabioticos) && $subabioticos!=""){
			echo "<tr><td>SubAbióticos1:</td><td> <select name='subabioticos1'>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$subabioticos." ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($subabioticos1)?$subabioticos1:"")."'>".(isset($subabioticos1name)?$subabioticos1name:"")."</option>";
			echo "<option value=''></option>";
			while($linhafu = pg_fetch_array($resfu)){
				echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		
			echo "<tr><td>SubAbióticos1a:</td><td> <select name='subabioticos1a'>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$subabioticos." ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($subabioticos1a)?$subabioticos1a:"")."'>".(isset($subabioticos1aname)?$subabioticos1aname:"")."</option>";
			echo "<option value=''></option>";
			while($linhafu = pg_fetch_array($resfu)){
				echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
		
		echo "<tr><td>Bióticos:</td><td> <select name='bioticos'>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 328 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($bioticos)?$bioticos:"")."'>".(isset($bioticosname)?$bioticosname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
	
		if(isset($seres) && $seres==328){
			echo "<tr><td>Taxonomia:</td><td> <select name='taxonomia' onChange=document.goal_ins.submit()>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 594 ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($taxonomia)?$taxonomia:"")."'>".(isset($taxonomianame)?$taxonomianame:"")."</option>";
			echo "<option value=''></option>";
			while($linhafu = pg_fetch_array($resfu)){
				echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
			if(isset($taxonomia) && $taxonomia!=""){
				echo "<tr><td>Subtaxonomia:</td><td> <select name='subtaxonomia' onChange=document.goal_ins.submit()>";
				$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$taxonomia." ORDER BY name_varchar";
				$resfu = pg_query($SQLfu);
				echo "<option value='".(isset($subtaxonomia)?$subtaxonomia:"")."'>".(isset($subtaxonomianame)?$subtaxonomianame:"")."</option>";
				echo "<option value=''></option>";
				while($linhafu = pg_fetch_array($resfu)){
					echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
				}
				echo "</select></td></tr>";
			}
			
			if(isset($taxonomia) && $taxonomia==831){
				echo "<tr><td>Sintomas:</td><td> <select name='sintomas'>";
				$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 880 ORDER BY name_varchar";
				$resfu = pg_query($SQLfu);
				echo "<option value='".(isset($sintomas)?$sintomas:"")."'>".(isset($sintomasname)?$sintomasname:"")."</option>";
				echo "<option value=''></option>";
				while($linhafu = pg_fetch_array($resfu)){
					echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
				}
				echo "</select></td></tr>";
				echo "<tr><td>Prevenção:</td><td> <select name='prevencao'>";
				$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 870 ORDER BY name_varchar";
				$resfu = pg_query($SQLfu);
				echo "<option value='".(isset($prevencao)?$prevencao:"")."'>".(isset($prevencaoname)?$prevencaoname:"")."</option>";
				echo "<option value=''></option>";
				while($linhafu = pg_fetch_array($resfu)){
					echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
				}
				echo "</select></td></tr>";
				echo "<tr><td>Trasnmissão:</td><td> <select name='transmissao'>";
				$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 864 ORDER BY name_varchar";
				$resfu = pg_query($SQLfu);
				echo "<option value='".(isset($transmissao)?$transmissao:"")."'>".(isset($transmissaoname)?$transmissaoname:"")."</option>";
				echo "<option value=''></option>";
				while($linhafu = pg_fetch_array($resfu)){
					echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
				}
				echo "</select></td></tr>";
			}
		
			if(isset($subtaxonomia) && $subtaxonomia!=""){
				echo "<tr><td>Subtaxonomia1:</td><td> <select name='subtaxonomia1' onChange=document.goal_ins.submit()>";
				$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$subtaxonomia." ORDER BY name_varchar";
				$resfu = pg_query($SQLfu);
				echo "<option value='".(isset($subtaxonomia1)?$subtaxonomia1:"")."'>".(isset($subtaxonomia1name)?$subtaxonomia1name:"")."</option>";
				echo "<option value=''></option>";
				while($linhafu = pg_fetch_array($resfu)){
					echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
				}
				echo "</select></td></tr>";
			}
			if(isset($subtaxonomia1) && $subtaxonomia1!=""){
				echo "<tr><td>Subtaxonomia2:</td><td> <select name='subtaxonomia2' onChange=document.goal_ins.submit()>";
				$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$subtaxonomia1." ORDER BY name_varchar";
				$resfu = pg_query($SQLfu);
				echo "<option value='".(isset($subtaxonomia2)?$subtaxonomia2:"")."'>".(isset($subtaxonomia2name)?$subtaxonomia2name:"")."</option>";
				echo "<option value=''></option>";
				while($linhafu = pg_fetch_array($resfu)){
					echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
				}
				echo "</select></td></tr>";
			}
			if(isset($subtaxonomia2) && $subtaxonomia2!=""){
				echo "<tr><td>Subtaxonomia3:</td><td> <select name='subtaxonomia3'>";
				$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$subtaxonomia2." ORDER BY name_varchar";
				$resfu = pg_query($SQLfu);
				echo "<option value='".(isset($subtaxonomia3)?$subtaxonomia3:"")."'>".(isset($subtaxonomia3name)?$subtaxonomia3name:"")."</option>";
				echo "<option value=''></option>";
				while($linhafu = pg_fetch_array($resfu)){
					echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
				}
				echo "</select></td></tr>";
			}
			echo "<tr><td>Taxonomia1:</td><td> <select name='taxonomia1' onChange=document.goal_ins.submit()>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 594 ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($taxonomia1)?$taxonomia1:"")."'>".(isset($taxonomia1name)?$taxonomia1name:"")."</option>";
			echo "<option value=''></option>";
			while($linhafu = pg_fetch_array($resfu)){
				echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
			if(isset($taxonomia1) && $taxonomia1!=""){
				echo "<tr><td>Sub1taxonomia:</td><td> <select name='sub1taxonomia' onChange=document.goal_ins.submit()>";
				$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$taxonomia1." ORDER BY name_varchar";
				$resfu = pg_query($SQLfu);
				echo "<option value='".(isset($sub1taxonomia)?$sub1taxonomia:"")."'>".(isset($sub1taxonomianame)?$sub1taxonomianame:"")."</option>";
				echo "<option value=''></option>";
				while($linhafu = pg_fetch_array($resfu)){
					echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
				}
				echo "</select></td></tr>";
			}
			if(isset($sub1taxonomia) && $sub1taxonomia!=""){
				echo "<tr><td>Sub1taxonomia1:</td><td> <select name='sub1taxonomia1' onChange=document.goal_ins.submit()>";
				$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$sub1taxonomia." ORDER BY name_varchar";
				$resfu = pg_query($SQLfu);
				echo "<option value='".(isset($sub1taxonomia1)?$sub1taxonomia1:"")."'>".(isset($sub1taxonomia1name)?$sub1taxonomia1name:"")."</option>";
				echo "<option value=''></option>";
				while($linhafu = pg_fetch_array($resfu)){
					echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
				}
				echo "</select></td></tr>";
			}
			if(isset($sub1taxonomia1) && $sub1taxonomia1!=""){
				echo "<tr><td>Sub1taxonomia2:</td><td> <select name='sub1taxonomia2' onChange=document.goal_ins.submit()>";
				$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$sub1taxonomia1." ORDER BY name_varchar";
				$resfu = pg_query($SQLfu);
				echo "<option value='".(isset($sub1taxonomia2)?$sub1taxonomia2:"")."'>".(isset($sub1taxonomia2name)?$sub1taxonomia2name:"")."</option>";
				echo "<option value=''></option>";
				while($linhafu = pg_fetch_array($resfu)){
					echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
				}
				echo "</select></td></tr>";
			}
			if(isset($sub1taxonomia2) && $sub1taxonomia2!=""){
				echo "<tr><td>Sub1taxonomia3:</td><td> <select name='sub1taxonomia3'>";
				$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$sub1taxonomia2." ORDER BY name_varchar";
				$resfu = pg_query($SQLfu);
				echo "<option value='".(isset($sub1taxonomia3)?$sub1taxonomia3:"")."'>".(isset($sub1taxonomia3name)?$sub1taxonomia3name:"")."</option>";
				echo "<option value=''></option>";
				while($linhafu = pg_fetch_array($resfu)){
					echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
				}
				echo "</select></td></tr>";
			}
		}
	echo "</table>";
echo "</td>";

echo "<td>";
	echo "<table>";
		echo "<tr valign='top'><td>Alimentação:</td><td> <select name='alimentacao'>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 339 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($alimentacao)?$alimentacao:"")."'>".(isset($alimentacaoname)?$alimentacaoname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		
		echo "<tr valign='top'><td>Alimentação1:</td><td> <select name='alimentacao1'>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 339 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($alimentacao1)?$alimentacao1:"")."'>".(isset($alimentacao1name)?$alimentacao1name:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		
		echo "<tr><td>Reprodução:</td><td> <select name='reproducao' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 769 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($reproducao)?$reproducao:"")."'>".(isset($reproducaoname)?$reproducaoname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		if(isset($reproducao) && $reproducao!=""){
			echo "<tr><td>SubReprodução:</td><td> <select name='subreproducao'>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$reproducao." ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($subreproducao)?$subreproducao:"")."'>".(isset($subreproducaoname)?$subreproducaoname:"")."</option>";
			echo "<option value=''></option>";
			while($linhafu = pg_fetch_array($resfu)){
				echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
		echo "<tr><td>Locomoção:</td><td> <select name='locomocao'>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 338 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($locomocao)?$locomocao:"")."'>".(isset($locomocaoname)?$locomocaoname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		echo "<tr><td>Desenvolvimento:</td><td> <select name='desenvolvimento'>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 605 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($desenvolvimento)?$desenvolvimento:"")."'>".(isset($desenvolvimentoname)?$desenvolvimentoname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		echo "<tr><td>Temperatura:</td><td> <select name='temperatura'>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 554 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($temperatura)?$temperatura:"")."'>".(isset($temperaturaname)?$temperaturaname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		
		echo "<tr><td>Esqueleto:</td><td> <select name='esqueleto'>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 333 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($esqueleto)?$esqueleto:"")."'>".(isset($esqueletoname)?$esqueletoname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		
		echo "<tr><td>Respiração:</td><td> <select name='respiracao'>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 549 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($respiracao)?$respiracao:"")."'>".(isset($respiracaoname)?$respiracaoname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";		
	echo "</table>";
echo "</td>";
?>