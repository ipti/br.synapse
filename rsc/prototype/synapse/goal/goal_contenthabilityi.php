<?PHP
session_start();
//-------------------------------------------------------------------------------------- CAMPO CONTENTHABILITY
if(isset($habilidade) && $habilidade!=""){
	if($acao=="2" || $acao=="3"){
		$contenthability_id .= $habilidade."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$habilidade."#%')";
	}
}
if(isset($subhabilidade) && $subhabilidade!=""){
	if($acao=="2" || $acao=="3"){
		$contenthability_id .= $subhabilidade."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subhabilidade."#%')";
	}
}
if(isset($habilidade1) && $habilidade1!=""){
	if($acao=="2" || $acao=="3"){
		$contenthability_id .= $habilidade1."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$habilidade1."#%')";
	}
}
if(isset($condicoes) && $condicoes!=""){
	if($acao=="2" || $acao=="3"){
		$contenthability_id .= $condicoes."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$condicoes."#%')";
	}
}
//------------------------------------------------------------------------------- PORT
if(isset($dimensao) && $dimensao!=""){
	if($acao=="2" || $acao=="3"){
		$contenthability_id .= "1#".$dimensao."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$dimensao."#%')";
	}
}
if(isset($dimensao1) && $dimensao1!=""){
	if($acao=="2" || $acao=="3"){
		$contenthability_id .= $dimensao1."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$dimensao1."#%')";
	}
}
if(isset($dimensao2) && $dimensao2!=""){
	if($acao=="2" || $acao=="3"){
		$contenthability_id .= $dimensao2."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$dimensao2."#%')";
	}
}
if(isset($dimensao3) && $dimensao3!=""){
	if($acao=="2" || $acao=="3"){	
		$contenthability_id .= $dimensao3."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$dimensao3."#%')";
	}
}
if(isset($dimensao4) && $dimensao4!=""){
	if($acao=="2" || $acao=="3"){	
		$contenthability_id .= $dimensao4."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$dimensao4."#%')";
	}
}
if(isset($oracaofuncao) && $oracaofuncao!=""){
	if($acao=="2" || $acao=="3"){	
		$contenthability_id .= "307#".$oracaofuncao."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$oracaofuncao."#%')";
	}
}
if(isset($oracaotipo) && $oracaotipo!=""){
	if($acao=="2" || $acao=="3"){	
		$contenthability_id .= "314#".$oracaotipo."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$oracaotipo."#%')";
	}
}
if(isset($textotipo) && $textotipo!=""){
	if($acao=="2" || $acao=="3"){	
		$contenthability_id .= "143#".$textotipo."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$textotipo."#%')";
	}
}
if(isset($subtextotipo) && $subtextotipo!=""){
	if($acao=="2" || $acao=="3"){	
		$contenthability_id .= $subtextotipo."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subtextotipo."#%')";
	}
}
if(isset($conteudotexto) && $conteudotexto!=""){
	if($acao=="2" || $acao=="3"){	
		$contenthability_id .= "167#".$conteudotexto."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$conteudotexto."#%')";
	}
}
if(isset($organizatexto) && $organizatexto!=""){
	if($acao=="2" || $acao=="3"){	
		$contenthability_id .= "159#".$organizatexto."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$organizatexto."#%')";
	}
}
if(isset($textocoesao) && $textocoesao!=""){
	if($acao=="2" || $acao=="3"){	
		$contenthability_id .= "172#".$textocoesao."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$textocoesao."#%')";
	}
}
if(isset($textogenero) && $textogenero!=""){
	if($acao=="2" || $acao=="3"){	
		$contenthability_id .= "154#".$textogenero."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$textogenero."#%')";
	}
}
if(isset($wordclass) && $wordclass!=""){
	if($acao=="2" || $acao=="3"){	
		$contenthability_id .= "23#".$wordclass."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$wordclass."#%')";
	}
}
if(isset($subwordclass) && $subwordclass!=""){
	if($acao=="2" || $acao=="3"){	
		$contenthability_id .= $subwordclass."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subwordclass."#%')";
	}
}
if(isset($quantoracao) && $quantoracao!=""){
	if($acao=="2" || $acao=="3"){	
		$contenthability_id .= $quantoracao."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$quantoracao."#%')";
	}
}
if(isset($sintaxfunction) && $sintaxfunction!=""){
	if($acao=="2" || $acao=="3"){	
		$contenthability_id .= "34#".$sintaxfunction."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$sintaxfunction."#%')";
	}
}
if(isset($subsintaxfunction) && $subsintaxfunction!=""){
	if($acao=="2" || $acao=="3"){	
		$contenthability_id .= $subsintaxfunction."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subsintaxfunction."#%')";
	}
}
if(isset($semanticrelation) && $semanticrelation!=""){
	if($acao=="2" || $acao=="3"){	
		$contenthability_id .= "48#".$semanticrelation."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$semanticrelation."#%')";
	}
}
if(isset($subsemanticrelation) && $subsemanticrelation!=""){
	if($acao=="2" || $acao=="3"){	
		$contenthability_id .= $subsemanticrelation."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subsemanticrelation."#%')";
	}
}
if(isset($sub1semanticrelation) && $sub1semanticrelation!=""){
	if($acao=="2" || $acao=="3"){	
		$contenthability_id .= $sub1semanticrelation."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$sub1semanticrelation."#%')";
	}
}
if(isset($figuralinguagem) && $figuralinguagem!=""){
	if($acao=="2" || $acao=="3"){	
		$contenthability_id .= "94#".$figuralinguagem."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$figuralinguagem."#%')";
	}
}
if(isset($modalidade) && $modalidade!=""){
	if($acao=="2" || $acao=="3"){	
		$contenthability_id .= $modalidade."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$modalidade."#%')";
	}
}
if(isset($submodalidade) && $submodalidade!=""){
	if($acao=="2" || $acao=="3"){	
		$contenthability_id .= $submodalidade."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$submodalidade."#%')";
	}
}
if(isset($submodalidade1) && $submodalidade1!=""){
	if($acao=="2" || $acao=="3"){	
		$contenthability_id .= $submodalidade1."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$submodalidade1."#%')";
	}
}
if(isset($elementos) && $elementos!=""){
	if($acao=="2" || $acao=="3"){	
		$contenthability_id .= "83#".$elementos."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$elementos."#%')";
	}
}
//----------------------------------------------------------------------------- MAT
if(isset($grandeza) && $grandeza!=""){
	if($acao=="2" || $acao=="3"){	
		$contenthability_id .= "192#".$grandeza."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$grandeza."#%')";
	}
}
if(isset($grandeza1) && $grandeza1!=""){
	if($acao=="2" || $acao=="3"){	
		$contenthability_id .= $grandeza1."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$grandeza1."#%')";
	}
}
if(isset($medida) && $medida!=""){
	if($acao=="2" || $acao=="3"){	
		$contenthability_id .= $medida."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$medida."#%')";
	}
}
if(isset($numero) && $numero!=""){
	if($acao=="2" || $acao=="3"){	
		$contenthability_id .= "195#".$numero."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$numero."#%')";
	}
}
if(isset($geometria) && $geometria!=""){
	if($acao=="2" || $acao=="3"){	
		$contenthability_id .= "194#".$geometria."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$geometria."#%')";
	}
}	
if(isset($partes) && $partes!=""){
	if($acao=="2" || $acao=="3"){	
		$contenthability_id .= $partes."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$partes."#%')";
	}
}
if(isset($tipos) && $tipos!=""){
	if($acao=="2" || $acao=="3"){		
		$contenthability_id .= $tipos."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$tipos."#%')";
	}
}
if(isset($subtipos) && $subtipos!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subtipos."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subtipos."#%')";
	}
}
if(isset($cartesiano) && $cartesiano!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "452#".$cartesiano."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$cartesiano."#%')";
	}
}
if(isset($algebra) && $algebra!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "189#".$algebra."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$algebra."#%')";
	}
}
if(isset($subalgebra) && $subalgebra!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subalgebra."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subalgebra."#%')";
	}
}
if(isset($tamanho) && $tamanho!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $tamanho."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$tamanho."#%')";
	}
}
if(isset($operacoes) && $operacoes!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "197#".$operacoes."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$operacoes."#%')";
	}
}
if(isset($operacoes1) && $operacoes1!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $operacoes1."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$operacoes1."#%')";
	}
}
if(isset($multiplicacao) && $multiplicacao!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $multiplicacao."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$multiplicacao."#%')";
	}
}
if(isset($calculo) && $calculo!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "257#".$calculo."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$calculo."#%')";
	}
}
if(isset($problemas) && $problemas!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "196#".$problemas."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$problemas."#%')";
	}
}
if(isset($quantoperacoes) && $quantoperacoes!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $quantoperacoes."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$quantoperacoes."#%')";
	}
}
if(isset($situacao) && $situacao!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $situacao."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$situacao."#%')";
	}
}
if(isset($subsituacao) && $subsituacao!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subsituacao."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subsituacao."#%')";
	}
}

