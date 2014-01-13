<?PHP
session_start();
//-------------------------------------------------------------------------------------- CAMPO CONTENTHABILITY
if(isset($habilidade) && $habilidade!=""){
		$SQLc .= " AND (contenthability_id like '%#".$habilidade."#%')";
}
if(isset($subhabilidade) && $subhabilidade!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subhabilidade."#%')";
}
if(isset($habilidade1) && $habilidade1!=""){
		$SQLc .= " AND (contenthability_id like '%#".$habilidade1."#%')";
}
if(isset($condicoes) && $condicoes!=""){
		$SQLc .= " AND (contenthability_id like '%#".$condicoes."#%')";
}
//------------------------------------------------------------------------------- PORT
if(isset($dimensao) && $dimensao!=""){
		$SQLc .= " AND (contenthability_id like '%#".$dimensao."#%')";
}
if(isset($dimensao1) && $dimensao1!=""){
		$SQLc .= " AND (contenthability_id like '%#".$dimensao1."#%')";
}
if(isset($dimensao2) && $dimensao2!=""){
		$SQLc .= " AND (contenthability_id like '%#".$dimensao2."#%')";
}
if(isset($dimensao3) && $dimensao3!=""){
		$SQLc .= " AND (contenthability_id like '%#".$dimensao3."#%')";
}
if(isset($dimensao4) && $dimensao4!=""){
		$SQLc .= " AND (contenthability_id like '%#".$dimensao4."#%')";
}
if(isset($oracaofuncao) && $oracaofuncao!=""){
		$SQLc .= " AND (contenthability_id like '%#".$oracaofuncao."#%')";
}
if(isset($oracaotipo) && $oracaotipo!=""){
		$SQLc .= " AND (contenthability_id like '%#".$oracaotipo."#%')";
}
if(isset($textotipo) && $textotipo!=""){
		$SQLc .= " AND (contenthability_id like '%#".$textotipo."#%')";
}
if(isset($subtextotipo) && $subtextotipo!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subtextotipo."#%')";
}
if(isset($conteudotexto) && $conteudotexto!=""){
		$SQLc .= " AND (contenthability_id like '%#".$conteudotexto."#%')";
}
if(isset($organizatexto) && $organizatexto!=""){
		$SQLc .= " AND (contenthability_id like '%#".$organizatexto."#%')";
}
if(isset($textocoesao) && $textocoesao!=""){
		$SQLc .= " AND (contenthability_id like '%#".$textocoesao."#%')";
}
if(isset($textogenero) && $textogenero!=""){
		$SQLc .= " AND (contenthability_id like '%#".$textogenero."#%')";
}
if(isset($wordclass) && $wordclass!=""){
		$SQLc .= " AND (contenthability_id like '%#".$wordclass."#%')";
}
if(isset($subwordclass) && $subwordclass!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subwordclass."#%')";
}
if(isset($quantoracao) && $quantoracao!=""){
		$SQLc .= " AND (contenthability_id like '%#".$quantoracao."#%')";
}
if(isset($sintaxfunction) && $sintaxfunction!=""){
		$SQLc .= " AND (contenthability_id like '%#".$sintaxfunction."#%')";
}
if(isset($subsintaxfunction) && $subsintaxfunction!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subsintaxfunction."#%')";
}
if(isset($semanticrelation) && $semanticrelation!=""){
		$SQLc .= " AND (contenthability_id like '%#".$semanticrelation."#%')";
}
if(isset($subsemanticrelation) && $subsemanticrelation!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subsemanticrelation."#%')";
}
if(isset($sub1semanticrelation) && $sub1semanticrelation!=""){
		$SQLc .= " AND (contenthability_id like '%#".$sub1semanticrelation."#%')";
}
if(isset($figuralinguagem) && $figuralinguagem!=""){
		$SQLc .= " AND (contenthability_id like '%#".$figuralinguagem."#%')";
}
if(isset($modalidade) && $modalidade!=""){
		$SQLc .= " AND (contenthability_id like '%#".$modalidade."#%')";
}
if(isset($submodalidade) && $submodalidade!=""){
		$SQLc .= " AND (contenthability_id like '%#".$submodalidade."#%')";
}
if(isset($submodalidade1) && $submodalidade1!=""){
		$SQLc .= " AND (contenthability_id like '%#".$submodalidade1."#%')";
}
if(isset($elementos) && $elementos!=""){
		$SQLc .= " AND (contenthability_id like '%#".$elementos."#%')";
}
//----------------------------------------------------------------------------- MAT
if(isset($grandeza) && $grandeza!=""){
		$SQLc .= " AND (contenthability_id like '%#".$grandeza."#%')";
}
if(isset($grandeza1) && $grandeza1!=""){
		$SQLc .= " AND (contenthability_id like '%#".$grandeza1."#%')";
}
if(isset($medida) && $medida!=""){
		$SQLc .= " AND (contenthability_id like '%#".$medida."#%')";
}
if(isset($numero) && $numero!=""){
		$SQLc .= " AND (contenthability_id like '%#".$numero."#%')";
}
if(isset($geometria) && $geometria!=""){
		$SQLc .= " AND (contenthability_id like '%#".$geometria."#%')";
}	
if(isset($partes) && $partes!=""){
		$SQLc .= " AND (contenthability_id like '%#".$partes."#%')";
}
if(isset($tipos) && $tipos!=""){
		$SQLc .= " AND (contenthability_id like '%#".$tipos."#%')";
}
if(isset($subtipos) && $subtipos!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subtipos."#%')";
}
if(isset($cartesiano) && $cartesiano!=""){
		$SQLc .= " AND (contenthability_id like '%#".$cartesiano."#%')";
}
if(isset($algebra) && $algebra!=""){
		$SQLc .= " AND (contenthability_id like '%#".$algebra."#%')";
}
if(isset($subalgebra) && $subalgebra!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subalgebra."#%')";
}
if(isset($tamanho) && $tamanho!=""){
		$SQLc .= " AND (contenthability_id like '%#".$tamanho."#%')";
}
if(isset($operacoes) && $operacoes!=""){
		$SQLc .= " AND (contenthability_id like '%#".$operacoes."#%')";
}
if(isset($operacoes1) && $operacoes1!=""){
		$SQLc .= " AND (contenthability_id like '%#".$operacoes1."#%')";
}
if(isset($multiplicacao) && $multiplicacao!=""){
		$SQLc .= " AND (contenthability_id like '%#".$multiplicacao."#%')";
}
if(isset($calculo) && $calculo!=""){
		$SQLc .= " AND (contenthability_id like '%#".$calculo."#%')";
}
if(isset($problemas) && $problemas!=""){
		$SQLc .= " AND (contenthability_id like '%#".$problemas."#%')";
}
if(isset($quantoperacoes) && $quantoperacoes!=""){
		$SQLc .= " AND (contenthability_id like '%#".$quantoperacoes."#%')";
}
if(isset($situacao) && $situacao!=""){
		$SQLc .= " AND (contenthability_id like '%#".$situacao."#%')";
}
if(isset($subsituacao) && $subsituacao!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subsituacao."#%')";
}
if(isset($planilha) && $planilha!=""){
		$SQLc .= " AND (contenthability_id like '%#".$planilha."#%')";
}

