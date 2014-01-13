<?php
//-------------------------------------------------------------------------------------- GRANDEZAS
echo "<td>";
	echo "<table>";
		echo "<tr><td>Grandezas:<br> <select name='grandeza' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 192 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($grandeza)?$grandeza:"")."'>".(isset($grandezaname)?$grandezaname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		echo "<tr><td>Grandezas1:<br> <select name='grandeza1' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 192 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($grandeza1)?$grandeza1:"")."'>".(isset($grandeza1name)?$grandeza1name:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		//-------------------------------------------------------------------------------------- SUB GRANDEZA
		if(isset($grandeza) && $grandeza==206){
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 459 ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<tr><td>Dimensão:<br> <select name='dimensao'>";
			echo "<option value='".(isset($dimensao)?$dimensao:"")."'>".(isset($dimensaoname)?$dimensaoname:"")."</option>";
			echo "<option value=''></option>";
			while($linhafu = pg_fetch_array($resfu)){
				echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
		if(isset($grandeza) && $grandeza!=""){
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".($grandeza==206?456:$grandeza)." ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			if(pg_num_rows($resfu)>0){
				echo "<tr><td>Medida:<br> <select name='medida'>";
				echo "<option value='".(isset($medida)?$medida:"")."'>".(isset($medidaname)?$medidaname:"")."</option>";
				echo "<option value=''></option>";
				while($linhafu = pg_fetch_array($resfu)){
					echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
				}
				echo "</select></td></tr>";
			}
		}
	echo "</table>";
echo "</td>";

//-------------------------------------------------------------------------------------- NUMEROS
echo "<td>";
	echo "<table>";
		echo "<tr><td>Números:<br> <select name='numero' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 195 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($numero)?$numero:"")."'>".(isset($numeroname)?$numeroname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		//-------------------------------------------------------------------------------------- TAMANHO
		echo "<table><tr><td>Tamanho:<br> <select name='tamanho'>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 268 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($tamanho)?$tamanho:"")."'>".(isset($tamanhoname)?$tamanhoname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		//-------------------------------------------------------------------------------------- OPERACOES
		echo "<tr><td>Operações:<br> <select name='operacoes' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 197 AND id <> 257 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($operacoes)?$operacoes:"")."'>".(isset($operacoesname)?$operacoesname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		
		echo "<tr><td>Operações1:<br> <select name='operacoes1'>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 197 AND id <> 257 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($operacoes1)?$operacoes1:"")."'>".(isset($operacoes1name)?$operacoes1name:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		
		if(isset($operacoes) && $operacoes==263){
			echo "<tr><td>Multiplicação:<br> <select name='multiplicacao'>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 263 ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($multiplicacao)?$multiplicacao:"")."'>".(isset($multiplicacaoname)?$multiplicacaoname:"")."</option>";
			echo "<option value=''></option>";
			while($linhafu = pg_fetch_array($resfu)){
				echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
		if(isset($operacoes) && $operacoes!=""){
			echo "<tr><td>Cálculo:<br> <select name='calculo'>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 257 ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($calculo)?$calculo:"")."'>".(isset($calculoname)?$calculoname:"")."</option>";
			echo "<option value=''></option>";
			while($linhafu = pg_fetch_array($resfu)){
				echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
	echo "</table>";
echo "</td>";
//-------------------------------------------------------------------------------------- PROBLEMAS
echo "<td>";
	echo "<table>";
		echo "<tr><td>Problemas:<br> <select name='problemas' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE ((father_id = 196) AND (id <> 252) AND (id <> 395)) ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($problemas)?$problemas:"")."'>".(isset($problemasname)?$problemasname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		if(isset($problemas) && $problemas!=""){
			echo "<tr><td>QuantOperacoes:<br> <select name='quantoperacoes'>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 252 ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($quantoperacoes)?$quantoperacoes:"")."'>".(isset($quantoperacoesname)?$quantoperacoesname:"")."</option>";
			echo "<option value=''></option>";
			while($linhafu = pg_fetch_array($resfu)){
				echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
			echo "<tr><td>Situação:<br> <select name='situacao' onChange=document.goal_ins.submit()>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 395 ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($situacao)?$situacao:"")."'>".(isset($situacaoname)?$situacaoname:"")."</option>";
			echo "<option value=''></option>";
			while($linhafu = pg_fetch_array($resfu)){
				echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
			if(isset($situacao) && $situacao!=""){
				echo "<tr><td>SubSituação:<br> <select name='subsituacao'>";
				$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$situacao." ORDER BY name_varchar";
				$resfu = pg_query($SQLfu);
				echo "<option value='".(isset($subsituacao)?$subsituacao:"")."'>".(isset($subsituacaoname)?$subsituacaoname:"")."</option>";
				echo "<option value=''></option>";
				while($linhafu = pg_fetch_array($resfu)){
					echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
				}
				echo "</select></td></tr>";
			}
		}
	echo "</table>";
echo "</td>";

//-------------------------------------------------------------------------------------- GEOMETRIA
echo "<td>";
	echo "<table>";
		echo "<tr><td>Geometria:<br> <select name='geometria' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 194 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($geometria)?$geometria:"")."'>".(isset($geometrianame)?$geometrianame:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		//-------------------------------------------------------------------------------------- SUB GEOMETRIA
		if(isset($geometria) && $geometria!=""){
			echo "<tr><td>Partes:<br> <select name='partes'>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".($geometria==224?438:441)." ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($partes)?$partes:"")."'>".(isset($partesname)?$partesname:"")."</option>";
			echo "<option value=''></option>";
			while($linhafu = pg_fetch_array($resfu)){
				echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
		if(isset($geometria) && $geometria!=""){
			echo "<tr><td>Tipos:<br> <select name='tipos' onChange=document.goal_ins.submit()>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".($geometria==224?445:446)." ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($tipos)?$tipos:"")."'>".(isset($tiposname)?$tiposname:"")."</option>";
			echo "<option value=''></option>";
			while($linhafu = pg_fetch_array($resfu)){
				echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
		if(isset($tipos) && $tipos!=""){
			echo "<tr><td>SubTipos:<br> <select name='subtipos'>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$tipos." ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($subtipos)?$subtipos:"")."'>".(isset($subtiposname)?$subtiposname:"")."</option>";
			echo "<option value=''></option>";
			while($linhafu = pg_fetch_array($resfu)){
				echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
		
		echo "<tr><td>Plano Cartesiano:<br> <select name='cartesiano'>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 452 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($cartesiano)?$cartesiano:"")."'>".(isset($cartesianoname)?$cartesianoname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		
	echo "</table>";
echo "</td>";

//-------------------------------------------------------------------------------------- ALGEBRA
echo "<td>";
	echo "<table>";
		echo "<tr><td>Algebra:<br> <select name='algebra' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 189 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($algebra)?$algebra:"")."'>".(isset($algebraname)?$algebraname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		//-------------------------------------------------------------------------------------- SUB ALGEBRA
		if(isset($algebra) && $algebra!=""){
			echo "<tr><td>SubAlgebra:<br> <select name='subalgebra'>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$algebra." ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($subalgebra)?$subalgebra:"")."'>".(isset($subalgebraname)?$subalgebraname:"")."</option>";
			echo "<option value=''></option>";
			while($linhafu = pg_fetch_array($resfu)){
				echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
		//-------------------------------------------------------------------------------------- PLANILHAS
		echo "<tr><td>Planilhas:<br> <select name='planilha'>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 191 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($planilha)?$planilha:"")."'>".(isset($planilhaname)?$planilhaname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
	echo "</table>";
echo "</td>";
?>