if(isset($planilha) && $planilha!=""){
	if($acao=="2" || $acao=="3"){				
		$contenthability_id .= "191#".$planilha."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$planilha."#%')";
	}
}

//----------------------------------------------------------------------------- CIEN
if(isset($ambiente1) && $ambiente1!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "315#".$ambiente1."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$ambiente1."#%')";
	}
}
if(isset($ambiente2) && $ambiente2!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $ambiente2."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$ambiente2."#%')";
	}
}
if(isset($subambiente) && $subambiente!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subambiente."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subambiente."#%')";
	}
}
if(isset($subambiente1) && $subambiente1!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subambiente1."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subambiente1."#%')";
	}
}
if(isset($tipoambiente) && $tipoambiente!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $tipoambiente."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$tipoambiente."#%')";
	}
}
if(isset($seres) && $seres!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "317#".$seres."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$seres."#%')";
	}
}
if(isset($seres1) && $seres1!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $seres1."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$seres1."#%')";
	}
}
if(isset($abioticos) && $abioticos!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "317#".$abioticos."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$abioticos."#%')";
	}
}
if(isset($subabioticos) && $subabioticos!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subabioticos."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subabioticos."#%')";
	}
}
if(isset($subabioticos1) && $subabioticos1!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subabioticos1."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subabioticos1."#%')";
	}
}
if(isset($subabioticos1a) && $subabioticos1a!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subabioticos1a."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subabioticos1a."#%')";
	}
}
if(isset($bioticos) && $bioticos!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "317#".$bioticos."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$bioticos."#%')";
	}
}
if(isset($taxonomia) && $taxonomia!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "594#".$taxonomia."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$taxonomia."#%')";
	}
}
if(isset($taxonomia1) && $taxonomia1!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $taxonomia1."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$taxonomia1."#%')";
	}
}
if(isset($sintomas) && $sintomas!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "880#".$sintomas."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$sintomas."#%')";
	}
}
if(isset($prevencao) && $prevencao!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "870#".$prevencao."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$prevencao."#%')";
	}
}
if(isset($transmissao) && $transmissao!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "864#".$transmissao."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$transmissao."#%')";
	}
}
if(isset($subtaxonomia) && $subtaxonomia!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subtaxonomia."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subtaxonomia."#%')";
	}
}
if(isset($subtaxonomia1) && $subtaxonomia1!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subtaxonomia1."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subtaxonomia1."#%')";
	}
}
if(isset($subtaxonomia2) && $subtaxonomia2!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subtaxonomia2."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subtaxonomia2."#%')";
	}
}
if(isset($subtaxonomia3) && $subtaxonomia3!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subtaxonomia3."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subtaxonomia3."#%')";
	}
}
if(isset($sub1taxonomia) && $sub1taxonomia!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $sub1taxonomia."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$sub1taxonomia."#%')";
	}
}
if(isset($sub1taxonomia1) && $sub1taxonomia1!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $sub1taxonomia1."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$sub1taxonomia1."#%')";
	}
}
if(isset($sub1taxonomia2) && $sub1taxonomia2!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $sub1taxonomia2."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$sub1taxonomia2."#%')";
	}
}
if(isset($sub1taxonomia3) && $sub1taxonomia3!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $sub1taxonomia3."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$sub1taxonomia3."#%')";
	}
}
if(isset($alimentacao) && $alimentacao!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "339#".$alimentacao."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$alimentacao."#%')";
	}
}
if(isset($alimentacao1) && $alimentacao1!=""){
	if($acao=="2" || $acao=="3"){
		$contenthability_id .= $alimentacao1."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$alimentacao1."#%')";
	}
}
if(isset($reproducao) && $reproducao!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "769#".$reproducao."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$reproducao."#%')";
	}
}
if(isset($subreproducao) && $subreproducao!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subreproducao."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subreproducao."#%')";
	}
}
if(isset($locomocao) && $locomocao!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "338#".$locomocao."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$locomocao."#%')";
	}
}
if(isset($desenvolvimento) && $desenvolvimento!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "556#".$desenvolvimento."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$desenvolvimento."#%')";
	}
}
if(isset($temperatura) && $temperatura!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "554#".$temperatura."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$temperatura."#%')";
	}
}
if(isset($esqueleto) && $esqueleto!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "333#".$esqueleto."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$esqueleto."#%')";
	}
}
if(isset($respiracao) && $respiracao!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "549#".$respiracao."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$respiracao."#%')";
	}
}
if(isset($sistemas) && $sistemas!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "1348#".$sistemas."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$sistemas."#%')";
	}
}
if(isset($subsistemas) && $subsistemas!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subsistemas."#";
}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subsistemas."#%')";
	}	
}
if(isset($subsistemas1) && $subsistemas1!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subsistemas1."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subsistemas1."#%')";
	}
}
if(isset($subsistemas2) && $subsistemas2!=""){
	if($acao=="2" || $acao=="3"){				
		$contenthability_id .= $subsistemas2."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subsistemas2."#%')";
	}
}
if(isset($subsistemas3) && $subsistemas3!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subsistemas3."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subsistemas3."#%')";
	}
}
if(isset($citologia) && $citologia!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "1068#".$citologia."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$citologia."#%')";
	}
}
if(isset($subcitologia) && $subcitologia!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subcitologia."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subcitologia."#%')";
	}
}
if(isset($subcitologia1) && $subcitologia1!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subcitologia1."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subcitologia1."#%')";
	}
}
if(isset($subcitologia2) && $subcitologia2!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subcitologia2."#";	
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subcitologia2."#%')";
	}
}
if(isset($subcitologia3) && $subcitologia3!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subcitologia3."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subcitologia3."#%')";
	}
}
if(isset($ecologia) && $ecologia!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "362#".$ecologia."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$ecologia."#%')";
	}
}
if(isset($subecologia) && $subecologia!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subecologia."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subecologia."#%')";
	}
}
if(isset($subecologia1) && $subecologia1!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subecologia1."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subecologia1."#%')";
	}
}
if(isset($subecologia1a) && $subecologia1a!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subecologia1a."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subecologia1a."#%')";
	}
}
if(isset($subecologia2) && $subecologia2!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subecologia2."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subecologia2."#%')";
	}
}
if(isset($subecologia3) && $subecologia3!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subecologia3."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subecologia3."#%')";
	}
}