//----------------------------------------------------------------------------- CIEN
if(isset($ambiente1) && $ambiente1!=""){
		$SQLc .= " AND (contenthability_id like '%#".$ambiente1."#%')";
}
if(isset($ambiente2) && $ambiente2!=""){
		$SQLc .= " AND (contenthability_id like '%#".$ambiente2."#%')";
}
if(isset($subambiente) && $subambiente!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subambiente."#%')";
}
if(isset($subambiente1) && $subambiente1!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subambiente1."#%')";
}
if(isset($tipoambiente) && $tipoambiente!=""){
		$SQLc .= " AND (contenthability_id like '%#".$tipoambiente."#%')";
}
if(isset($seres) && $seres!=""){
		$SQLc .= " AND (contenthability_id like '%#".$seres."#%')";
}
if(isset($seres1) && $seres1!=""){
		$SQLc .= " AND (contenthability_id like '%#".$seres1."#%')";
}
if(isset($abioticos) && $abioticos!=""){
		$SQLc .= " AND (contenthability_id like '%#".$abioticos."#%')";
}
if(isset($subabioticos) && $subabioticos!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subabioticos."#%')";
}
if(isset($subabioticos1) && $subabioticos1!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subabioticos1."#%')";
}
if(isset($subabioticos1a) && $subabioticos1a!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subabioticos1a."#%')";
}
if(isset($bioticos) && $bioticos!=""){
		$SQLc .= " AND (contenthability_id like '%#".$bioticos."#%')";
}
if(isset($taxonomia) && $taxonomia!=""){
		$SQLc .= " AND (contenthability_id like '%#".$taxonomia."#%')";
}
if(isset($taxonomia1) && $taxonomia1!=""){
		$SQLc .= " AND (contenthability_id like '%#".$taxonomia1."#%')";
}
if(isset($sintomas) && $sintomas!=""){
		$SQLc .= " AND (contenthability_id like '%#".$sintomas."#%')";
}
if(isset($prevencao) && $prevencao!=""){
		$SQLc .= " AND (contenthability_id like '%#".$prevencao."#%')";
}
if(isset($transmissao) && $transmissao!=""){
		$SQLc .= " AND (contenthability_id like '%#".$transmissao."#%')";
}
if(isset($subtaxonomia) && $subtaxonomia!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subtaxonomia."#%')";
}
if(isset($subtaxonomia1) && $subtaxonomia1!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subtaxonomia1."#%')";
}
if(isset($subtaxonomia2) && $subtaxonomia2!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subtaxonomia2."#%')";
}
if(isset($subtaxonomia3) && $subtaxonomia3!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subtaxonomia3."#%')";
}
if(isset($sub1taxonomia) && $sub1taxonomia!=""){
		$SQLc .= " AND (contenthability_id like '%#".$sub1taxonomia."#%')";
}
if(isset($sub1taxonomia1) && $sub1taxonomia1!=""){
		$SQLc .= " AND (contenthability_id like '%#".$sub1taxonomia1."#%')";
}
if(isset($sub1taxonomia2) && $sub1taxonomia2!=""){
		$SQLc .= " AND (contenthability_id like '%#".$sub1taxonomia2."#%')";
}
if(isset($sub1taxonomia3) && $sub1taxonomia3!=""){
		$SQLc .= " AND (contenthability_id like '%#".$sub1taxonomia3."#%')";
}
if(isset($alimentacao) && $alimentacao!=""){
		$SQLc .= " AND (contenthability_id like '%#".$alimentacao."#%')";
}
if(isset($alimentacao1) && $alimentacao1!=""){
		$SQLc .= " AND (contenthability_id like '%#".$alimentacao1."#%')";
}
if(isset($reproducao) && $reproducao!=""){
		$SQLc .= " AND (contenthability_id like '%#".$reproducao."#%')";
}
if(isset($subreproducao) && $subreproducao!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subreproducao."#%')";
}
if(isset($locomocao) && $locomocao!=""){
		$SQLc .= " AND (contenthability_id like '%#".$locomocao."#%')";
}
if(isset($desenvolvimento) && $desenvolvimento!=""){
		$SQLc .= " AND (contenthability_id like '%#".$desenvolvimento."#%')";
}
if(isset($temperatura) && $temperatura!=""){
		$SQLc .= " AND (contenthability_id like '%#".$temperatura."#%')";
}
if(isset($esqueleto) && $esqueleto!=""){
		$SQLc .= " AND (contenthability_id like '%#".$esqueleto."#%')";
}
if(isset($respiracao) && $respiracao!=""){
		$SQLc .= " AND (contenthability_id like '%#".$respiracao."#%')";
}
if(isset($sistemas) && $sistemas!=""){
		$SQLc .= " AND (contenthability_id like '%#".$sistemas."#%')";
}
if(isset($subsistemas) && $subsistemas!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subsistemas."#%')";	
}
if(isset($subsistemas1) && $subsistemas1!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subsistemas1."#%')";
}
if(isset($subsistemas2) && $subsistemas2!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subsistemas2."#%')";
}
if(isset($subsistemas3) && $subsistemas3!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subsistemas3."#%')";
}
if(isset($citologia) && $citologia!=""){
		$SQLc .= " AND (contenthability_id like '%#".$citologia."#%')";
}
if(isset($subcitologia) && $subcitologia!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subcitologia."#%')";
}
if(isset($subcitologia1) && $subcitologia1!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subcitologia1."#%')";
}
if(isset($subcitologia2) && $subcitologia2!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subcitologia2."#%')";
}
if(isset($subcitologia3) && $subcitologia3!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subcitologia3."#%')";
}
if(isset($ecologia) && $ecologia!=""){
		$SQLc .= " AND (contenthability_id like '%#".$ecologia."#%')";
}
if(isset($subecologia) && $subecologia!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subecologia."#%')";
}
if(isset($subecologia1) && $subecologia1!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subecologia1."#%')";
}
if(isset($subecologia1a) && $subecologia1a!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subecologia1a."#%')";
}
if(isset($subecologia2) && $subecologia2!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subecologia2."#%')";
}
if(isset($subecologia3) && $subecologia3!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subecologia3."#%')";
}

