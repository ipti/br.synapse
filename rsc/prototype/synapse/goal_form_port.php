<?php
//-------------------------------------------------------------------------------------- DIMENSAO
echo "<td>";
	echo "<table>";
		echo "<tr><td>Dimensão:</td><td> <select name='dimensao' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.id, activitycontent.name_varchar 
				  FROM activitycontent 
				  WHERE father_id = 1 
				  ORDER BY grade";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($dimensao)?$dimensao:"")."'>".(isset($dimensaoname)?$dimensaoname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		
		echo "<tr><td>Dimensão1:</td><td> <select name='dimensao1' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 1 ORDER BY grade";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($dimensao1)?$dimensao1:"")."'>".(isset($dimensao1name)?$dimensao1name:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		echo "<tr><td>Dimensão2: </td><td><select name='dimensao2' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 1 ORDER BY grade";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($dimensao2)?$dimensao2:"")."'>".(isset($dimensao2name)?$dimensao2name:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		echo "<tr><td>Dimensão3: </td><td><select name='dimensao3' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 1 ORDER BY grade";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($dimensao3)?$dimensao3:"")."'>".(isset($dimensao3name)?$dimensao3name:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr><tr><td>";
		echo "Dimensão4: </td><td><select name='dimensao4' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 1 ORDER BY grade";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($dimensao4)?$dimensao4:"")."'>".(isset($dimensao4name)?$dimensao4name:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		//-------------------------------------------------------------------------------------- //DIMENSÃO
	echo "</table>";
echo "</td>";

echo "<td>";
	echo "<table>";
			//-------------------------------------------------------------------------------------- WORD CLASS
		if((isset($dimensao) && ($dimensao==5 || $dimensao==6)) || (isset($dimensao1) && ($dimensao1==5 || $dimensao1==6))  || (isset($dimensao2) && ($dimensao2==5 || $dimensao2==6))  || (isset($dimensao3) && ($dimensao3==5 || $dimensao3==6))  || (isset($dimensao4) && ($dimensao4==5 || $dimensao4==6))){//-----PALAVRA OU LOCUÇÃO
			echo "<tr><td>Classe: </td><td><select name='wordclass' onChange=document.goal_ins.submit()>";
			$SQL = "SELECT * FROM activitycontent WHERE father_id = 23 ORDER BY name_varchar";
			$res = pg_query($SQL);
			echo "<option value='".(isset($wordclass)?$wordclass:"")."'>".(isset($wordclassname)?$wordclassname:"")."</option>";
			echo "<option value=''></option>";
			while($linha = pg_fetch_array($res)){
				echo "<option value='".$linha['id']."'>".$linha['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
		//-------------------------------------------------------------------------------------- SUB WORD CLASS
		if((isset($wordclass) && $wordclass!="") && ((isset($dimensao) && ($dimensao==5 || $dimensao==6)) || (isset($dimensao1) && ($dimensao1==5 || $dimensao1==6))  || (isset($dimensao2) && ($dimensao2==5 || $dimensao2==6))  || (isset($dimensao3) && ($dimensao3==5 || $dimensao3==6))  || (isset($dimensao4) && ($dimensao4==5 || $dimensao4==6)))){
			$SQL = "SELECT * FROM activitycontent WHERE father_id = ".$wordclass." ORDER BY name_varchar";
			$res = pg_query($SQL);
			if(pg_num_rows($res)>0){
				echo "<tr><td>SubClasse: </td><td><select name='subwordclass' onChange=document.goal_ins.submit()>";
				echo "<option value='".(isset($subwordclass)?$subwordclass:"")."'>".(isset($subwordclassname)?$subwordclassname:"")."</option>";
				echo "<option value=''></option>";
				while($linha = pg_fetch_array($res)){
					echo "<option value='".$linha['id']."'>".$linha['name_varchar']."</option>";
				}
				echo "</select></td></tr>";
			}
		}
	//-------------------------------------------------------------------------------------- TIPO DE ORAÇÃO
		if((isset($dimensao) && $dimensao==7) || (isset($dimensao1) && $dimensao1==7) || (isset($dimensao2) && $dimensao2==7) || (isset($dimensao3) && $dimensao3==7) || (isset($dimensao4) && $dimensao4==7)){//-----ORAÇÃO
			$SQL = "SELECT * FROM activitycontent WHERE father_id = 314 ORDER BY name_varchar";
			$res = pg_query($SQL);
			echo "<tr><td>Tipo: </td><td><select name='oracaotipo' onChange=document.goal_ins.submit()>";
			echo "<option value='".(isset($oracaotipo)?$oracaotipo:"")."'>".(isset($oracaotiponame)?$oracaotiponame:"")."</option>";
			echo "<option value=''></option>";
			while($linha = pg_fetch_array($res)){
				echo "<option value='".$linha['id']."'>".$linha['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
		//-------------------------------------------------------------------------------------- FUNÇÃO DA ORAÇÃO
		if((isset($dimensao) && $dimensao==7) || (isset($dimensao1) && $dimensao1==7) || (isset($dimensao2) && $dimensao2==7) || (isset($dimensao3) && $dimensao3==7) || (isset($dimensao4) && $dimensao4==7)){//-----ORAÇÃO
			$SQL = "SELECT * FROM activitycontent WHERE father_id = 307 ORDER BY name_varchar";
			$res = pg_query($SQL);
			echo "<tr><td>Função: </td><td><select name='oracaofuncao' onChange=document.goal_ins.submit()>";
			echo "<option value='".(isset($oracaofuncao)?$oracaofuncao:"")."'>".(isset($oracaofuncaoname)?$oracaofuncaoname:"")."</option>";
			echo "<option value=''></option>";
			while($linha = pg_fetch_array($res)){
				echo "<option value='".$linha['id']."'>".$linha['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
		//-------------------------------------------------------------------------------------- QUANTIDADE DE ORAÇÕES
		if((isset($dimensao) && $dimensao==8) || (isset($dimensao1) && $dimensao1==8) || (isset($dimensao2) && $dimensao2==8) || (isset($dimensao3) && $dimensao3==8) || (isset($dimensao4) && $dimensao4==8)){//-----ORAÇÃO
			$SQL = "SELECT * FROM activitycontent WHERE father_id = 8 ORDER BY name_varchar";
			$res = pg_query($SQL);
			echo "<tr><td>Orações: </td><td><select name='quantoracao' onChange=document.goal_ins.submit()>";
			echo "<option value='".(isset($quantoracao)?$quantoracao:"")."'>".(isset($quantoracaoname)?$quantoracaoname:"")."</option>";
			echo "<option value=''></option>";
			while($linha = pg_fetch_array($res)){
				echo "<option value='".$linha['id']."'>".$linha['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
		//-------------------------------------------------------------------------------------- FUNÇÃO SINTÁTICA
		if((isset($dimensao) && ($dimensao==7 || $dimensao==8)) || (isset($dimensao1) && ($dimensao1==7 || $dimensao1==8)) || (isset($dimensao2) && ($dimensao2==7 || $dimensao2==8))  || (isset($dimensao3) && ($dimensao3==7 || $dimensao3==8))  || (isset($dimensao4) && ($dimensao4==7 || $dimensao4==8))){//-----ORAÇÃO OU FRASE
			echo "<tr><td>Sintaxe: </td><td><select name='sintaxfunction' onChange=document.goal_ins.submit()>";
			$SQL = "SELECT * FROM activitycontent WHERE father_id = 34 ORDER BY name_varchar";
			$res = pg_query($SQL);
			echo "<option value='".(isset($sintaxfunction)?$sintaxfunction:"")."'>".(isset($sintaxfunctionname)?$sintaxfunctionname:"")."</option>";
			echo "<option value=''></option>";
			while($linha = pg_fetch_array($res)){
				echo "<option value='".$linha['id']."'>".$linha['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
		//-------------------------------------------------------------------------------------- SUB FUNÇÃO SINTÁTICA
		if((isset($sintaxfunction) && $sintaxfunction!="") && ((isset($dimensao) && ($dimensao==7 || $dimensao==8)) || (isset($dimensao1) && ($dimensao1==7 || $dimensao1==8))  || (isset($dimensao2) && ($dimensao2==7 || $dimensao2==8))  || (isset($dimensao3) && ($dimensao3==7 || $dimensao3==8))  || (isset($dimensao4) && ($dimensao4==7 || $dimensao4==8)))){
			$SQL = "SELECT * FROM activitycontent WHERE father_id = ".$sintaxfunction." ORDER BY name_varchar";
			$res = pg_query($SQL);
			if(pg_num_rows($res)>0){
				echo "<tr><td>SubSintaxe: </td><td><select name='subsintaxfunction' onChange=document.goal_ins.submit()>";
				echo "<option value='".(isset($subsintaxfunction)?$subsintaxfunction:"")."'>".(isset($subsintaxfunctionname)?$subintaxfunctionname:"")."</option>";
				echo "<option value=''></option>";
				while($linha = pg_fetch_array($res)){
					echo "<option value='".$linha['id']."'>".$linha['name_varchar']."</option>";
				}
				echo "</select></td></tr>";
			}
		}
		//-------------------------------------------------------------------------------------- RELAÇÃO SEMANTICA
		if((isset($dimensao) && ($dimensao==8 || $dimensao==9 || $dimensao==10)) || (isset($dimensao1) && ($dimensao1==8 || $dimensao1==9 || $dimensao1==10)) || (isset($dimensao2) && ($dimensao2==8 || $dimensao2==9 || $dimensao2==10))  || (isset($dimensao3) && ($dimensao3==8 || $dimensao3==9 || $dimensao3==10))  || (isset($dimensao4) && ($dimensao4==8 || $dimensao4==9 || $dimensao4==10))){//-----ORAÇÃO OU FRASE
			echo "<tr><td>Relação: </td><td><select name='semanticrelation' onChange=document.goal_ins.submit()>";
			$SQL = "SELECT * FROM activitycontent WHERE father_id = 48 ORDER BY name_varchar";
			$res = pg_query($SQL);
			echo "<option value='".(isset($semanticrelation)?$semanticrelation:"")."'>".(isset($semanticrelationname)?$semanticrelationname:"")."</option>";
			echo "<option value=''></option>";
			while($linha = pg_fetch_array($res)){
				echo "<option value='".$linha['id']."'>".$linha['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
		//-------------------------------------------------------------------------------------- SUB RELAÇÃO SEMANTICA
		if((isset($semanticrelation) && $semanticrelation!="") && ((isset($dimensao) && ($dimensao==8 || $dimensao==9 || $dimensao==10)) || (isset($dimensao1) && ($dimensao1==8 || $dimensao1==9 || $dimensao1==10)) || (isset($dimensao2) && ($dimensao2==8 || $dimensao2==9 || $dimensao2==10))  || (isset($dimensao3) && ($dimensao3==8 || $dimensao3==9 || $dimensao3==10))  || (isset($dimensao4) && ($dimensao4==8 || $dimensao4==9 || $dimensao4==10)))){
			$SQL = "SELECT * FROM activitycontent WHERE father_id = ".$semanticrelation." ORDER BY name_varchar";
			$res = pg_query($SQL);
			if(pg_num_rows($res)>0){
				echo "<tr><td>SubRelação: </td><td><select name='subsemanticrelation' onChange=document.goal_ins.submit()>";
				echo "<option value='".(isset($subsemanticrelation)?$subsemanticrelation:"")."'>".(isset($subsemanticrelationname)?$subsemanticrelationname:"")."</option>";
				echo "<option value=''></option>";
				while($linha = pg_fetch_array($res)){
					echo "<option value='".$linha['id']."'>".$linha['name_varchar']."</option>";
				}
				echo "</select></td></tr>";
			}
		}
		//-------------------------------------------------------------------------------------- SUB1 RELAÇÃO SEMANTICA
		if((isset($semanticrelation) && $semanticrelation!="") && (isset($subsemanticrelation) && $subsemanticrelation!="") && ((isset($dimensao) && ($dimensao==8 || $dimensao==9 || $dimensao==10)) || (isset($dimensao1) && ($dimensao1==8 || $dimensao1==9 || $dimensao1==10)) || (isset($dimensao2) && ($dimensao2==8 || $dimensao2==9 || $dimensao2==10))  || (isset($dimensao3) && ($dimensao3==8 || $dimensao3==9 || $dimensao3==10))  || (isset($dimensao4) && ($dimensao4==8 || $dimensao4==9 || $dimensao4==10)))){
			$SQL = "SELECT * FROM activitycontent WHERE father_id = ".$subsemanticrelation." ORDER BY name_varchar";
			$res = pg_query($SQL);
			if(pg_num_rows($res)>0){
				echo "<tr><td>SubRelação1: </td><td><select name='sub1semanticrelation' onChange=document.goal_ins.submit()>";
				echo "<option value='".(isset($sub1semanticrelation)?$sub1semanticrelation:"")."'>".(isset($sub1semanticrelationname)?$sub1semanticrelationname:"")."</option>";
				echo "<option value=''></option>";
				while($linha = pg_fetch_array($res)){
					echo "<option value='".$linha['id']."'>".$linha['name_varchar']."</option>";
				}
				echo "</select></td></tr>";
			}
		}
		//-------------------------------------------------------------------------------------- FIGURA LINGUAGEM
		if((isset($dimensao) && ($dimensao==7 || $dimensao==8 || $dimensao==9 || $dimensao==10)) || (isset($dimensao1) && ($dimensao==7 || $dimensao1==8 || $dimensao1==9 || $dimensao1==10)) || (isset($dimensao2) && ($dimensao==7 || $dimensao2==8 || $dimensao2==9 || $dimensao2==10))  || (isset($dimensao3) && ($dimensao==7 || $dimensao3==8 || $dimensao3==9 || $dimensao3==10))  || (isset($dimensao4) && ($dimensao==7 || $dimensao4==8 || $dimensao4==9 || $dimensao4==10))){
			$SQL = "SELECT * FROM activitycontent WHERE father_id = 94 ORDER BY name_varchar";
			$res = pg_query($SQL);
			if(pg_num_rows($res)>0){
				echo "<tr><td>Figuras: </td><td><select name='figuralinguagem' onChange=document.goal_ins.submit()>";
				echo "<option value='".(isset($figuralinguagem)?$figuralinguagem:"")."'>".(isset($figuralinguagemname)?$figuralinguagemname:"")."</option>";
				echo "<option value=''></option>";
				while($linha = pg_fetch_array($res)){
					echo "<option>".$linha['name_varchar']."</option>";
					$SQLs = "SELECT * FROM activitycontent WHERE father_id = ".$linha['id']." ORDER BY name_varchar";
					$ress = pg_query($SQLs);
					while($linhas = pg_fetch_array($ress)){
						echo "<option value='".$linhas['id']."'>->".$linhas['name_varchar']."</option>";
					}
				}
				echo "</select></td></tr>";
			}
		}
	//-------------------------------------------------------------------------------------- TIPO DE TEXTO
		if((isset($dimensao) && $dimensao==10) || (isset($dimensao1) && $dimensao1==10) || (isset($dimensao2) && $dimensao2==10) || (isset($dimensao3) && $dimensao3==10) || (isset($dimensao4) && $dimensao4==10)){//-----TEXTO
			$SQL = "SELECT * FROM activitycontent WHERE father_id = 143 ORDER BY name_varchar";
			$res = pg_query($SQL);
			echo "<tr><td>Tipo: </td><td><select name='textotipo' onChange=document.goal_ins.submit()>";
			echo "<option value='".(isset($textotipo)?$textotipo:"")."'>".(isset($textotiponame)?$textotiponame:"")."</option>";
			echo "<option value=''></option>";
			while($linha = pg_fetch_array($res)){
				echo "<option value='".$linha['id']."'>".$linha['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
		//-------------------------------------------------------------------------------------- SUB TIPO DE TEXTO
		if((isset($textotipo) && $textotipo!="") && (isset($dimensao) && $dimensao==10) || (isset($dimensao1) && $dimensao1==10) || (isset($dimensao2) && $dimensao2==10) || (isset($dimensao3) && $dimensao3==10) || (isset($dimensao4) && $dimensao4==10)){//-----TEXTO
			$SQL = "SELECT * FROM activitycontent WHERE father_id = ".$textotipo." ORDER BY name_varchar";
			$res = pg_query($SQL);
			echo "<tr><td>SubTipo: </td><td><select name='subtextotipo' onChange=document.goal_ins.submit()>";
			echo "<option value='".(isset($subtextotipo)?$subtextotipo:"")."'>".(isset($subtextotiponame)?$subtextotiponame:"")."</option>";
			echo "<option value=''></option>";
			while($linha = pg_fetch_array($res)){
				echo "<option value='".$linha['id']."'>".$linha['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
		
		//-------------------------------------------------------------------------------------- GENERO DO TEXTO
		if((isset($dimensao) && $dimensao==10) || (isset($dimensao1) && $dimensao1==10) || (isset($dimensao2) && $dimensao2==10) || (isset($dimensao3) && $dimensao3==10) || (isset($dimensao4) && $dimensao4==10)){//-----TEXT
			$SQL = "SELECT * FROM activitycontent WHERE father_id = 154 ORDER BY name_varchar";
			$res = pg_query($SQL);
			echo "<tr><td>Gênero: </td><td><select name='textogenero' onChange=document.goal_ins.submit()>";
			echo "<option value='".(isset($textogenero)?$textogenero:"")."'>".(isset($textogeneroname)?$textogeneroname:"")."</option>";
			echo "<option value=''></option>";
			while($linha = pg_fetch_array($res)){
				echo "<option value='".$linha['id']."'>".$linha['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
		//-------------------------------------------------------------------------------------- CONTEUDO DO TEXTO
		if((isset($dimensao) && $dimensao==10) || (isset($dimensao1) && $dimensao1==10) || (isset($dimensao2) && $dimensao2==10) || (isset($dimensao3) && $dimensao3==10) || (isset($dimensao4) && $dimensao4==10)){//-----TEXT
		
			//echo '<input name="imgMais" value="true" id="sub" type="image" title="Mais" src="images/adicionar.gif" alt="Mais" width="60" height="18" border="0" onClick=filtra(update)>';
			if(!isset($acao) || (isset($acao) && $acao!="update")){
				$iconteudo=0;			
			}
			$iconteudo ++;			
			for($i=1; ; $i++){
				if ($i > $iconteudo) {
					break;
				}else{
					$SQL = "SELECT * FROM activitycontent WHERE father_id = 167 ORDER BY name_varchar";
					$res = pg_query($SQL);
					echo "<tr><td>Conteúdo: </td><td><select name='conteudotexto' onChange=document.goal_ins.submit()>";
					echo "<option value='".(isset($conteudotexto)?$conteudotexto:"")."'>".(isset($conteudotextoname)?$conteudotextoname:"")."</option>";
					echo "<option value=''></option>";
					while($linha = pg_fetch_array($res)){
						echo "<option value='".$linha['id']."'>".$linha['name_varchar']."</option>";
					}
					echo "</select></td></tr>";
					echo "<input type='hidden' name='iconteudo' value='".$iconteudo."'>";
		
		//					conteudo($conteudotexto, $conteudotextoname, $iconteudo);
				}
			}
			echo "</td></tr>";
		}
		//-------------------------------------------------------------------------------------- ORGANIZAÇÃO DO TEXTO
		if((isset($dimensao) && $dimensao==10) || (isset($dimensao1) && $dimensao1==10) || (isset($dimensao2) && $dimensao2==10) || (isset($dimensao3) && $dimensao3==10) || (isset($dimensao4) && $dimensao4==10)){//-----TEXT
			$SQL = "SELECT * FROM activitycontent WHERE father_id = 159 ORDER BY name_varchar";
			$res = pg_query($SQL);
			echo "<tr><td>Organização: </td><td><select name='organizatexto' onChange=document.goal_ins.submit()>";
			echo "<option value='".(isset($organizatexto)?$organizatexto:"")."'>".(isset($organizatextoname)?$organizatextoname:"")."</option>";
			echo "<option value=''></option>";
			while($linha = pg_fetch_array($res)){
				echo "<option value='".$linha['id']."'>".$linha['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
		//-------------------------------------------------------------------------------------- COESÃO DO TEXTO
		if((isset($dimensao) && $dimensao==10) || (isset($dimensao1) && $dimensao1==10) || (isset($dimensao2) && $dimensao2==10) || (isset($dimensao3) && $dimensao3==10) || (isset($dimensao4) && $dimensao4==10)){//-----TEXT
			$SQL = "SELECT * FROM activitycontent WHERE father_id = 172 ORDER BY name_varchar";
			$res = pg_query($SQL);
			echo "<tr><td>Coesão: </td><td><select name='textocoesao' onChange=document.goal_ins.submit()>";
			echo "<option value='".(isset($textocoesao)?$textocoesao:"")."'>".(isset($textocoesaoname)?$textocoesaoname:"")."</option>";
			echo "<option value=''></option>";
			while($linha = pg_fetch_array($res)){
				echo "<option value='".$linha['id']."'>".$linha['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
	echo "</table>";
echo "</td>";
		
echo "<td>";		
	echo "<table><tr><td>Elementos: </td><td><select name='elementos' onChange=document.goal_ins.submit()>";
		$SQLt = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 83 ORDER BY name_varchar";
		$rest = pg_query($SQLt);
		echo "<option value='".(isset($elementos)?$elementos:"")."'>".(isset($elementosname)?$elementosname:"")."</option>";
		echo "<option value=''></option>";
		while($linhat = pg_fetch_array($rest)){
			echo "<option value='".$linhat['id']."'>".$linhat['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
	echo "</table>";
echo "</td>";
?>