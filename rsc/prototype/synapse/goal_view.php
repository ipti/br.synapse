<?php

ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
include("includes/conecta.php");
ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

//if(!(session_is_registered('person'))){
//	echo "erro";
//	header('Location: ' . "http://" . $_SERVER["SERVER_NAME"]."/synapse/index.php");	
//}

function conteudo($conteudotexto, $conteudotextoname, $iconteudo){
	$SQL = "SELECT * FROM activitycontent WHERE father_id = 167 ORDER BY name_varchar";
	$res = pg_query($SQL);
	echo "<tr><td>Conteúdo: </td><td><select name='conteudotexto'>";
	echo "<option value='".(isset($conteudotexto)?$conteudotexto:"")."'>".(isset($conteudotextoname)?$conteudotextoname:"")."</option>";
	echo "<option value=''></option>";
	while($linha = pg_fetch_array($res)){
		echo "<option value='".$linha['id']."'>".$linha['name_varchar']."</option>";
	}
	echo "</select>";
	echo "<input type='hidden' name='iconteudo' value='".$iconteudo."'>";
}
?>
<head>
<title><?php echo $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script language="javascript">
<!--
var form = "";
var submitted = false;
var error = false;
var error_message = "";

function filtra(cod) {
  	document.forms["goal_ins"].filtragem.value = cod;	
}

//-->
</script>

</head>
<body>
<?php 


//_________________________________________________________________________________________ SELECT NAME CONTENT
if(isset($degreeblock) && $degreeblock!=""){
	$SQL = "SELECT name FROM degreeblock WHERE id = ".$degreeblock."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$degreeblockname = $linha['name'];
}

if(isset($habilidade) && $habilidade!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$habilidade."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$habilidadename = $linha['name_varchar'];
}

if(isset($subhabilidade) && $subhabilidade!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subhabilidade."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subhabilidadename = $linha['name_varchar'];
}
//------------------------------------------------------------------------------------- PORT
if(isset($dimensao) && $dimensao!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$dimensao."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$dimensaoname = $linha['name_varchar'];
}

if(isset($dimensao1) && $dimensao1!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$dimensao1."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$dimensao1name = $linha['name_varchar'];
}

if(isset($oracaofuncao) && $oracaofuncao!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$oracaofuncao."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$oracaofuncaoname = $linha['name_varchar'];
}

if(isset($oracaotipo) && $oracaotipo!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$oracaotipo."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$oracaotiponame = $linha['name_varchar'];
}

if(isset($textotipo) && $textotipo!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$textotipo."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$textotiponame = $linha['name_varchar'];
}

if(isset($subtextotipo) && $subtextotipo!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subtextotipo."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subtextotiponame = $linha['name_varchar'];
}

if(isset($textogenero) && $textogenero!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$textogenero."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$textogeneroname = $linha['name_varchar'];
}

if(isset($conteudotexto) && $conteudotexto!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$conteudotexto."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$conteudotextoname = $linha['name_varchar'];
}

if(isset($organizatexto) && $organizatexto!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$organizatexto."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$organizatextoname = $linha['name_varchar'];
}

if(isset($textocoesao) && $textocoesao!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$textocoesao."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$textocoesaoname = $linha['name_varchar'];
}

if(isset($wordclass) && $wordclass!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$wordclass."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$wordclassname = $linha['name_varchar'];
}

if(isset($subwordclass) && $subwordclass!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subwordclass."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subwordclassname = $linha['name_varchar'];
}

if(isset($sintaxfunction) && $sintaxfunction!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$sintaxfunction."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$sintaxfunctionname = $linha['name_varchar'];
}

if(isset($subsintaxfunction) && $subsintaxfunction!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subsintaxfunction."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subsintaxfunctionname = $linha['name_varchar'];
}

if(isset($semanticrelation) && $semanticrelation!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$semanticrelation."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$semanticrelationname = $linha['name_varchar'];
}

if(isset($subsemanticrelation) && $subsemanticrelation!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subsemanticrelation."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subsemanticrelationname = $linha['name_varchar'];
}

if(isset($sub1semanticrelation) && $sub1semanticrelation!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$sub1semanticrelation."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$sub1semanticrelationname = $linha['name_varchar'];
}

if(isset($figuralinguagem) && $figuralinguagem!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$figuralinguagem."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$figuralinguagemname = $linha['name_varchar'];
}

if(isset($modalidade) && $modalidade!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$modalidade."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$modalidadename = $linha['name_varchar'];
}