//---------------------------------------------------------------------------------------NEURO

if(isset($anatomia) && $anatomia!=""){
		$SQLc .= " AND (contenthability_id like '%#".$anatomia."#%')";
}
if(isset($subanatomia) && $subanatomia!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subanatomia."#%')";
}
if(isset($cognicao) && $cognicao!=""){
		$SQLc .= " AND (contenthability_id like '%#".$cognicao."#%')";
}
if(isset($subcognicao) && $subcognicao!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subcognicao."#%')";
}
if(isset($comportamento) && $comportamento!=""){
		$SQLc .= " AND (contenthability_id like '%#".$comportamento."#%')";
}
if(isset($subcomportamento) && $subcomportamento!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subcomportamento."#%')";
}
if(isset($degeneracao) && $degeneracao!=""){
		$SQLc .= " AND (contenthability_id like '%#".$degeneracao."#%')";
}
if(isset($subdegeneracao) && $subdegeneracao!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subdegeneracao."#%')";
}
if(isset($desenvolvimentoneuro) && $desenvolvimentoneuro!=""){
		$SQLc .= " AND (contenthability_id like '%#".$desenvolvimentoneuro."#%')";
}
if(isset($subdesenvolvimento) && $subdesenvolvimento!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subdesenvolvimento."#%')";
}
if(isset($evolucao) && $evolucao!=""){
		$SQLc .= " AND (contenthability_id like '%#".$evolucao."#%')";
}
if(isset($subevolucao) && $subevolucao!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subevolucao."#%')";
}
if(isset($emocao) && $emocao!=""){
		$SQLc .= " AND (contenthability_id like '%#".$emocao."#%')";
}
if(isset($subemocao) && $subemocao!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subemocao."#%')";
}
if(isset($fisiologia) && $fisiologia!=""){
		$SQLc .= " AND (contenthability_id like '%#".$fisiologia."#%')";
}
if(isset($subfisiologia) && $subfisiologia!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subfisiologia."#%')";
}	
if(isset($histologia) && $histologia!=""){
		$SQLc .= " AND (contenthability_id like '%#".$histologia."#%')";
}
if(isset($subhistologia) && $subhistologia!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subhistologia."#%')";
}
if(isset($motor) && $motor!=""){
		$SQLc .= " AND (contenthability_id like '%#".$motor."#%')";
}
if(isset($submotor) && $submotor!=""){
		$SQLc .= " AND (contenthability_id like '%#".$submotor."#%')";
}
if(isset($sensorial) && $sensorial!=""){
		$SQLc .= " AND (contenthability_id like '%#".$sensorial."#%')";
}
if(isset($subsensorial) && $subsensorial!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subsensorial."#%')";
}	
if(isset($tecidos) && $tecidos!=""){
		$SQLc .= " AND (contenthability_id like '%#".$tecidos."#%')";
}
if(isset($subtecidos) && $subtecidos!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subtecidos."#%')";
}
if(isset($subtecidos1) && $subtecidos1!=""){
		$SQLc .= " AND (contenthability_id like '%#".$subtecidos1."#%')";
}
//-------------------------------------------------------------------------------------- //CAMPO CONTENTHABILITY
//$SQLc .= " AND contenthability_id like '%#23#%'";
?>