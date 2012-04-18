<?php
session_start();
if(isset($dimensao) && $dimensao!=""){
	$SQLi .= "1#".$dimensao."#";
}
if(isset($dimensao1) && $dimensao1!=""){
	$SQLi .= $dimensao1."#";
}
if(isset($dimensao2) && $dimensao2!=""){
	$SQLi .= $dimensao2."#";
}
if(isset($dimensao3) && $dimensao3!=""){
	$SQLi .= $dimensao3."#";
}
if(isset($dimensao4) && $dimensao4!=""){
	$SQLi .= $dimensao4."#";
}
if(isset($oracaofuncao) && $oracaofuncao!=""){
	$SQLi .= "307#".$oracaofuncao."#";
}
if(isset($oracaotipo) && $oracaotipo!=""){
	$SQLi .= "314#".$oracaotipo."#";
}
if(isset($textotipo) && $textotipo!=""){
	$SQLi .= "143#".$textotipo."#";
}
if(isset($subtextotipo) && $subtextotipo!=""){
	$SQLi .= $subtextotipo."#";
}
if(isset($textogenero) && $textogenero!=""){
	$SQLi .= "154#".$textogenero."#";
}
if(isset($conteudotexto) && $conteudotexto!=""){
	$SQLi .= "167#".$conteudotexto."#";
}
if(isset($organizatexto) && $organizatexto!=""){
	$SQLi .= "159#".$organizatexto."#";
}
if(isset($textocoesao) && $textocoesao!=""){
	$SQLi .= "172#".$textocoesao."#";
}
if(isset($wordclass) && $wordclass!=""){
	$SQLi .= "23#".$wordclass."#";
}
if(isset($subwordclass) && $subwordclass!=""){
	$SQLi .= $subwordclass."#";
}
if(isset($quantoracao) && $quantoracao!=""){
	$SQLi .= $quantoracao."#";
}
if(isset($sintaxfunction) && $sintaxfunction!=""){
	$SQLi .= "34#".$sintaxfunction."#";
}
if(isset($subsintaxfunction) && $subsintaxfunction!=""){
	$SQLi .= $subsintaxfunction."#";
}
if(isset($semanticrelation) && $semanticrelation!=""){
	$SQLi .= "48#".$semanticrelation."#";
}
if(isset($subsemanticrelation) && $subsemanticrelation!=""){
	$SQLi .= $subsemanticrelation."#";
}
if(isset($sub1semanticrelation) && $sub1semanticrelation!=""){
	$SQLi .= $sub1semanticrelation."#";
}
if(isset($figuralinguagem) && $figuralinguagem!=""){
	$SQLi .= "94#".$figuralinguagem."#";
}
if(isset($modalidade) && $modalidade!=""){
	$SQLi .= $modalidade."#";
}
if(isset($submodalidade) && $submodalidade!=""){
	$SQLi .= $submodalidade."#";
}
if(isset($submodalidade1) && $submodalidade1!=""){
	$SQLi .= $submodalidade1."#";
}
if(isset($elementos) && $elementos!=""){
	$SQLi .= "83#".$elementos."#";
}
//----------------------------------------------------------------------------- MAT
if(isset($grandeza) && $grandeza!=""){
	$SQLi .= "192#".$grandeza."#";
}
if(isset($grandeza1) && $grandeza1!=""){
	$SQLi .= $grandeza1."#";
}
if(isset($medida) && $medida!=""){
	$SQLi .= $medida."#";
}
if(isset($numero) && $numero!=""){
	$SQLi .= "195#".$numero."#";
}
if(isset($geometria) && $geometria!=""){
	$SQLi .= "194#".$geometria."#";
}
if(isset($partes) && $partes!=""){
	$SQLi .= $partes."#";
}
if(isset($tipos) && $tipos!=""){
	$SQLi .= $tipos."#";
}
if(isset($subtipos) && $subtipos!=""){
	$SQLi .= $subtipos."#";
}
if(isset($cartesiano) && $cartesiano!=""){
	$SQLi .= "452#".$cartesiano."#";
}
if(isset($algebra) && $algebra!=""){
	$SQLi .= "189#".$algebra."#";
}
if(isset($subalgebra) && $subalgebra!=""){
	$SQLi .= $subalgebra."#";
}
if(isset($tamanho) && $tamanho!=""){
	$SQLi .= $tamanho."#";
}
if(isset($operacoes) && $operacoes!=""){
	$SQLi .= "197#".$operacoes."#";
}
if(isset($operacoes1) && $operacoes1!=""){
	$SQLi .= $operacoes1."#";
}
if(isset($multiplicacao) && $multiplicacao!=""){
	$SQLi .= $multiplicacao."#";
}
if(isset($problemas) && $problemas!=""){
	$SQLi .= "196#".$problemas."#";
}
if(isset($calculo) && $calculo!=""){
	$SQLi .= "257#".$calculo."#";
}
if(isset($quantoperacoes) && $quantoperacoes!=""){
	$SQLi .= $quantoperacoes."#";
}
if(isset($situacao) && $situacao!=""){
	$SQLi .= $situacao."#";
}
if(isset($subsituacao) && $subsituacao!=""){
	$SQLi .= $subsituacao."#";
}
if(isset($planilha) && $planilha!=""){
	$SQLi .= "191#".$planilha."#";
}

