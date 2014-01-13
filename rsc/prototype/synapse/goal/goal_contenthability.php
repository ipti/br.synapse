<?PHP
session_start();
//-------------------------------------------------------------------------------------- CAMPO CONTENTHABILITY
if(isset($habilidade) && $habilidade!=""){
		$SQL .= " AND (contenthability_id like '%#".$habilidade."#%')";
}
if(isset($subhabilidade) && $subhabilidade!=""){
		$SQL .= " AND (contenthability_id like '%#".$subhabilidade."#%')";
}
if(isset($habilidade1) && $habilidade1!=""){
		$SQL .= " AND (contenthability_id like '%#".$habilidade1."#%')";
}
if(isset($condicoes) && $condicoes!=""){
		$SQL .= " AND (contenthability_id like '%#".$condicoes."#%')";
}
//------------------------------------------------------------------------------- PORT
if(isset($dimensao) && $dimensao!=""){
		$SQL .= " AND (contenthability_id like '%#".$dimensao."#%')";
}
if(isset($dimensao1) && $dimensao1!=""){
		$SQL .= " AND (contenthability_id like '%#".$dimensao1."#%')";
}
if(isset($dimensao2) && $dimensao2!=""){
		$SQL .= " AND (contenthability_id like '%#".$dimensao2."#%')";
}
if(isset($dimensao3) && $dimensao3!=""){
		$SQL .= " AND (contenthability_id like '%#".$dimensao3."#%')";
}
if(isset($dimensao4) && $dimensao4!=""){
		$SQL .= " AND (contenthability_id like '%#".$dimensao4."#%')";
}
if(isset($oracaofuncao) && $oracaofuncao!=""){
		$SQL .= " AND (contenthability_id like '%#".$oracaofuncao."#%')";
}
if(isset($oracaotipo) && $oracaotipo!=""){
		$SQL .= " AND (contenthability_id like '%#".$oracaotipo."#%')";
}
if(isset($textotipo) && $textotipo!=""){
		$SQL .= " AND (contenthability_id like '%#".$textotipo."#%')";
}
if(isset($subtextotipo) && $subtextotipo!=""){
		$SQL .= " AND (contenthability_id like '%#".$subtextotipo."#%')";
}
if(isset($conteudotexto) && $conteudotexto!=""){
		$SQL .= " AND (contenthability_id like '%#".$conteudotexto."#%')";
}
if(isset($organizatexto) && $organizatexto!=""){
		$SQL .= " AND (contenthability_id like '%#".$organizatexto."#%')";
}
if(isset($textocoesao) && $textocoesao!=""){
		$SQL .= " AND (contenthability_id like '%#".$textocoesao."#%')";
}
if(isset($textogenero) && $textogenero!=""){
		$SQL .= " AND (contenthability_id like '%#".$textogenero."#%')";
}
if(isset($wordclass) && $wordclass!=""){
		$SQL .= " AND (contenthability_id like '%#".$wordclass."#%')";
}
if(isset($subwordclass) && $subwordclass!=""){
		$SQL .= " AND (contenthability_id like '%#".$subwordclass."#%')";
}
if(isset($quantoracao) && $quantoracao!=""){
		$SQL .= " AND (contenthability_id like '%#".$quantoracao."#%')";
}
if(isset($sintaxfunction) && $sintaxfunction!=""){
		$SQL .= " AND (contenthability_id like '%#".$sintaxfunction."#%')";
}
if(isset($subsintaxfunction) && $subsintaxfunction!=""){
		$SQL .= " AND (contenthability_id like '%#".$subsintaxfunction."#%')";
}
if(isset($semanticrelation) && $semanticrelation!=""){
		$SQL .= " AND (contenthability_id like '%#".$semanticrelation."#%')";
}
if(isset($subsemanticrelation) && $subsemanticrelation!=""){
		$SQL .= " AND (contenthability_id like '%#".$subsemanticrelation."#%')";
}
if(isset($sub1semanticrelation) && $sub1semanticrelation!=""){
		$SQL .= " AND (contenthability_id like '%#".$sub1semanticrelation."#%')";
}
if(isset($figuralinguagem) && $figuralinguagem!=""){
		$SQL .= " AND (contenthability_id like '%#".$figuralinguagem."#%')";
}
if(isset($modalidade) && $modalidade!=""){
		$SQL .= " AND (contenthability_id like '%#".$modalidade."#%')";
}
if(isset($submodalidade) && $submodalidade!=""){
		$SQL .= " AND (contenthability_id like '%#".$submodalidade."#%')";
}
if(isset($submodalidade1) && $submodalidade1!=""){
		$SQL .= " AND (contenthability_id like '%#".$submodalidade1."#%')";
}
if(isset($elementos) && $elementos!=""){
		$SQL .= " AND (contenthability_id like '%#".$elementos."#%')";
}
//----------------------------------------------------------------------------- MAT
if(isset($grandeza) && $grandeza!=""){
		$SQL .= " AND (contenthability_id like '%#".$grandeza."#%')";
}
if(isset($grandeza1) && $grandeza1!=""){
		$SQL .= " AND (contenthability_id like '%#".$grandeza1."#%')";
}
if(isset($medida) && $medida!=""){
		$SQL .= " AND (contenthability_id like '%#".$medida."#%')";
}
if(isset($numero) && $numero!=""){
		$SQL .= " AND (contenthability_id like '%#".$numero."#%')";
}
if(isset($geometria) && $geometria!=""){
		$SQL .= " AND (contenthability_id like '%#".$geometria."#%')";
}	
if(isset($partes) && $partes!=""){
		$SQL .= " AND (contenthability_id like '%#".$partes."#%')";
}
if(isset($tipos) && $tipos!=""){
		$SQL .= " AND (contenthability_id like '%#".$tipos."#%')";
}
if(isset($subtipos) && $subtipos!=""){
		$SQL .= " AND (contenthability_id like '%#".$subtipos."#%')";
}
if(isset($cartesiano) && $cartesiano!=""){
		$SQL .= " AND (contenthability_id like '%#".$cartesiano."#%')";
}
if(isset($algebra) && $algebra!=""){
		$SQL .= " AND (contenthability_id like '%#".$algebra."#%')";
}
if(isset($subalgebra) && $subalgebra!=""){
		$SQL .= " AND (contenthability_id like '%#".$subalgebra."#%')";
}
if(isset($tamanho) && $tamanho!=""){
		$SQL .= " AND (contenthability_id like '%#".$tamanho."#%')";
}
if(isset($operacoes) && $operacoes!=""){
		$SQL .= " AND (contenthability_id like '%#".$operacoes."#%')";
}
if(isset($operacoes1) && $operacoes1!=""){
		$SQL .= " AND (contenthability_id like '%#".$operacoes1."#%')";
}
if(isset($multiplicacao) && $multiplicacao!=""){
		$SQL .= " AND (contenthability_id like '%#".$multiplicacao."#%')";
}
if(isset($calculo) && $calculo!=""){
		$SQL .= " AND (contenthability_id like '%#".$calculo."#%')";
}
if(isset($problemas) && $problemas!=""){
		$SQL .= " AND (contenthability_id like '%#".$problemas."#%')";
}
if(isset($quantoperacoes) && $quantoperacoes!=""){
		$SQL .= " AND (contenthability_id like '%#".$quantoperacoes."#%')";
}
if(isset($situacao) && $situacao!=""){
		$SQL .= " AND (contenthability_id like '%#".$situacao."#%')";
}
if(isset($subsituacao) && $subsituacao!=""){
		$SQL .= " AND (contenthability_id like '%#".$subsituacao."#%')";
}
if(isset($planilha) && $planilha!=""){
		$SQL .= " AND (contenthability_id like '%#".$planilha."#%')";
}