if(isset($submodalidade) && $submodalidade!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$submodalidade."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$submodalidadename = $linha['name_varchar'];
}
if(isset($submodalidade1) && $submodalidade1!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$submodalidade1."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$submodalidadename1 = $linha['name_varchar'];
}
	if(isset($elementos) && $elementos!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$elementos."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$elementosname = $linha['name_varchar'];
}

//------------------------------------------------------------------------------------------ MAT
if(isset($grandeza) && $grandeza!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$grandeza."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$grandezaname = $linha['name_varchar'];
}

if(isset($subgrandeza) && $subgrandeza!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subgrandeza."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subgrandezaname = $linha['name_varchar'];
}

if(isset($numero) && $numero!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$numero."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$numeroname = $linha['name_varchar'];
}

if(isset($geometria) && $geometria!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$geometria."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$geometrianame = $linha['name_varchar'];
}

if(isset($subgeometria) && $subgeometria!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subgeometria."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subgeometrianame = $linha['name_varchar'];
}

if(isset($tamanho) && $tamanho!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$tamanho."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$tamanhoname = $linha['name_varchar'];
}

if(isset($operacoes) && $operacoes!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$operacoes."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$operacoesname = $linha['name_varchar'];
}
if(isset($multiplicacao) && $multiplicacao!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$multiplicacao."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$multiplicacaoname = $linha['name_varchar'];
}
if(isset($calculo) && $calculo!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$calculo."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$calculoname = $linha['name_varchar'];
}

if(isset($problemas) && $problemas!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$problemas."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$problemasname = $linha['name_varchar'];
}

if(isset($quantoperacoes) && $quantoperacoes!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$quantoperacoes."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$quantoperacoesname = $linha['name_varchar'];
}

if(isset($situacao) && $situacao!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$situacao."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$situacaoname = $linha['name_varchar'];
}

if(isset($subsituacao) && $subsituacao!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subsituacao."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subsituacaoname = $linha['name_varchar'];
}
//------------------------------------------------------------------------------------------ CIEN
if(isset($ambiente1) && $ambiente1!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$ambiente1."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$ambiente1name = $linha['name_varchar'];
}

if(isset($ambiente2) && $ambiente2!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$ambiente2."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$ambiente2name = $linha['name_varchar'];
}

if(isset($tipoambiente) && $tipoambiente!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$tipoambiente."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$tipoambientename = $linha['name_varchar'];
}

//_________________________________________________________________________________________ //SELECT NAME CONTENT