//----------------------------------------------------------------------------- CIEN
if(isset($ambiente1) && $ambiente1!=""){
	$SQLi .= "315#".$ambiente1."#";
}
if(isset($ambiente2) && $ambiente2!=""){
	$SQLi .= $ambiente2."#";
}
if(isset($subambiente) && $subambiente!=""){
	$SQLi .= $subambiente."#";
}
if(isset($subambiente1) && $subambiente1!=""){
	$SQLi .= $subambiente1."#";
}	
if(isset($tipoambiente) && $tipoambiente!=""){
	$SQLi .= $tipoambiente."#";
}
if(isset($seres) && $seres!=""){
	$SQLi .= "317#".$seres."#";
}
if(isset($seres1) && $seres1!=""){
	$SQLi .= $seres1."#";
}
if(isset($abioticos) && $abioticos!=""){
	$SQLi .= "317#".$abioticos."#";
}
if(isset($subabioticos) && $subabioticos!=""){
	$SQLi .= $subabioticos."#";
}
if(isset($subabioticos1) && $subabioticos1!=""){
	$SQLi .= $subabioticos1."#";
}
if(isset($subabioticos1a) && $subabioticos1a!=""){
	$SQLi .= $subabioticos1a."#";
}
if(isset($bioticos) && $bioticos!=""){
	$SQLi .= "317#".$bioticos."#";
}
if(isset($taxonomia) && $taxonomia!=""){
	$SQLi .= "594#".$taxonomia."#";
}
if(isset($taxonomia1) && $taxonomia1!=""){
	$SQLi .= $taxonomia."#";
}
if(isset($sintomas) && $sintomas!=""){
	$SQLi .= "880#".$sintomas."#";
}
if(isset($prevencao) && $prevencao!=""){
	$SQLi .= "870#".$prevencao."#";
}
if(isset($transmissao) && $transmissao!=""){
	$SQLi .= "864#".$transmissao."#";
}
if(isset($subtaxonomia) && $subtaxonomia!=""){
	$SQLi .= $subtaxonomia."#";
}
if(isset($subtaxonomia1) && $subtaxonomia1!=""){
	$SQLi .= $subtaxonomia1."#";
}
if(isset($subtaxonomia2) && $subtaxonomia2!=""){
	$SQLi .= $subtaxonomia2."#";
}
if(isset($subtaxonomia3) && $subtaxonomia3!=""){
	$SQLi .= $subtaxonomia3."#";
}
if(isset($sub1taxonomia) && $sub1taxonomia!=""){
	$SQLi .= $sub1taxonomia."#";
}
if(isset($sub1taxonomia1) && $sub1taxonomia1!=""){
	$SQLi .= $sub1taxonomia1."#";
}
if(isset($sub1taxonomia2) && $sub1taxonomia2!=""){
	$SQLi .= $sub1taxonomia2."#";
}
if(isset($sub1taxonomia3) && $sub1taxonomia3!=""){
	$SQLi .= $sub1taxonomia3."#";
}
if(isset($alimentacao) && $alimentacao!=""){
	$SQLi .= "339#".$alimentacao."#";
}
if(isset($alimentacao1) && $alimentacao1!=""){
	$SQLi .= $alimentacao1."#";
}
if(isset($reproducao) && $reproducao!=""){
	$SQLi .= "769#".$reproducao."#";
}
if(isset($subreproducao) && $subreproducao!=""){
	$SQLi .= $subreproducao."#";
}
if(isset($locomocao) && $locomocao!=""){
	$SQLi .= "338#".$locomocao."#";
}
if(isset($desenvolvimento) && $desenvolvimento!=""){
	$SQLi .= "556#".$desenvolvimento."#";
}
if(isset($temperatura) && $temperatura!=""){
	$SQLi .= "554#".$temperatura."#";
}
if(isset($esqueleto) && $esqueleto!=""){
	$SQLi .= "333#".$esqueleto."#";
}
if(isset($respiracao) && $respiracao!=""){
	$SQLi .= "549#".$respiracao."#";
}
if(isset($sistemas) && $sistemas!=""){
	$SQLi .= "1348#".$sistemas."#";
}
if(isset($subsistemas) && $subsistemas!=""){
	$SQLi .= $subsistemas."#";
}
if(isset($subsistemas1) && $subsistemas1!=""){
	$SQLi .= $subsistemas1."#";
}
if(isset($subsistemas2) && $subsistemas2!=""){
	$SQLi .= $subsistemas2."#";
}
if(isset($subsistemas3) && $subsistemas3!=""){
	$SQLi .= $subsistemas3."#";
}
if(isset($citologia) && $citologia!=""){
	$SQLi .= "1068#".$citologia."#";
}
if(isset($subcitologia) && $subcitologia!=""){
	$SQLi .= $subcitologia."#";
}
if(isset($subcitologia1) && $subcitologia1!=""){
	$SQLi .= $subcitologia1."#";
}
if(isset($subcitologia2) && $subcitologia2!=""){
	$SQLi .= $subcitologia2."#";
}
if(isset($subcitologia3) && $subcitologia3!=""){
	$SQLi .= $subcitologia3."#";
}
if(isset($ecologia) && $ecologia!=""){
	$SQLi .= "362#".$ecologia."#";
}
if(isset($subecologia) && $subecologia!=""){
	$SQLi .= $subecologia."#";
}
if(isset($subecologia1) && $subecologia1!=""){
	$SQLi .= $subecologia1."#";
}
if(isset($subecologia1a) && $subecologia1a!=""){
	$SQLi .= $subecologia1a."#";
}
if(isset($subecologia2) && $subecologia2!=""){
	$SQLi .= $subecologia2."#";
}
if(isset($subecologia3) && $subecologia3!=""){
	$SQLi .= $subecologia3."#";
}