//----------------------------------------------------------------------------- CIEN
if(isset($ambiente1) && $ambiente1!=""){
		$SQL .= " AND (contenthability_id like '%#".$ambiente1."#%')";
}
if(isset($ambiente2) && $ambiente2!=""){
		$SQL .= " AND (contenthability_id like '%#".$ambiente2."#%')";
}
if(isset($subambiente) && $subambiente!=""){
		$SQL .= " AND (contenthability_id like '%#".$subambiente."#%')";
}
if(isset($subambiente1) && $subambiente1!=""){
		$SQL .= " AND (contenthability_id like '%#".$subambiente1."#%')";
}
if(isset($tipoambiente) && $tipoambiente!=""){
		$SQL .= " AND (contenthability_id like '%#".$tipoambiente."#%')";
}
if(isset($seres) && $seres!=""){
		$SQL .= " AND (contenthability_id like '%#".$seres."#%')";
}
if(isset($seres1) && $seres1!=""){
		$SQL .= " AND (contenthability_id like '%#".$seres1."#%')";
}
if(isset($abioticos) && $abioticos!=""){
		$SQL .= " AND (contenthability_id like '%#".$abioticos."#%')";
}
if(isset($subabioticos) && $subabioticos!=""){
		$SQL .= " AND (contenthability_id like '%#".$subabioticos."#%')";
}
if(isset($subabioticos1) && $subabioticos1!=""){
		$SQL .= " AND (contenthability_id like '%#".$subabioticos1."#%')";
}
if(isset($subabioticos1a) && $subabioticos1a!=""){
		$SQL .= " AND (contenthability_id like '%#".$subabioticos1a."#%')";
}
if(isset($bioticos) && $bioticos!=""){
		$SQL .= " AND (contenthability_id like '%#".$bioticos."#%')";
}
if(isset($taxonomia) && $taxonomia!=""){
		$SQL .= " AND (contenthability_id like '%#".$taxonomia."#%')";
}
if(isset($taxonomia1) && $taxonomia1!=""){
		$SQL .= " AND (contenthability_id like '%#".$taxonomia1."#%')";
}
if(isset($sintomas) && $sintomas!=""){
		$SQL .= " AND (contenthability_id like '%#".$sintomas."#%')";
}
if(isset($prevencao) && $prevencao!=""){
		$SQL .= " AND (contenthability_id like '%#".$prevencao."#%')";
}
if(isset($transmissao) && $transmissao!=""){
		$SQL .= " AND (contenthability_id like '%#".$transmissao."#%')";
}
if(isset($subtaxonomia) && $subtaxonomia!=""){
		$SQL .= " AND (contenthability_id like '%#".$subtaxonomia."#%')";
}
if(isset($subtaxonomia1) && $subtaxonomia1!=""){
		$SQL .= " AND (contenthability_id like '%#".$subtaxonomia1."#%')";
}
if(isset($subtaxonomia2) && $subtaxonomia2!=""){
		$SQL .= " AND (contenthability_id like '%#".$subtaxonomia2."#%')";
}
if(isset($subtaxonomia3) && $subtaxonomia3!=""){
		$SQL .= " AND (contenthability_id like '%#".$subtaxonomia3."#%')";
}
if(isset($sub1taxonomia) && $sub1taxonomia!=""){
		$SQL .= " AND (contenthability_id like '%#".$sub1taxonomia."#%')";
}
if(isset($sub1taxonomia1) && $sub1taxonomia1!=""){
		$SQL .= " AND (contenthability_id like '%#".$sub1taxonomia1."#%')";
}
if(isset($sub1taxonomia2) && $sub1taxonomia2!=""){
		$SQL .= " AND (contenthability_id like '%#".$sub1taxonomia2."#%')";
}
if(isset($sub1taxonomia3) && $sub1taxonomia3!=""){
		$SQL .= " AND (contenthability_id like '%#".$sub1taxonomia3."#%')";
}
if(isset($alimentacao) && $alimentacao!=""){
		$SQL .= " AND (contenthability_id like '%#".$alimentacao."#%')";
}
if(isset($alimentacao1) && $alimentacao1!=""){
		$SQL .= " AND (contenthability_id like '%#".$alimentacao1."#%')";
}
if(isset($reproducao) && $reproducao!=""){
		$SQL .= " AND (contenthability_id like '%#".$reproducao."#%')";
}
if(isset($subreproducao) && $subreproducao!=""){
		$SQL .= " AND (contenthability_id like '%#".$subreproducao."#%')";
}
if(isset($locomocao) && $locomocao!=""){
		$SQL .= " AND (contenthability_id like '%#".$locomocao."#%')";
}
if(isset($desenvolvimento) && $desenvolvimento!=""){
		$SQL .= " AND (contenthability_id like '%#".$desenvolvimento."#%')";
}
if(isset($temperatura) && $temperatura!=""){
		$SQL .= " AND (contenthability_id like '%#".$temperatura."#%')";
}
if(isset($esqueleto) && $esqueleto!=""){
		$SQL .= " AND (contenthability_id like '%#".$esqueleto."#%')";
}
if(isset($respiracao) && $respiracao!=""){
		$SQL .= " AND (contenthability_id like '%#".$respiracao."#%')";
}
if(isset($sistemas) && $sistemas!=""){
		$SQL .= " AND (contenthability_id like '%#".$sistemas."#%')";
}
if(isset($subsistemas) && $subsistemas!=""){
		$SQL .= " AND (contenthability_id like '%#".$subsistemas."#%')";	
}
if(isset($subsistemas1) && $subsistemas1!=""){
		$SQL .= " AND (contenthability_id like '%#".$subsistemas1."#%')";
}
if(isset($subsistemas2) && $subsistemas2!=""){
		$SQL .= " AND (contenthability_id like '%#".$subsistemas2."#%')";
}
if(isset($subsistemas3) && $subsistemas3!=""){
		$SQL .= " AND (contenthability_id like '%#".$subsistemas3."#%')";
}
if(isset($citologia) && $citologia!=""){
		$SQL .= " AND (contenthability_id like '%#".$citologia."#%')";
}
if(isset($subcitologia) && $subcitologia!=""){
		$SQL .= " AND (contenthability_id like '%#".$subcitologia."#%')";
}
if(isset($subcitologia1) && $subcitologia1!=""){
		$SQL .= " AND (contenthability_id like '%#".$subcitologia1."#%')";
}
if(isset($subcitologia2) && $subcitologia2!=""){
		$SQL .= " AND (contenthability_id like '%#".$subcitologia2."#%')";
}
if(isset($subcitologia3) && $subcitologia3!=""){
		$SQL .= " AND (contenthability_id like '%#".$subcitologia3."#%')";
}
if(isset($ecologia) && $ecologia!=""){
		$SQL .= " AND (contenthability_id like '%#".$ecologia."#%')";
}
if(isset($subecologia) && $subecologia!=""){
		$SQL .= " AND (contenthability_id like '%#".$subecologia."#%')";
}
if(isset($subecologia1) && $subecologia1!=""){
		$SQL .= " AND (contenthability_id like '%#".$subecologia1."#%')";
}
if(isset($subecologia1a) && $subecologia1a!=""){
		$SQL .= " AND (contenthability_id like '%#".$subecologia1a."#%')";
}
if(isset($subecologia2) && $subecologia2!=""){
		$SQL .= " AND (contenthability_id like '%#".$subecologia2."#%')";
}
if(isset($subecologia3) && $subecologia3!=""){
		$SQL .= " AND (contenthability_id like '%#".$subecologia3."#%')";
}