//___________________________________________________________________________________________ SELECT GOAL
if(isset($filtragem) && $filtragem==11){//grava novo objetivo

	$SQLi = "SELECT goal.id, goal.name_varchar, goal.grade as goalgrade, degreeblock.name FROM goal
						LEFT JOIN degreeblock ON degreeblock.id = goal.degreeblock_id
						LEFT JOIN degreestage ON degreestage.id = degreeblock.degreestage_id
		     WHERE contenthability_id like '%#%' ";

	if(isset($habilidade) && $habilidade!=""){
		$SQLi .= " AND (contenthability_id like '%#".$habilidade."#%')";
	}
	if(isset($subhabilidade) && $subhabilidade!=""){
		$SQLi .= " AND (contenthability_id like '%#".$subhabilidade."#%')";
	}
//------------------------------------------------------------------------------- PORT
	if(isset($dimensao) && $dimensao!=""){
		$SQLi .= " AND (contenthability_id like '%#".$dimensao."#%')";
	}
	if(isset($dimensao1) && $dimensao1!=""){
		if(isset($not)){
			$SQLi .= " AND (contenthability_id not like '%#".$dimensao1."#%')";
		}else{
			$SQLi .= " AND (contenthability_id like '%#".$dimensao1."#%')";
		}
	}
	if(isset($oracaofuncao) && $oracaofuncao!=""){
		$SQLi .= " AND (contenthability_id like '%#".$oracaofuncao."#%')";
	}
	if(isset($oracaotipo) && $oracaotipo!=""){
		$SQLi .= " AND (contenthability_id like '%#".$oracaotipo."#%')";
	}
	if(isset($textotipo) && $textotipo!=""){
		$SQLi .= " AND (contenthability_id like '%#".$textotipo."#%')";
	}
	if(isset($subtextotipo) && $subtextotipo!=""){
		$SQLi .= " AND (contenthability_id like '%#".$subtextotipo."#%')";
	}
	if(isset($conteudotexto) && $conteudotexto!=""){
		$SQLi .= " AND (contenthability_id like '%#".$conteudotexto."#%')";
	}
	if(isset($organizatexto) && $organizatexto!=""){
		$SQLi .= " AND (contenthability_id like '%#".$organizatexto."#%')";
	}
	if(isset($textocoesao) && $textocoesao!=""){
		$SQLi .= " AND (contenthability_id like '%#".$textocoesao."#%')";
	}
	if(isset($textogenero) && $textogenero!=""){
		$SQLi .= " AND (contenthability_id like '%#".$textogenero."#%')";
	}
	if(isset($wordclass) && $wordclass!=""){
		$SQLi .= " AND (contenthability_id like '%#".$wordclass."#%')";
	}
	if(isset($subwordclass) && $subwordclass!=""){
		$SQLi .= " AND (contenthability_id like '%#".$subwordclass."#%')";
	}
	if(isset($sintaxfunction) && $sintaxfunction!=""){
		$SQLi .= " AND (contenthability_id like '%#".$sintaxfunction."#%')";
	}
	if(isset($subsintaxfunction) && $subsintaxfunction!=""){
		$SQLi .= " AND (contenthability_id like '%#".$subsintaxfunction."#%')";
	}
	if(isset($semanticrelation) && $semanticrelation!=""){
		$SQLi .= " AND (contenthability_id like '%#".$semanticrelation."#%')";
	}
	if(isset($subsemanticrelation) && $subsemanticrelation!=""){
		$SQLi .= " AND (contenthability_id like '%#".$subsemanticrelation."#%')";
	}
	if(isset($sub1semanticrelation) && $sub1semanticrelation!=""){
		$SQLi .= " AND (contenthability_id like '%#".$sub1semanticrelation."#%')";
	}
	if(isset($figuralinguagem) && $figuralinguagem!=""){
		$SQLi .= " AND (contenthability_id like '%#".$figuralinguagem."#%')";
	}
	if(isset($modalidade) && $modalidade!=""){
		$SQLi .= " AND (contenthability_id like '%#".$modalidade."#%')";
	}
	if(isset($submodalidade) && $submodalidade!=""){
		$SQLi .= " AND (contenthability_id like '%#".$submodalidade."#%')";
	}
	if(isset($submodalidade1) && $submodalidade1!=""){
		$SQLi .= " AND (contenthability_id like '%#".$submodalidade1."#%')";
	}
	if(isset($elementos) && $elementos!=""){
		$SQLi .= " AND (contenthability_id like '%#".$elementos."#%')";
	}
//----------------------------------------------------------------------------- MAT
	if(isset($grandeza) && $grandeza!=""){
		$SQLi .= " AND (contenthability_id like '%#".$grandeza."#%')";
	}
	if(isset($subgrandeza) && $subgrandeza!=""){
		$SQLi .= " AND (contenthability_id like '%#".$subgrandeza."#%')";
	}
	if(isset($numero) && $numero!=""){
		$SQLi .= " AND (contenthability_id like '%#".$numero."#%')";
	}
	if(isset($geometria) && $geometria!=""){
		$SQLi .= " AND (contenthability_id like '%#".$geometria."#%')";
	}
	if(isset($partes) && $partes!=""){
		$SQLi .= " AND (contenthability_id like '%#".$partes."#%')";
	}
	if(isset($tamanho) && $tamanho!=""){
		$SQLi .= " AND (contenthability_id like '%#".$tamanho."#%')";
	}
	if(isset($operacoes) && $operacoes!=""){
		$SQLi .= " AND (contenthability_id like '%#".$operacoes."#%')";
	}
	if(isset($multiplicacao) && $multiplicacao!=""){
		$SQLi .= " AND (contenthability_id like '%#".$multiplicacao."#%')";
	}
	if(isset($calculo) && $calculo!=""){
		$SQLi .= " AND (contenthability_id like '%#".$calculo."#%')";
	}
	if(isset($problemas) && $problemas!=""){
		$SQLi .= " AND (contenthability_id like '%#".$problemas."#%')";
	}
	if(isset($quantoperacoes) && $quantoperacoes!=""){
		$SQLi .= " AND (contenthability_id like '%#".$quantoperacoes."#%')";
	}
	if(isset($situacao) && $situacao!=""){
		$SQLi .= " AND (contenthability_id like '%#".$situacao."#%')";
	}
	if(isset($subsituacao) && $subsituacao!=""){
		$SQLi .= " AND (contenthability_id like '%#".$subsituacao."#%')";
	}

//----------------------------------------------------------------------------- CIEN
	if(isset($ambiente1) && $ambiente1!=""){
		$SQLi .= "315#".$ambiente1."#";
	}
	if(isset($ambiente2) && $ambiente2!=""){
		$SQLi .= $ambiente2."#";
	}
	if(isset($tipoambiente) && $tipoambiente!=""){
		$SQLi .= $tipoambiente."#";
	}
	
	if(isset($degreeblock) && $degreeblock!=""){
		$SQLi .= " AND (goal.degreeblock_id = ".$degreeblock.")";
	}
	
	if(isset($grade) && $grade!=""){
		$SQLi .= " AND (goal.grade = ".$grade.")";
	}

	$SQLi .= " ORDER BY degreestage.grade, degreeblock.grade, goal.grade";
	
	$resi = pg_query($SQLi);
	echo $SQLi;
	if(pg_num_rows($resi)>0){
		while($linha = pg_fetch_array($resi)){
			echo "<h3>".$linha['id']." - ".$linha['name_varchar']." - ".$linha['name']." - Grau: ".$linha['goalgrade']."</h3>";
		}
	}
}
//_________________________________________________________________________________________________________________ //INSERT GOAL

