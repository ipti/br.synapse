<?php
session_start();
if(isset($habilidadename) && $habilidadename!=""){
	$SQLi .= $habilidadename." - ";
}
if(isset($subhabilidadename) && $subhabilidadename!=""){
	$SQLi .= $subhabilidadename." - ";
}
if(isset($habilidade1name) && $habilidade1name!=""){
	$SQLi .= $habilidade1name." - ";
}
if(isset($condicoesname) && $condicoesname!=""){
	$SQLi .= $condicoesname." - ";
}
if(isset($dimensaoname) && $dimensaoname!=""){
	$SQLi .= $dimensaoname." - ";
}
if(isset($dimensao1name) && $dimensao1name!=""){
	$SQLi .= $dimensao1name." - ";
}
if(isset($dimensao2name) && $dimensao2name!=""){
	$SQLi .= $dimensao2name." - ";
}
if(isset($dimensao3name) && $dimensao3name!=""){
	$SQLi .= $dimensao3name." - ";
}
if(isset($dimensao4name) && $dimensao4name!=""){
	$SQLi .= $dimensao4name." - ";
}
if(isset($oracaofuncao) && $oracaofuncao!=""){
	$SQLi .= $oracaofuncaoname." - ";
}
if(isset($oracaotipo) && $oracaotipo!=""){
	$SQLi .= $oracaotiponame." - ";
}
if(isset($textotipo) && $textotipo!=""){
	$SQLi .= $textotiponame." - ";
}
if(isset($subtextotipo) && $subtextotipo!=""){
	$SQLi .= $subtextotiponame." - ";
}
if(isset($textogenero) && $textogenero!=""){
	$SQLi .= $textogeneroname." - ";
}
if(isset($conteudotexto) && $conteudotexto!=""){
	$SQLi .= $conteudotextoname." - ";
}
if(isset($organizatexto) && $organizatexto!=""){
	$SQLi .= $organizatextoname." - ";
}
if(isset($textocoesao) && $textocoesao!=""){
	$SQLi .= $textocoesaoname." - ";
}
if(isset($wordclass) && $wordclass!=""){
	$SQLi .= $wordclassname." - ";
}
if(isset($subwordclass) && $subwordclass!=""){
	$SQLi .= $subwordclassname." - ";
}
if(isset($quantoracao) && $quantoracao!=""){
	$SQLi .= $quantoracaoname." - ";
}
if(isset($sintaxfunction) && $sintaxfunction!=""){
	$SQLi .= $sintaxfunctionname." - ";
}
if(isset($subsintaxfunction) && $subsintaxfunction!=""){
	$SQLi .= $subsintaxfunctionname." - ";
}
if(isset($semanticrelation) && $semanticrelation!=""){
	$SQLi .= $semanticrelationname." - ";
}
if(isset($subsemanticrelation) && $subsemanticrelation!=""){
	$SQLi .= $subsemanticrelationname." - ";
}
if(isset($sub1semanticrelation) && $sub1semanticrelation!=""){
	$SQLi .= $sub1semanticrelationname." - ";
}
if(isset($figuralinguagem) && $figuralinguagem!=""){
	$SQLi .= $figuralinguagemname." - ";
}
if(isset($modalidadename) && $modalidadename!=""){
	$SQLi .= $modalidadename." - ";
}
if(isset($submodalidadename) && $submodalidadename!=""){
	$SQLi .= " - ".$submodalidadename." - ";
}
if(isset($submodalidadename1) && $submodalidadename1!=""){
	$SQLi .= " - ".$submodalidadename1." - ";
}
if(isset($elementosname) && $elementosname!=""){
	$SQLi .= " - ".$elementosname." - ";
}
//--------------------------------------------------------------------------- MAT
if(isset($grandezaname) && $grandezaname!=""){
	$SQLi .= $grandezaname." - ";
}
if(isset($grandeza1) && $grandeza1!=""){
	$SQLi .= $grandeza1name;
}
if(isset($medidaname) && $medidaname!=""){
	$SQLi .= " - ".$medidaname;
}
if(isset($numeroname) && $numeroname!=""){
	$SQLi .= " - ".$numeroname;
}
if(isset($geometrianame) && $geometrianame!=""){
	$SQLi .= " - ".$geometrianame;
}
if(isset($partesname) && $partesname!=""){
	$SQLi .= " - ".$partesname;
}
if(isset($tiposname) && $tiposname!=""){
	$SQLi .= " - ".$tiposname;
}
if(isset($subtiposname) && $subtiposname!=""){
	$SQLi .= " - ".$subtiposname;
}
if(isset($cartesianoname) && $cartesianoname!=""){
	$SQLi .= " - ".$cartesianoname;
}
if(isset($algebraname) && $algebraname!=""){
	$SQLi .= " - ".$algebraname;
}
if(isset($subalgebraname) && $subalgebraname!=""){
	$SQLi .= " - ".$subalgebraname;
}
if(isset($tamanhoname) && $tamanhoname!=""){
	$SQLi .= " - ".$tamanhoname;
}
if(isset($operacoesname) && $operacoesname!=""){
	$SQLi .= " - ".$operacoesname;
}
if(isset($operacoes1name) && $operacoes1name!=""){
	$SQLi .= " - ".$operacoes1name;
}
if(isset($multiplicacaoname) && $multiplicacaoname!=""){
	$SQLi .= " - ".$multiplicacaoname;
}	
if(isset($problemasname) && $problemasname!=""){
	$SQLi .= " - ".$problemasname;
}
if(isset($calculoname) && $calculoname!=""){
	$SQLi .= " - ".$calculoname;
}
if(isset($quantoperacoesname) && $quantoperacoesname!=""){
	$SQLi .= " - ".$quantoperacoesname;
}
if(isset($situacaoname) && $situacaoname!=""){
	$SQLi .= " - ".$situacaoname;
}
if(isset($subsituacaoname) && $subsituacaoname!=""){
	$SQLi .= " - ".$subsituacaoname;
}
if(isset($planilhaname) && $planilhaname!=""){
	$SQLi .= " - ".$planilhaname;
}