//---------------------------------------------------------------------------------------NEURO

if(isset($anatomia) && $anatomia!=""){
	$SQLi .= "1545#".$anatomia."#";
}
if(isset($subanatomia) && $subanatomia!=""){
	$SQLi .= $subanatomia."#";
}

if(isset($cognicao) && $cognicao!=""){
	$SQLi .= "1535#".$cognicao."#";
}
if(isset($subcognicao) && $subcognicao!=""){
	$SQLi .= $subcognicao."#";
}

if(isset($comportamento) && $comportamento!=""){
	$SQLi .= "1552#".$comportamento."#";
}
if(isset($subcomportamento) && $subcomportamento!=""){
	$SQLi .= $subcomportamento."#";
}

if(isset($degeneracao) && $degeneracao!=""){
	$SQLi .= "1538#".$degeneracao."#";
}
if(isset($subdegeneracao) && $subdegeneracao!=""){
	$SQLi .= $subdegeneracao."#";
}

if(isset($desenvolvimentoneuro) && $desenvolvimentoneuro!=""){
	$SQLi .= "1537#".$desenvolvimentoneuro."#";
}
if(isset($subdesenvolvimento) && $subdesenvolvimento!=""){
	$SQLi .= $subdesenvolvimento."#";
}

if(isset($evolucao) && $evolucao!=""){
	$SQLi .= "1606#".$evolucao."#";
}
if(isset($subevolucao) && $subevolucao!=""){
	$SQLi .= $subevolucao."#";
}

if(isset($emocao) && $emocao!=""){
	$SQLi .= "1544#".$emocao."#";
}
if(isset($subemocao) && $subemocao!=""){
	$SQLi .= $subemocao."#";
}

if(isset($fisiologia) && $fisiologia!=""){
	$SQLi .= "1546#".$fisiologia."#";
}
if(isset($subfisiologia) && $subfisiologia!=""){
	$SQLi .= $subfisiologia."#";
}

if(isset($histologia) && $histologia!=""){
	$SQLi .= "1536#".$histologia."#";
}
if(isset($subhistologia) && $subhistologia!=""){
	$SQLi .= $subhistologia."#";
}

if(isset($motor) && $motor!=""){
	$SQLi .= "1533#".$motor."#";
}
if(isset($submotor) && $submotor!=""){
	$SQLi .= $submotor."#";
}

if(isset($sensorial) && $sensorial!=""){
	$SQLi .= "1534#".$sensorial."#";
}
if(isset($subsensorial) && $subsensorial!=""){
	$SQLi .= $subsensorial."#";
}

if(isset($tecidos) && $tecidos!=""){
	$SQLi .= "1273#".$tecidos."#";
}
if(isset($subtecidos) && $subtecidos!=""){
	$SQLi .= $subtecidos."#";
}
if(isset($subtecidos1) && $subtecidos1!=""){
	$SQLi .= $subtecidos1."#";
}
?>