//---------------------------------------------------------------------------------------NEURO

if(isset($anatomia) && $anatomia!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "1545#".$anatomia."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$anatomia."#%')";
	}
}
if(isset($subanatomia) && $subanatomia!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subanatomia."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subanatomia."#%')";
	}
}
if(isset($cognicao) && $cognicao!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "1535#".$cognicao."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$cognicao."#%')";
	}
}
if(isset($subcognicao) && $subcognicao!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subcognicao."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subcognicao."#%')";
	}
}
if(isset($comportamento) && $comportamento!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "1552#".$comportamento."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$comportamento."#%')";
	}
}
if(isset($subcomportamento) && $subcomportamento!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subcomportamento."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subcomportamento."#%')";
	}
}
if(isset($degeneracao) && $degeneracao!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "1538#".$degeneracao."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$degeneracao."#%')";
	}
}
if(isset($subdegeneracao) && $subdegeneracao!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subdegeneracao."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subdegeneracao."#%')";
	}
}
if(isset($desenvolvimentoneuro) && $desenvolvimentoneuro!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "1537#".$desenvolvimentoneuro."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$desenvolvimentoneuro."#%')";
	}
}
if(isset($subdesenvolvimento) && $subdesenvolvimento!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subdesenvolvimento."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subdesenvolvimento."#%')";
	}
}
if(isset($evolucao) && $evolucao!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "1606#".$evolucao."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$evolucao."#%')";
	}
}
if(isset($subevolucao) && $subevolucao!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subevolucao."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subevolucao."#%')";
	}
}
if(isset($emocao) && $emocao!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "1544#".$emocao."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$emocao."#%')";
	}
}
if(isset($subemocao) && $subemocao!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subemocao."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subemocao."#%')";
	}
}
if(isset($fisiologia) && $fisiologia!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "1546#".$fisiologia."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$fisiologia."#%')";
	}
}
if(isset($subfisiologia) && $subfisiologia!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subfisiologia."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subfisiologia."#%')";
	}
}	
if(isset($histologia) && $histologia!=""){
	if($acao=="2" || $acao=="3"){		
		$contenthability_id .= "1536#".$histologia."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$histologia."#%')";
	}
}
if(isset($subhistologia) && $subhistologia!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subhistologia."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subhistologia."#%')";
	}
}
if(isset($motor) && $motor!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "1533#".$motor."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$motor."#%')";
	}
}
if(isset($submotor) && $submotor!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $submotor."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$submotor."#%')";
	}
}
if(isset($sensorial) && $sensorial!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "1534#".$sensorial."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$sensorial."#%')";
	}
}
if(isset($subsensorial) && $subsensorial!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subsensorial."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subsensorial."#%')";
	}
}	
if(isset($tecidos) && $tecidos!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= "1273#".$tecidos."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$tecidos."#%')";
	}
}
if(isset($subtecidos) && $subtecidos!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subtecidos."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subtecidos."#%')";
	}
}
if(isset($subtecidos1) && $subtecidos1!=""){
	if($acao=="2" || $acao=="3"){			
		$contenthability_id .= $subtecidos1."#";
	}elseif($acao=="1"){
		$contenthability_id .= " AND (contenthability_id like '%#".$subtecidos1."#%')";
	}
}
//-------------------------------------------------------------------------------------- //CAMPO CONTENTHABILITY
//$contenthability_id .= " AND contenthability_id like '%#23#%'";
?>