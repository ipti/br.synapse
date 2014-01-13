<?php
session_start();
//_________________________________________________________________________________________ SELECT NAME CONTENT
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

if(isset($habilidade1) && $habilidade1!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$habilidade1."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$habilidade1name = $linha['name_varchar'];
}

if(isset($condicoes) && $condicoes!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$condicoes."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$condicoesname = $linha['name_varchar'];
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

if(isset($dimensao2) && $dimensao2!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$dimensao2."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$dimensao2name = $linha['name_varchar'];
}
if(isset($dimensao3) && $dimensao3!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$dimensao3."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$dimensao3name = $linha['name_varchar'];
}
if(isset($dimensao4) && $dimensao4!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$dimensao4."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$dimensao4name = $linha['name_varchar'];
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

if(isset($quantoracao) && $quantoracao!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$quantoracao."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$quantoracaoname = $linha['name_varchar'];
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
if(isset($grandeza1) && $grandeza1!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$grandeza1."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$grandeza1name = $linha['name_varchar'];
}
if(isset($medida) && $medida!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$medida."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$medidaname = $linha['name_varchar'];
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

if(isset($partes) && $partes!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$partes."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$partesname = $linha['name_varchar'];
}

if(isset($tipos) && $tipos!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$tipos."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$tiposname = $linha['name_varchar'];
}

if(isset($subtipos) && $subtipos!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subtipos."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subtiposname = $linha['name_varchar'];
}

if(isset($cartesiano) && $cartesiano!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$cartesiano."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$cartesianoname = $linha['name_varchar'];
}

if(isset($algebra) && $algebra!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$algebra."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$algebraname = $linha['name_varchar'];
}

if(isset($subalgebra) && $subalgebra!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subalgebra."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subalgebraname = $linha['name_varchar'];
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
if(isset($operacoes1) && $operacoes1!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$operacoes1."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$operacoes1name = $linha['name_varchar'];
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

if(isset($planilha) && $planilha!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$planilha."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$planilhaname = $linha['name_varchar'];
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

if(isset($subambiente) && $subambiente!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subambiente."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subambientename = $linha['name_varchar'];
}
if(isset($subambiente1) && $subambiente1!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subambiente1."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subambiente1name = $linha['name_varchar'];
}

if(isset($tipoambiente) && $tipoambiente!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$tipoambiente."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$tipoambientename = $linha['name_varchar'];
}

if(isset($seres) && $seres!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$seres."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$seresname = $linha['name_varchar'];
}

if(isset($seres1) && $seres1!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$seres1."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$seres1name = $linha['name_varchar'];
}

if(isset($abioticos) && $abioticos!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$abioticos."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$abioticosname = $linha['name_varchar'];
}

if(isset($subabioticos) && $subabioticos!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subabioticos."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subabioticosname = $linha['name_varchar'];
}

if(isset($subabioticos1) && $subabioticos1!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subabioticos1."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subabioticos1name = $linha['name_varchar'];
}

if(isset($subabioticos1a) && $subabioticos1a!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subabioticos1a."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subabioticos1aname = $linha['name_varchar'];
}

if(isset($bioticos) && $bioticos!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$bioticos."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$bioticosname = $linha['name_varchar'];
}

if(isset($taxonomia) && $taxonomia!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$taxonomia."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$taxonomianame = $linha['name_varchar'];
}
if(isset($taxonomia1) && $taxonomia1!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$taxonomia1."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$taxonomia1name = $linha['name_varchar'];
}
if(isset($sintomas) && $sintomas!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$sintomas."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$sintomasname = $linha['name_varchar'];
}
if(isset($prevencao) && $prevencao!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$prevencao."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$prevencaoname = $linha['name_varchar'];
}
if(isset($transmissao) && $transmissao!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$transmissao."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$transmissaoname = $linha['name_varchar'];
}
if(isset($subtaxonomia) && $subtaxonomia!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subtaxonomia."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subtaxonomianame = $linha['name_varchar'];
}
if(isset($subtaxonomia1) && $subtaxonomia1!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subtaxonomia1."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subtaxonomia1name = $linha['name_varchar'];
}
if(isset($subtaxonomia2) && $subtaxonomia2!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subtaxonomia2."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subtaxonomia2name = $linha['name_varchar'];
}
if(isset($subtaxonomia3) && $subtaxonomia3!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subtaxonomia3."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subtaxonomia3name = $linha['name_varchar'];
}
if(isset($sub1taxonomia) && $sub1taxonomia!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$sub1taxonomia."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$sub1taxonomianame = $linha['name_varchar'];
}
if(isset($sub1taxonomia1) && $sub1taxonomia1!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$sub1taxonomia1."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$sub1taxonomia1name = $linha['name_varchar'];
}
if(isset($sub1taxonomia2) && $sub1taxonomia2!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$sub1taxonomia2."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$sub1taxonomia2name = $linha['name_varchar'];
}
if(isset($sub1taxonomia3) && $sub1taxonomia3!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$sub1taxonomia3."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$sub1taxonomia3name = $linha['name_varchar'];
}
if(isset($alimentacao) && $alimentacao!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$alimentacao."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$alimentacaoname = $linha['name_varchar'];
}
if(isset($alimentacao1) && $alimentacao1!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$alimentacao1."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$alimentacao1name = $linha['name_varchar'];
}
if(isset($reproducao) && $reproducao!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$reproducao."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$reproducaoname = $linha['name_varchar'];
}
if(isset($subreproducao) && $subreproducao!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subreproducao."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subreproducaoname = $linha['name_varchar'];
}
if(isset($locomocao) && $locomocao!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$locomocao."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$locomocaoname = $linha['name_varchar'];
}
if(isset($desenvolvimento) && $desenvolvimento!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$desenvolvimento."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$desenvolvimentoname = $linha['name_varchar'];
}

if(isset($temperatura) && $temperatura!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$temperatura."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$temperaturaname = $linha['name_varchar'];
}

if(isset($esqueleto) && $esqueleto!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$esqueleto."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$esqueletoname = $linha['name_varchar'];
}
if(isset($respiracao) && $respiracao!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$respiracao."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$respiracaoname = $linha['name_varchar'];
}
if(isset($sistemas) && $sistemas!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$sistemas."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$sistemasname = $linha['name_varchar'];
}
if(isset($subsistemas) && $subsistemas!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subsistemas."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subsistemasname = $linha['name_varchar'];
}
if(isset($subsistemas1) && $subsistemas1!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subsistemas1."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subsistemas1name = $linha['name_varchar'];
}
if(isset($subsistemas2) && $subsistemas2!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subsistemas2."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subsistemas2name = $linha['name_varchar'];
}
if(isset($subsistemas3) && $subsistemas3!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subsistemas3."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subsistemas3name = $linha['name_varchar'];
}
if(isset($citologia) && $citologia!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$citologia."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$citologianame = $linha['name_varchar'];
}
if(isset($subcitologia) && $subcitologia!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subcitologia."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subcitologianame = $linha['name_varchar'];
}
if(isset($subcitologia1) && $subcitologia1!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subcitologia1."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subcitologia1name = $linha['name_varchar'];
}
if(isset($subcitologia2) && $subcitologia2!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subcitologia2."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subcitologia2name = $linha['name_varchar'];
}
if(isset($subcitologia3) && $subcitologia3!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subcitologia3."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subcitologia3name = $linha['name_varchar'];
}

if(isset($ecologia) && $ecologia!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$ecologia."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$ecologianame = $linha['name_varchar'];
}
if(isset($subecologia) && $subecologia!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subecologia."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subecologianame = $linha['name_varchar'];
}
if(isset($subecologia1) && $subecologia1!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subecologia1."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subecologia1name = $linha['name_varchar'];
}
if(isset($subecologia1a) && $subecologia1a!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subecologia1a."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subecologia1aname = $linha['name_varchar'];
}
if(isset($subecologia2) && $subecologia2!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subecologia2."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subecologia2name = $linha['name_varchar'];
}
if(isset($subecologia3) && $subecologia3!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subecologia3."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subecologia3name = $linha['name_varchar'];
}

//------------------------------------------------------------------------------------------NEUROCIENCIAS

if(isset($anatomia) && $anatomia!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$anatomia."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$anatomianame = $linha['name_varchar'];
}
if(isset($subanatomia) && $subanatomia!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subanatomia."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subanatomianame = $linha['name_varchar'];
}
if(isset($cognicao) && $cognicao!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$cognicao."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$cognicaoname = $linha['name_varchar'];
}
if(isset($subcognicao) && $subcognicao!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subcognicao."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subcognicaoname = $linha['name_varchar'];
}
if(isset($comportamento) && $comportamento!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$comportamento."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$comportamentoname = $linha['name_varchar'];
}
if(isset($subcomportamento) && $subcomportamento!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subcomportamento."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subcomportamentoname = $linha['name_varchar'];
}
if(isset($degeneracao) && $degeneracao!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$degeneracao."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$degeneracaoname = $linha['name_varchar'];
}
if(isset($subdegeneracao) && $subdegeneracao!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subdegeneracao."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subdegeneracaoname = $linha['name_varchar'];
}
if(isset($desenvolvimentoneuro) && $desenvolvimentoneuro!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$desenvolvimentoneuro."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$desenvolvimentoneuroname = $linha['name_varchar'];
}
if(isset($subdesenvolvimento) && $subdesenvolvimento!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subdesenvolvimento."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subdesenvolvimentoname = $linha['name_varchar'];
}
if(isset($evolucao) && $evolucao!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$evolucao."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$evolucaoname = $linha['name_varchar'];
}
if(isset($subevolucao) && $subevolucao!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subevolucao."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subevolucaoname = $linha['name_varchar'];
}
if(isset($emocao) && $emocao!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$emocao."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$emocaoname = $linha['name_varchar'];
}
if(isset($subemocao) && $subemocao!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subemocao."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subemocaoname = $linha['name_varchar'];
}
if(isset($fisiologia) && $fisiologia!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$fisiologia."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$fisiologianame = $linha['name_varchar'];
}
if(isset($subfisiologia) && $subfisiologia!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subfisiologia."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subfisiologianame = $linha['name_varchar'];
}
if(isset($histologia) && $histologia!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$histologia."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$histologianame = $linha['name_varchar'];
}
if(isset($subhistologia) && $subhistologia!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subhistologia."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subhistologianame = $linha['name_varchar'];
}
if(isset($motor) && $motor!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$motor."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$motorname = $linha['name_varchar'];
}
if(isset($submotor) && $submotor!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$submotor."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$submotorname = $linha['name_varchar'];
}
if(isset($sensorial) && $sensorial!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$sensorial."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$sensorialname = $linha['name_varchar'];
}
if(isset($subsensorial) && $subsensorial!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subsensorial."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subsensorialname = $linha['name_varchar'];
}

if(isset($tecidos) && $tecidos!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$tecidos."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$tecidosname = $linha['name_varchar'];
}
if(isset($subtecidos) && $subtecidos!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subtecidos."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subtecidosname = $linha['name_varchar'];
}
if(isset($subtecidos1) && $subtecidos1!=""){
	$SQL = "SELECT name_varchar FROM activitycontent WHERE id = ".$subtecidos1."";
	$res = pg_query($SQL);
	$linha = pg_fetch_array($res);
	$subtecidos1name = $linha['name_varchar'];
}
//_________________________________________________________________________________________ //SELECT NAME CONTENT
?>