//---------------------------------------------------------------------------------------NEURO

if(isset($anatomia) && $anatomia!=""){
		$SQL .= " AND (contenthability_id like '%#".$anatomia."#%')";
}
if(isset($subanatomia) && $subanatomia!=""){
		$SQL .= " AND (contenthability_id like '%#".$subanatomia."#%')";
}
if(isset($cognicao) && $cognicao!=""){
		$SQL .= " AND (contenthability_id like '%#".$cognicao."#%')";
}
if(isset($subcognicao) && $subcognicao!=""){
		$SQL .= " AND (contenthability_id like '%#".$subcognicao."#%')";
}
if(isset($comportamento) && $comportamento!=""){
		$SQL .= " AND (contenthability_id like '%#".$comportamento."#%')";
}
if(isset($subcomportamento) && $subcomportamento!=""){
		$SQL .= " AND (contenthability_id like '%#".$subcomportamento."#%')";
}
if(isset($degeneracao) && $degeneracao!=""){
		$SQL .= " AND (contenthability_id like '%#".$degeneracao."#%')";
}
if(isset($subdegeneracao) && $subdegeneracao!=""){
		$SQL .= " AND (contenthability_id like '%#".$subdegeneracao."#%')";
}
if(isset($desenvolvimentoneuro) && $desenvolvimentoneuro!=""){
		$SQL .= " AND (contenthability_id like '%#".$desenvolvimentoneuro."#%')";
}
if(isset($subdesenvolvimento) && $subdesenvolvimento!=""){
		$SQL .= " AND (contenthability_id like '%#".$subdesenvolvimento."#%')";
}
if(isset($evolucao) && $evolucao!=""){
		$SQL .= " AND (contenthability_id like '%#".$evolucao."#%')";
}
if(isset($subevolucao) && $subevolucao!=""){
		$SQL .= " AND (contenthability_id like '%#".$subevolucao."#%')";
}
if(isset($emocao) && $emocao!=""){
		$SQL .= " AND (contenthability_id like '%#".$emocao."#%')";
}
if(isset($subemocao) && $subemocao!=""){
		$SQL .= " AND (contenthability_id like '%#".$subemocao."#%')";
}
if(isset($fisiologia) && $fisiologia!=""){
		$SQL .= " AND (contenthability_id like '%#".$fisiologia."#%')";
}
if(isset($subfisiologia) && $subfisiologia!=""){
		$SQL .= " AND (contenthability_id like '%#".$subfisiologia."#%')";
}	
if(isset($histologia) && $histologia!=""){
		$SQL .= " AND (contenthability_id like '%#".$histologia."#%')";
}
if(isset($subhistologia) && $subhistologia!=""){
		$SQL .= " AND (contenthability_id like '%#".$subhistologia."#%')";
}
if(isset($motor) && $motor!=""){
		$SQL .= " AND (contenthability_id like '%#".$motor."#%')";
}
if(isset($submotor) && $submotor!=""){
		$SQL .= " AND (contenthability_id like '%#".$submotor."#%')";
}
if(isset($sensorial) && $sensorial!=""){
		$SQL .= " AND (contenthability_id like '%#".$sensorial."#%')";
}
if(isset($subsensorial) && $subsensorial!=""){
		$SQL .= " AND (contenthability_id like '%#".$subsensorial."#%')";
}	
if(isset($tecidos) && $tecidos!=""){
		$SQL .= " AND (contenthability_id like '%#".$tecidos."#%')";
}
if(isset($subtecidos) && $subtecidos!=""){
		$SQL .= " AND (contenthability_id like '%#".$subtecidos."#%')";
}
if(isset($subtecidos1) && $subtecidos1!=""){
		$SQL .= " AND (contenthability_id like '%#".$subtecidos1."#%')";
}
//-------------------------------------------------------------------------------------- //CAMPO CONTENTHABILITY
//$SQL .= " AND contenthability_id like '%#23#%'";
?>