//--------------------------------------------------------------------------- CIEN
if(isset($ambiente1) && $ambiente1!=""){
	$SQLi .= $ambiente1name." - ";
}
if(isset($ambiente2) && $ambiente2!=""){
	$SQLi .= $ambiente2name." - ";
}
if(isset($subambiente) && $subambiente!=""){
	$SQLi .= $subambientename." - ";
}
if(isset($subambiente1) && $subambiente1!=""){
	$SQLi .= $subambiente1name." - ";
}
if(isset($tipoambiente) && $tipoambiente!=""){
	$SQLi .= $tipoambientename." - ";
}
if(isset($seres) && $seres!=""){
	$SQLi .= $seresname." - ";
}
if(isset($seres1) && $seres1!=""){
	$SQLi .= $seres1name." - ";
}
if(isset($abioticos) && $abioticos!=""){
	$SQLi .= $abioticosname." - ";
}
if(isset($subabioticos) && $subabioticos!=""){
	$SQLi .= $subabioticosname." - ";
}
if(isset($subabioticos1) && $subabioticos1!=""){
	$SQLi .= $subabioticos1name." - ";
}
if(isset($subabioticos1a) && $subabioticos1a!=""){
	$SQLi .= $subabioticos1aname." - ";
}
if(isset($bioticos) && $bioticos!=""){
	$SQLi .= $bioticosname." - ";
}
if(isset($taxonomia) && $taxonomia!=""){
	$SQLi .= $taxonomianame." - ";
}
if(isset($taxonomia1) && $taxonomia1!=""){
	$SQLi .= $taxonomia1name." - ";
}
if(isset($sintomas) && $sintomas!=""){
	$SQLi .= $sintomasname." - ";
}
if(isset($prevencao) && $prevencao!=""){
	$SQLi .= $prevencaoname." - ";
}
if(isset($transmissao) && $transmissao!=""){
	$SQLi .= $transmissaoname." - ";
}
if(isset($subtaxonomia) && $subtaxonomia!=""){
	$SQLi .= $subtaxonomianame." - ";
}
if(isset($subtaxonomia1) && $subtaxonomia1!=""){
	$SQLi .= $subtaxonomia1name." - ";
}
if(isset($subtaxonomia2) && $subtaxonomia2!=""){
	$SQLi .= $subtaxonomia2name." - ";
}
if(isset($subtaxonomia3) && $subtaxonomia3!=""){
	$SQLi .= $subtaxonomia3name." - ";
}
if(isset($sub1taxonomia) && $sub1taxonomia!=""){
	$SQLi .= $sub1taxonomianame." - ";
}
if(isset($sub1taxonomia1) && $sub1taxonomia1!=""){
	$SQLi .= $sub1taxonomia1name." - ";
}
if(isset($sub1taxonomia2) && $sub1taxonomia2!=""){
	$SQLi .= $sub1taxonomia2name." - ";
}
if(isset($sub1taxonomia3) && $sub1taxonomia3!=""){
	$SQLi .= $sub1taxonomia3name." - ";
}
if(isset($alimentacao) && $alimentacao!=""){
	$SQLi .= $alimentacaoname." - ";
}
if(isset($alimentacao1) && $alimentacao1!=""){
	$SQLi .= $alimentacao1name." - ";
}
if(isset($reproducao) && $reproducao!=""){
	$SQLi .= $reproducaoname." - ";
}
if(isset($subreproducao) && $subreproducao!=""){
	$SQLi .= $subreproducaoname." - ";
}
if(isset($locomocao) && $locomocao!=""){
	$SQLi .= $locomocaoname." - ";
}
if(isset($desenvolvimento) && $desenvolvimento!=""){
	$SQLi .= $desenvolvimentoname." - ";
}
if(isset($temperatura) && $temperatura!=""){
	$SQLi .= $temperaturaname." - ";
}
if(isset($esqueleto) && $esqueleto!=""){
	$SQLi .= $esqueletoname." - ";
}
if(isset($respiracao) && $respiracao!=""){
	$SQLi .= $respiracaoname." - ";
}
if(isset($sistemasname) && $sistemasname!=""){
	$SQLi .= $sistemasname." - ";
}
if(isset($subsistemasname) && $subsistemasname!=""){
	$SQLi .= $subsistemasname." - ";
}
if(isset($subsistemas1name) && $subsistemas1name!=""){
	$SQLi .= $subsistemas1name." - ";
}
if(isset($subsistemas2name) && $subsistemas2name!=""){
	$SQLi .= $subsistemas2name." - ";
}
if(isset($subsistemas3name) && $subsistemas3name!=""){
	$SQLi .= $subsistemas3name." - ";
}