//___________________________________________________________________________________________________________________ FORM GOAL
if(isset($acao) && $acao==10){//exibe formulario para insercao de novo objetivo
	echo '<form name="goal_ins" action="goal_view.php" method="post">';

	echo "<table height='400'><tr valign='top'>";
	echo "<td>";
//-------------------------------------------------------------------------------------- HABILIDADE
	echo "Habilidade: <select name='habilidade' onChange=document.goal_ins.submit()>";
	$SQLh = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 11 ORDER BY name_varchar";	
	$resh = pg_query($SQLh);
	echo "<option value='".(isset($habilidade)?$habilidade:"")."'>".(isset($habilidadename)?$habilidadename:"")."</option>";
	echo "<option value=''></option>";
	while($linhah = pg_fetch_array($resh)){
		$habilidadename = $linhah['name_varchar'];
		echo "<option value='".$linhah['id']."'>".$linhah['name_varchar']."</option>";
	}
	echo "</select>";

	if(isset($habilidade) && $habilidade!=""){
		$SQLhs = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$habilidade." ORDER BY name_varchar";
		$reshs = pg_query($SQLhs);
		if(pg_num_rows($reshs)>0){
			echo "<br>SubHabilidade: <select name='subhabilidade'>";
			echo "<option value='".(isset($subhabilidade)?$subhabilidade:"")."'>".(isset($subhabilidadename)?$subhabilidadename:"")."</option>";
			echo "<option value=''></option>";
			while($linhahs = pg_fetch_array($reshs)){
				echo "<option value='".$linhahs['id']."'>".$linhahs['name_varchar']."</option>";
			}
			echo "</select>";
		}
	}
	
	echo "<br>Habilidade1: <select name='habilidade1'>";
	$SQLh = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 11 ORDER BY name_varchar";	
	$resh = pg_query($SQLh);
	echo "<option value='".(isset($habilidade1)?$habilidade1:"")."'>".(isset($habilidade1name)?$habilidade1name:"")."</option>";
	echo "<option value=''></option>";
	while($linhah = pg_fetch_array($resh)){
		echo "<option value='".$linhah['id']."'>".$linhah['name_varchar']."</option>";
	}
	echo "</select>";
	
	echo "<br>Condições: <select name='condicoes'>";
	$SQLh = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 429 ORDER BY name_varchar";	
	$resh = pg_query($SQLh);
	echo "<option value='".(isset($condicoes)?$condicoes:"")."'>".(isset($condicoesname)?$condicoesname:"")."</option>";
	echo "<option value=''></option>";
	while($linhah = pg_fetch_array($resh)){
		echo "<option value='".$linhah['id']."'>".$linhah['name_varchar']."</option>";
	}
	echo "</select>";
	
	echo "</td><td>";
//-------------------------------------------------------------------------------------- //HABILIDADE

//-------------------------------------------------------------------------------------- DISC PORT
	if(isset($disc) && $disc==1){
//-------------------------------------------------------------------------------------- DIMENSAO
		echo "<table><tr><td>Dimensão:</td><td> <select name='dimensao' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 1 ORDER BY grade";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($dimensao)?$dimensao:"")."'>".(isset($dimensaoname)?$dimensaoname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
//-------------------------------------------------------------------------------------- TIPO DE ORAÇÃO
		if(isset($dimensao) && $dimensao==7){//-----ORAÇÃO
			$SQL = "SELECT * FROM activitycontent WHERE father_id = 314 ORDER BY name_varchar";
			$res = pg_query($SQL);
			echo "<tr><td>Tipo: </td><td><select name='oracaotipo'>";
			echo "<option value='".(isset($oracaotipo)?$oracaotipo:"")."'>".(isset($oracaotiponame)?$oracaotiponame:"")."</option>";
			echo "<option value=''></option>";
			while($linha = pg_fetch_array($res)){
				echo "<option value='".$linha['id']."'>".$linha['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
//-------------------------------------------------------------------------------------- FUNÇÃO DA ORAÇÃO
		if(isset($dimensao) && $dimensao==7){//-----ORAÇÃO
			$SQL = "SELECT * FROM activitycontent WHERE father_id = 307 ORDER BY name_varchar";
			$res = pg_query($SQL);
			echo "<tr><td>Função: </td><td><select name='oracaofuncao'>";
			echo "<option value='".(isset($oracaofuncao)?$oracaofuncao:"")."'>".(isset($oracaofuncaoname)?$oracaofuncaoname:"")."</option>";
			echo "<option value=''></option>";
			while($linha = pg_fetch_array($res)){
				echo "<option value='".$linha['id']."'>".$linha['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
//-------------------------------------------------------------------------------------- TIPO DE TEXTO
		if(isset($dimensao) && $dimensao==10){//-----TEXTO
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
		if((isset($textotipo) && $textotipo!="") && (isset($dimensao) && $dimensao==10)){//-----TEXTO
			$SQL = "SELECT * FROM activitycontent WHERE father_id = ".$textotipo." ORDER BY name_varchar";
			$res = pg_query($SQL);
			echo "<tr><td>SubTipo: </td><td><select name='subtextotipo'>";
			echo "<option value='".(isset($subtextotipo)?$subtextotipo:"")."'>".(isset($subtextotiponame)?$subtextotiponame:"")."</option>";
			echo "<option value=''></option>";
			while($linha = pg_fetch_array($res)){
				echo "<option value='".$linha['id']."'>".$linha['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
		
//-------------------------------------------------------------------------------------- GENERO DO TEXTO
		if(isset($dimensao) && $dimensao==10){//-----TEXT
			$SQL = "SELECT * FROM activitycontent WHERE father_id = 154 ORDER BY name_varchar";
			$res = pg_query($SQL);
			echo "<tr><td>Gênero: </td><td><select name='textogenero'>";
			echo "<option value='".(isset($textogenero)?$textogenero:"")."'>".(isset($textogeneroname)?$textogeneroname:"")."</option>";
			echo "<option value=''></option>";
			while($linha = pg_fetch_array($res)){
				echo "<option value='".$linha['id']."'>".$linha['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
//-------------------------------------------------------------------------------------- CONTEUDO DO TEXTO
		if(isset($dimensao) && $dimensao==10){//-----TEXT

			//echo '<input name="imgMais" value="true" id="sub" type="image" title="Mais" src="images/adicionar.gif" alt="Mais" width="60" height="18" border="0" onClick=filtra(12)>';
			if(!isset($filtragem) || (isset($filtragem) && $filtragem!=12)){
				$iconteudo=0;			
			}
			$iconteudo ++;			
			for($i=1; ; $i++){
				if ($i > $iconteudo) {
			        break;
			    }else{
					$SQL = "SELECT * FROM activitycontent WHERE father_id = 167 ORDER BY name_varchar";
					$res = pg_query($SQL);
					echo "<tr><td>Conteúdo: </td><td><select name='conteudotexto'>";
					echo "<option value='".(isset($conteudotexto)?$conteudotexto:"")."'>".(isset($conteudotextoname)?$conteudotextoname:"")."</option>";
					echo "<option value=''></option>";
					while($linha = pg_fetch_array($res)){
						echo "<option value='".$linha['id']."'>".$linha['name_varchar']."</option>";
					}
					echo "</select>";
					echo "<input type='hidden' name='iconteudo' value='".$iconteudo."'>";

//					conteudo($conteudotexto, $conteudotextoname, $iconteudo);
				}
			}
			echo "</td></tr>";
		}
//-------------------------------------------------------------------------------------- ORGANIZAÇÃO DO TEXTO
		if(isset($dimensao) && $dimensao==10){//-----TEXT
			$SQL = "SELECT * FROM activitycontent WHERE father_id = 159 ORDER BY name_varchar";
			$res = pg_query($SQL);
			echo "<tr><td>Organização: </td><td><select name='organizatexto'>";
			echo "<option value='".(isset($organizatexto)?$organizatexto:"")."'>".(isset($organizatextoname)?$organizatextoname:"")."</option>";
			echo "<option value=''></option>";
			while($linha = pg_fetch_array($res)){
				echo "<option value='".$linha['id']."'>".$linha['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
//-------------------------------------------------------------------------------------- COESÃO DO TEXTO
		if(isset($dimensao) && $dimensao==10){//-----TEXT
			$SQL = "SELECT * FROM activitycontent WHERE father_id = 172 ORDER BY name_varchar";
			$res = pg_query($SQL);
			echo "<tr><td>Coesão: </td><td><select name='textocoesao'>";
			echo "<option value='".(isset($textocoesao)?$textocoesao:"")."'>".(isset($textocoesaoname)?$textocoesaoname:"")."</option>";
			echo "<option value=''></option>";
			while($linha = pg_fetch_array($res)){
				echo "<option value='".$linha['id']."'>".$linha['name_varchar']."</option>";
			}
			echo "</select></td></tr>";
		}
//-------------------------------------------------------------------------------------- WORD CLASS
		if((isset($dimensao) && ($dimensao==5 || $dimensao==6)) || (isset($dimensao1) && ($dimensao1==5 || $dimensao1==6))){//-----PALAVRA OU LOCUÇÃO
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
		if((isset($wordclass) && $wordclass!="") && ((isset($dimensao) && ($dimensao==5 || $dimensao==6)) || (isset($dimensao1) && ($dimensao1==5 || $dimensao1==6)))){
			$SQL = "SELECT * FROM activitycontent WHERE father_id = ".$wordclass." ORDER BY name_varchar";
			$res = pg_query($SQL);
			if(pg_num_rows($res)>0){
				echo "<tr><td>SubClasse: </td><td><select name='subwordclass'>";
				echo "<option value='".(isset($subwordclass)?$subwordclass:"")."'>".(isset($subwordclassname)?$subwordclassname:"")."</option>";
				echo "<option value=''></option>";
				while($linha = pg_fetch_array($res)){
					echo "<option value='".$linha['id']."'>".$linha['name_varchar']."</option>";
				}
				echo "</select></td></tr>";
			}
		}
//-------------------------------------------------------------------------------------- FUNÇÃO SINTÁTICA
		if((isset($dimensao) && ($dimensao==7 || $dimensao==8)) || (isset($dimensao1) && ($dimensao1==7 || $dimensao1==8))){//-----ORAÇÃO OU FRASE
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
		if((isset($sintaxfunction) && $sintaxfunction!="") && (isset($dimensao) && ($dimensao==7 || $dimensao==8)) || (isset($dimensao1) && ($dimensao1==7 || $dimensao1==8))){
			$SQL = "SELECT * FROM activitycontent WHERE father_id = ".$sintaxfunction." ORDER BY name_varchar";
			$res = pg_query($SQL);
			if(pg_num_rows($res)>0){
				echo "<tr><td>SubSintaxe: </td><td><select name='subsintaxfunction'>";
				echo "<option value='".(isset($subsintaxfunction)?$subsintaxfunction:"")."'>".(isset($subsintaxfunctionname)?$ssubintaxfunctionname:"")."</option>";
				echo "<option value=''></option>";
				while($linha = pg_fetch_array($res)){
					echo "<option value='".$linha['id']."'>".$linha['name_varchar']."</option>";
				}
				echo "</select></td></tr>";
			}
		}
//-------------------------------------------------------------------------------------- RELAÇÃO SEMANTICA
		if(isset($dimensao) && ($dimensao==8 || $dimensao==9 || $dimensao==10)){//----------FRASE, PARAGRAFO OU TEXTO
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
		if((isset($semanticrelation) && $semanticrelation!="") && (isset($dimensao) && ($dimensao==8 || $dimensao==9 || $dimensao==10))){
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
		if((isset($semanticrelation) && $semanticrelation!="") && (isset($subsemanticrelation) && $subsemanticrelation!="") && (isset($dimensao) && ($dimensao==8 || $dimensao==9 || $dimensao==10))){
			$SQL = "SELECT * FROM activitycontent WHERE father_id = ".$subsemanticrelation." ORDER BY name_varchar";
			$res = pg_query($SQL);
			if(pg_num_rows($res)>0){
				echo "<tr><td>SubRelação1: </td><td><select name='sub1semanticrelation'>";
				echo "<option value='".(isset($sub1semanticrelation)?$sub1semanticrelation:"")."'>".(isset($sub1semanticrelationname)?$sub1semanticrelationname:"")."</option>";
				echo "<option value=''></option>";
				while($linha = pg_fetch_array($res)){
					echo "<option value='".$linha['id']."'>".$linha['name_varchar']."</option>";
				}
				echo "</select></td></tr>";
			}
		}
//-------------------------------------------------------------------------------------- FIGURA LINGUAGEM
		if((isset($dimensao) && ($dimensao==7 || $dimensao==8 || $dimensao==9 || $dimensao==10))){
			$SQL = "SELECT * FROM activitycontent WHERE father_id = 94 ORDER BY name_varchar";
			$res = pg_query($SQL);
			if(pg_num_rows($res)>0){
				echo "<tr><td>Figuras: </td><td><select name='figuralinguagem'>";
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
//-------------------------------------------------------------------------------------- //DIMENSÃO
		echo "</table></td><td>";
		echo "Dimensão1: <select name='dimensao1' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 1 ORDER BY grade";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($dimensao1)?$dimensao1:"")."'>".(isset($dimensao1name)?$dimensao1name:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td>";
//-------------------------------------------------------------------------------------- MODALIDADE
		echo "<td><table><tr><td>Modalidade:</td><td> <select name='modalidade' onChange=document.goal_ins.submit()>";
		$SQLt = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 20 ORDER BY name_varchar";
		$rest = pg_query($SQLt);
		echo "<option value='".(isset($modalidade)?$modalidade:"")."'>".(isset($modalidadename)?$modalidadename:"")."</option>";
		echo "<option value=''></option>";
		while($linhat = pg_fetch_array($rest)){
			echo "<option value='".$linhat['id']."'>".$linhat['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		if(isset($modalidade) && $modalidade!=""){
			echo "<tr><td>SubModalidade:</td><td> <select name='submodalidade'>";
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
	/*
		if(isset($modalidade) && $modalidade!=""){
			echo "SubModalidade1: <select name='submodalidade1'>";
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
			echo "</select>";
		}
		*/
		echo "</table></td><td>";
		echo "Elementos: <select name='elementos'>";
		$SQLt = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 83 ORDER BY name_varchar";
		$rest = pg_query($SQLt);
		echo "<option value='".(isset($elementos)?$elementos:"")."'>".(isset($elementosname)?$elementosname:"")."</option>";
		echo "<option value=''></option>";
		while($linhat = pg_fetch_array($rest)){
			echo "<option value='".$linhat['id']."'>".$linhat['name_varchar']."</option>";
		}
		echo "</select>";

		echo "</td></tr></table>";
//-------------------------------------------------------------------------------------- //MODALIDADE
	}//if($disc==1)

//-------------------------------------------------------------------------------------- DISC MAT
	if(isset($disc) && $disc==2){
//-------------------------------------------------------------------------------------- GRANDEZAS
		echo "<table><tr><td>Grandezas:<br> <select name='grandeza' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 192 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($grandeza)?$grandeza:"")."'>".(isset($grandezaname)?$grandezaname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
//-------------------------------------------------------------------------------------- SUB GRANDEZA
		if(isset($grandeza) && $grandeza!=""){
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$grandeza." ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			if(pg_num_rows($resfu)>0){
				echo "<tr><td>SubGrandeza:<br> <select name='subgrandeza'>";
				echo "<option value='".(isset($subgrandeza)?$subgrandeza:"")."'>".(isset($subgrandezaname)?$subgrandezaname:"")."</option>";
				echo "<option value=''></option>";
				while($linhafu = pg_fetch_array($resfu)){
					echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
				}
				echo "</select></td></tr>";
			}
		}
		echo "</table></td><td>";

//-------------------------------------------------------------------------------------- NUMEROS
		echo "<table><tr><td>Números:<br> <select name='numero' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 195 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($numero)?$numero:"")."'>".(isset($numeroname)?$numeroname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr></table></td><td>";
//-------------------------------------------------------------------------------------- TAMANHO
		echo "<table><tr><td>Tamanho:<br> <select name='tamanho'>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 268 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($tamanho)?$tamanho:"")."'>".(isset($tamanhoname)?$tamanhoname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr></table></td>";
//-------------------------------------------------------------------------------------- OPERACOES
		echo "<td><table><tr><td>Operações:<br> <select name='operacoes' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 197 AND id <> 257 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($operacoes)?$operacoes:"")."'>".(isset($operacoesname)?$operacoesname:"")."</option>";
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
		echo "</table></td>";
//-------------------------------------------------------------------------------------- PROBLEMAS
		echo "<td><table><tr><td>Problemas:<br> <select name='problemas' onChange=document.goal_ins.submit()>";
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
		echo "</table></td><td>";
//-------------------------------------------------------------------------------------- GEOMETRIA
		echo "<table><tr><td>Geometria:<br> <select name='geometria' onChange=document.goal_ins.submit()>";
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
		echo "</table></td><td>";

//-------------------------------------------------------------------------------------- PLANILHAS
		echo "<table><tr><td>Planilhas:<br> <select name='planilha'>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 191 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($planilha)?$planilha:"")."'>".(isset($planilhaname)?$planilhaname:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr></table>";
		
		echo "</td></tr></table>";
	}//if(isset($disc) && $disc==2){
	
	if(isset($disc) && $disc==3){
//-------------------------------------------------------------------------------------- AMBIENTE 1
		echo "<table><tr><td>Ambiente1:</td><td> <select name='ambiente1' onChange=document.goal_ins.submit()>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 315 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($ambiente1)?$ambiente1:"")."'>".(isset($ambiente1name)?$ambiente1name:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr>";
		
		if(isset($ambiente1) && $ambiente1!=""){
			echo "<tr><td>Tipo Ambiente:</td><td> <select name='tipoambiente'>";
			$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = ".$ambiente1." ORDER BY name_varchar";
			$resfu = pg_query($SQLfu);
			echo "<option value='".(isset($tipoambiente)?$tipoambiente:"")."'>".(isset($tipoambientename)?$tipoambientename:"")."</option>";
			echo "<option value=''></option>";
			while($linhafu = pg_fetch_array($resfu)){
				echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
			}
		}
		echo "</select></td></tr></table>";
		echo "</td><td>";
//-------------------------------------------------------------------------------------- AMBIENTE 2
		echo "<table><tr><td>Ambiente2:</td><td> <select name='ambiente2'>";
		$SQLfu = "SELECT activitycontent.* FROM activitycontent WHERE father_id = 315 ORDER BY name_varchar";
		$resfu = pg_query($SQLfu);
		echo "<option value='".(isset($ambiente2)?$ambiente2:"")."'>".(isset($ambiente2name)?$ambiente2name:"")."</option>";
		echo "<option value=''></option>";
		while($linhafu = pg_fetch_array($resfu)){
			echo "<option value='".$linhafu['id']."'>".$linhafu['name_varchar']."</option>";
		}
		echo "</select></td></tr></table>";
//-------------------------------------------------------------------------------------- TIPO AMBIENTE
		echo "</td></tr></table>";
	}//if(isset($disc) && $disc==3){
		
	echo "<table>";
	echo "<tr><td>Nível: </td><td><select name='degreeblock'>";
	$SQLdb = "SELECT degreeblock.* FROM degreeblock";
	$resdb = pg_query($SQLdb);
	echo "<option value='".(isset($degreeblock)?$degreeblock:"")."'>".(isset($degreeblockname)?$degreeblockname:"")."</option>";
	echo "<option value=''></option>";
	while($linhadb = pg_fetch_array($resdb)){
		echo "<option value='".$linhadb['id']."'>".$linhadb['name']."</option>";
	}
	echo "</select></td>";
	
	echo "<td>Grau: </td><td><input type='text' name='grade' size='4' ></td>";//value='".(isset($grade) && $grade!=""?$grade:"")."'
	
	echo "<input type='hidden' name='content_father' value='".$content_father."'>";
	echo "<input type='hidden' name='goalFather' value='".$goalFather."'>";
	echo "<input type='hidden' name='discname' value='".$discname."'>";
	echo "<input type='hidden' name='contentname' value='".$contentname."'>";
	echo "<input type='hidden' name='degreeblockname' value='".$degreeblockname."'>";
//	echo "<input type='hidden' name='grade' value='".$grade."'>";
	echo "<input type='hidden' name='disc' value='".$disc."'>";
	echo "<input type='hidden' name='acao' value='10'>";
	echo "<input type='hidden' value='0' name='filtragem'>";
	echo "</table>";
	echo '<input name="imgGravar" value="true" id="sub" type="image" title="Gravar" src="images/gravar.gif" alt="Gravar" width="60" height="18" border="0" onClick=filtra(11)>';
	echo "</form>";
}//if(isset($acao) && $acao==10){
?>
</body>
</html>