if(isset($citologia) && $citologia!=""){
	$SQLi .= $citologianame." - ";
}
if(isset($subcitologia) && $subcitologia!=""){
	$SQLi .= $subcitologianame." - ";
}
if(isset($subcitologia1) && $subcitologia1!=""){
	$SQLi .= $subcitologia1name." - ";
}
if(isset($subcitologia2) && $subcitologia2!=""){
	$SQLi .= $subcitologia2name." - ";
}
if(isset($subcitologia3) && $subcitologia3!=""){
	$SQLi .= $subcitologia3name." - ";
}
if(isset($ecologia) && $ecologia!=""){
	$SQLi .= $ecologianame." - ";
}
if(isset($subecologia) && $subecologia!=""){
	$SQLi .= $subecologianame." - ";
}
if(isset($subecologia1) && $subecologia1!=""){
	$SQLi .= $subecologia1name." - ";
}
if(isset($subecologia1a) && $subecologia1a!=""){
	$SQLi .= $subecologia1aname." - ";
}
if(isset($subecologia2) && $subecologia2!=""){
	$SQLi .= $subecologia2name." - ";
}
if(isset($subecologia3) && $subecologia3!=""){
	$SQLi .= $subecologia3name." - ";
}

//---------------------------------------------------------------------------------------NEURO

if(isset($anatomia) && $anatomia!=""){
	$SQLi .= $anatomianame." - ";
}
if(isset($subanatomia) && $subanatomia!=""){
	$SQLi .= $subanatomianame." - ";
}

if(isset($cognicao) && $cognicao!=""){
	$SQLi .= $cognicaoname." - ";
}
if(isset($subcognicao) && $subcognicao!=""){
	$SQLi .= $subcognicaoname." - ";
}

if(isset($comportamento) && $comportamento!=""){
	$SQLi .= $comportamentoname." - ";
}
if(isset($subcomportamento) && $subcomportamento!=""){
	$SQLi .= $subcomportamentoname." - ";
}

if(isset($degeneracao) && $degeneracao!=""){
	$SQLi .= $degeneracaoname." - ";
}
if(isset($subdegeneracao) && $subdegeneracao!=""){
	$SQLi .= $subdegeneracaoname." - ";
}

if(isset($desenvolvimentoneuro) && $desenvolvimentoneuro!=""){
	$SQLi .= $desenvolvimentoneuroname." - ";
}
if(isset($subdesenvolvimento) && $subdesenvolvimento!=""){
	$SQLi .= $subdesenvolvimentoname." - ";
}

if(isset($evolucao) && $evolucao!=""){
	$SQLi .= $evolucaoname." - ";
}
if(isset($subevolucao) && $subevolucao!=""){
	$SQLi .= $subevolucaoname." - ";
}

if(isset($emocao) && $emocao!=""){
	$SQLi .= $emocaoname." - ";
}
if(isset($subemocao) && $subemocao!=""){
	$SQLi .= $subemocaoname." - ";
}

if(isset($fisiologia) && $fisiologia!=""){
	$SQLi .= $fisiologianame." - ";
}
if(isset($subfisiologia) && $subfisiologia!=""){
	$SQLi .= $subfisiologianame." - ";
}

if(isset($histologia) && $histologia!=""){
	$SQLi .= $histologianame." - ";
}
if(isset($subhistologia) && $subhistologia!=""){
	$SQLi .= $subhistologianame." - ";
}

if(isset($motor) && $motor!=""){
	$SQLi .= $motorname." - ";
}
if(isset($submotor) && $submotor!=""){
	$SQLi .= $submotorname." - ";
}

if(isset($sensorial) && $sensorial!=""){
	$SQLi .= $sensorialname." - ";
}
if(isset($subsensorial) && $subsensorial!=""){
	$SQLi .= $subsensorialname." - ";
}

if(isset($tecidos) && $tecidos!=""){
	$SQLi .= $tecidosname." - ";
}
if(isset($subtecidos) && $subtecidos!=""){
	$SQLi .= $subtecidosname;
}
if(isset($subtecidos1) && $subtecidos1!=""){
	$SQLi .= $subtecidos1name;
}
$SQLi .= "'";
?>