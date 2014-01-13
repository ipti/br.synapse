<?php
session_start();
$SQLsg = "SELECT id FROM goal ORDER BY id DESC";
$ressg = pg_query($SQLsg);
$linhasg = pg_fetch_array($ressg);
	
if(isset($habilidade) && $habilidade!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).", 1, ".$habilidade.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subhabilidade) && $subhabilidade!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).", 1, ".$subhabilidade.")";
	$resgc = pg_query($SQLgc);
}
if(isset($habilidade1) && $habilidade1!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  1, ".$habilidade1.")";
	$resgc = pg_query($SQLgc);
}
if(isset($condicoes) && $condicoes!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  3, ".$condicoes.")";
	$resgc = pg_query($SQLgc);
}
if(isset($modalidade) && $modalidade!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  1, ".$modalidade.")";
	$resgc = pg_query($SQLgc);
}
if(isset($submodalidade) && $submodalidade!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  1, ".$submodalidade.")";
	$resgc = pg_query($SQLgc);
}
if(isset($submodalidade1) && $submodalidade1!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  1, ".$submodalidade1.")";
	$resgc = pg_query($SQLgc);
}
if(isset($dimensao) && $dimensao!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$dimensao.");";
	$resgc = pg_query($SQLgc);
}
if(isset($dimensao1) && $dimensao1!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$dimensao1.");";
	$resgc = pg_query($SQLgc);
}
if(isset($dimensao2) && $dimensao2!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$dimensao2.");";
	$resgc = pg_query($SQLgc);
}
if(isset($dimensao3) && $dimensao3!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$dimensao3.");";
	$resgc = pg_query($SQLgc);
}
if(isset($dimensao4) && $dimensao4!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$dimensao4.");";
	$resgc = pg_query($SQLgc);
}

if(isset($oracaofuncao) && $oracaofuncao!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 307);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$oracaofuncao.");";
	$resgc = pg_query($SQLgc);
}
if(isset($oracaotipo) && $oracaotipo!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 314);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$oracaotipo.")";
	$resgc = pg_query($SQLgc);
}
if(isset($textotipo) && $textotipo!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 143);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$textotipo.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subtextotipo) && $subtextotipo!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subtextotipo.")";
	$resgc = pg_query($SQLgc);
}
if(isset($textogenero) && $textogenero!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 154);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$textogenero.")";
	$resgc = pg_query($SQLgc);
}
if(isset($conteudotexto) && $conteudotexto!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 167);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$conteudotexto.")";
	$resgc = pg_query($SQLgc);
}
if(isset($organizatexto) && $organizatexto!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 159);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$organizatexto.")";
	$resgc = pg_query($SQLgc);
}
if(isset($textocoesao) && $textocoesao!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 172);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$textocoesao.")";
	$resgc = pg_query($SQLgc);
}
if(isset($wordclass) && $wordclass!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 23);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$wordclass.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subwordclass) && $subwordclass!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subwordclass.")";
	$resgc = pg_query($SQLgc);
}
if(isset($quantoracao) && $quantoracao!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$quantoracao.")";
	$resgc = pg_query($SQLgc);
}
if(isset($sintaxfunction) && $sintaxfunction!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 34);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$sintaxfunction.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subsintaxfunction) && $subsintaxfunction!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subsintaxfunction.")";
	$resgc = pg_query($SQLgc);
}
if(isset($semanticrelation) && $semanticrelation!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 48);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$semanticrelation.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subsemanticrelation) && $subsemanticrelation!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subsemanticrelation.")";
	$resgc = pg_query($SQLgc);
}
if(isset($sub1semanticrelation) && $sub1semanticrelation!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$sub1semanticrelation.")";
	$resgc = pg_query($SQLgc);
}
if(isset($figuralinguagem) && $figuralinguagem!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 94);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$figuralinguagem.")";
	$resgc = pg_query($SQLgc);
}
if(isset($elementos) && $elementos!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 83);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$elementos.")";
	$resgc = pg_query($SQLgc);
}
//---------------------------------------------------------------------------------------------------------------------------------------MAT
if(isset($grandeza) && $grandeza!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 192);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$grandeza.")";
	$resgc = pg_query($SQLgc);
}
if(isset($grandeza1) && $grandeza1!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$grandeza1.")";
	$resgc = pg_query($SQLgc);
}
if(isset($medida) && $medida!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$medida.")";
	$resgc = pg_query($SQLgc);
}
if(isset($numero) && $numero!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 195);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$numero.")";
	$resgc = pg_query($SQLgc);
}

if(isset($geometria) && $geometria!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 194);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$geometria.")";
	$resgc = pg_query($SQLgc);
}
if(isset($partes) && $partes!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$partes.")";
	$resgc = pg_query($SQLgc);
}
if(isset($tipos) && $tipos!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$tipos.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subtipos) && $subtipos!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subtipos.")";
	$resgc = pg_query($SQLgc);
}
if(isset($cartesiano) && $cartesiano!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 452);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$cartesiano.")";
	$resgc = pg_query($SQLgc);
}	
if(isset($algebra) && $algebra!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 189);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$algebra.")";
	$resgc = pg_query($SQLgc);
}	
if(isset($subalgebra) && $subalgebra!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subalgebra.")";
	$resgc = pg_query($SQLgc);
}	

if(isset($tamanho) && $tamanho!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$tamanho.")";
	$resgc = pg_query($SQLgc);
}
if(isset($operacoes) && $operacoes!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 197);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$operacoes.")";
	$resgc = pg_query($SQLgc);
}
if(isset($operacoes1) && $operacoes1!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$operacoes1.")";
	$resgc = pg_query($SQLgc);
}
if(isset($multiplicacao) && $multiplicacao!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$multiplicacao.")";
	$resgc = pg_query($SQLgc);
}
if(isset($problemas) && $problemas!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 196);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$problemas.")";
	$resgc = pg_query($SQLgc);
}
if(isset($calculo) && $calculo!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  3, 257);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  3, ".$calculo.")";
	$resgc = pg_query($SQLgc);
}
if(isset($quantoperacoes) && $quantoperacoes!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$quantoperacoes.")";
	$resgc = pg_query($SQLgc);
}
if(isset($situacao) && $situacao!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$situacao.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subsituacao) && $subsituacao!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subsituacao.")";
	$resgc = pg_query($SQLgc);
}
if(isset($planilha) && $planilha!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$planilha.")";
	$resgc = pg_query($SQLgc);
}

//--------------------------------------------------------------------------------------------------------------------------------------- CIEN
if(isset($ambiente1) && $ambiente1!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 315);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$ambiente1.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subambiente) && $subambiente!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subambiente.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subambiente1) && $subambiente1!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subambiente1.")";
	$resgc = pg_query($SQLgc);
}
if(isset($ambiente2) && $ambiente2!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$ambiente2.")";
	$resgc = pg_query($SQLgc);
}
if(isset($tipoambiente) && $tipoambiente!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$tipoambiente.")";
	$resgc = pg_query($SQLgc);
}
if(isset($seres) && $seres!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 317);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$seres.")";
	$resgc = pg_query($SQLgc);
}
if(isset($seres1) && $seres1!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$seres1.")";
	$resgc = pg_query($SQLgc);
}
if(isset($abioticos) && $abioticos!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 317);";
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$abioticos.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subabioticos) && $subabioticos!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subabioticos.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subabioticos1) && $subabioticos1!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subabioticos1.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subabioticos1a) && $subabioticos1a!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subabioticos1a.")";
	$resgc = pg_query($SQLgc);
}
if(isset($bioticos) && $bioticos!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 317);";
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$bioticos.")";
	$resgc = pg_query($SQLgc);
}
if(isset($taxonomia) && $taxonomia!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 594);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$taxonomia.")";
	$resgc = pg_query($SQLgc);
}
if(isset($taxonomia1) && $taxonomia1!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$taxonomia1.")";
	$resgc = pg_query($SQLgc);
}
if(isset($sintomas) && $sintomas!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 880);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$sintomas.")";
	$resgc = pg_query($SQLgc);
}
if(isset($prevencao) && $prevencao!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 870);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$prevencao.")";
	$resgc = pg_query($SQLgc);
}
if(isset($transmissao) && $transmissao!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 864);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$transmissao.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subtaxonomia) && $subtaxonomia!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subtaxonomia.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subtaxonomia1) && $subtaxonomia1!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subtaxonomia1.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subtaxonomia2) && $subtaxonomia2!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subtaxonomia2.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subtaxonomia3) && $subtaxonomia3!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subtaxonomia3.")";
	$resgc = pg_query($SQLgc);
}
if(isset($sub1taxonomia) && $sub1taxonomia!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$sub1taxonomia.")";
	$resgc = pg_query($SQLgc);
}
if(isset($sub1taxonomia1) && $sub1taxonomia1!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$sub1taxonomia1.")";
	$resgc = pg_query($SQLgc);
}
if(isset($sub1taxonomia2) && $sub1taxonomia2!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$sub1taxonomia2.")";
	$resgc = pg_query($SQLgc);
}
if(isset($sub1taxonomia3) && $sub1taxonomia3!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$sub1taxonomia3.")";
	$resgc = pg_query($SQLgc);
}
if(isset($alimentacao) && $alimentacao!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 339);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$alimentacao.")";
	$resgc = pg_query($SQLgc);
}
if(isset($alimentacao1) && $alimentacao1!=""){
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$alimentacao1.")";
	$resgc = pg_query($SQLgc);
}
if(isset($reproducao) && $reproducao!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 769);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$reproducao.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subreproducao) && $subreproducao!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subreproducao.")";
	$resgc = pg_query($SQLgc);
}
if(isset($locomocao) && $locomocao!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 338);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$locomocao.")";
	$resgc = pg_query($SQLgc);
}
if(isset($desenvolvimento) && $desenvolvimento!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 556);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$desenvolvimento.")";
	$resgc = pg_query($SQLgc);
}
if(isset($temperatura) && $temperatura!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 554);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$temperatura.")";
	$resgc = pg_query($SQLgc);
}
if(isset($esqueleto) && $esqueleto!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 333);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$esqueleto.")";
	$resgc = pg_query($SQLgc);
}
if(isset($respiracao) && $respiracao!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 549);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$respiracao.")";
	$resgc = pg_query($SQLgc);
}
if(isset($sistemas) && $sistemas!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 1348);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$sistemas.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subsistemas) && $subsistemas!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subsistemas.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subsistemas1) && $subsistemas1!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subsistemas1.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subsistemas2) && $subsistemas2!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subsistemas2.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subsistemas3) && $subsistemas3!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subsistemas3.")";
	$resgc = pg_query($SQLgc);
}
if(isset($citologia) && $citologia!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 1068);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$citologia.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subcitologia) && $subcitologia!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subcitologia.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subcitologia1) && $subcitologia1!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subcitologia1.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subcitologia2) && $subcitologia2!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subcitologia2.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subcitologia3) && $subcitologia3!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subcitologia3.")";
	$resgc = pg_query($SQLgc);
}

if(isset($ecologia) && $ecologia!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 362);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$ecologia.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subecologia) && $subecologia!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subecologia.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subecologia1) && $subecologia1!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subecologia1.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subecologia1a) && $subecologia1a!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subecologia1a.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subecologia2) && $subecologia2!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subecologia2.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subecologia3) && $subecologia3!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subecologia3.")";
	$resgc = pg_query($SQLgc);
}

if(isset($anatomia) && $anatomia!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 1545);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$anatomia.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subanatomia) && $subanatomia!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subanatomia.")";
	$resgc = pg_query($SQLgc);
}

if(isset($cognicao) && $cognicao!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 1535);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$cognicao.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subcognicao) && $subcognicao!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subcognicao.")";
	$resgc = pg_query($SQLgc);
}

if(isset($comportamento) && $comportamento!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 1552);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$comportamento.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subcomportamento) && $subcomportamento!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subcomportamento.")";
	$resgc = pg_query($SQLgc);
}

if(isset($degeneracao) && $degeneracao!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 1538);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$degeneracao.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subdegeneracao) && $subdegeneracao!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subdegeneracao.")";
	$resgc = pg_query($SQLgc);
}

if(isset($desenvolvimentoneuro) && $desenvolvimentoneuro!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 1537);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$desenvolvimentoneuro.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subdesenvolvimento) && $subdesenvolvimento!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subdesenvolvimento.")";
	$resgc = pg_query($SQLgc);
}

if(isset($evolucao) && $evolucao!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 1606);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$evolucao.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subevolucao) && $subevolucao!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subevolucao.")";
	$resgc = pg_query($SQLgc);
}

if(isset($emocao) && $emocao!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 1544);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$emocao.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subemocao) && $subemocao!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subemocao.")";
	$resgc = pg_query($SQLgc);
}

if(isset($fisiologia) && $fisiologia!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 1546);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$fisiologia.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subfisiologia) && $subfisiologia!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subfisiologia.")";
	$resgc = pg_query($SQLgc);
}

if(isset($histologia) && $histologia!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 1536);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$histologia.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subhistologia) && $subhistologia!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subhistologia.")";
	$resgc = pg_query($SQLgc);
}

if(isset($motor) && $motor!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 1533);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$motor.")";
	$resgc = pg_query($SQLgc);
}
if(isset($submotor) && $submotor!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$submotor.")";
	$resgc = pg_query($SQLgc);
}

if(isset($sensorial) && $sensorial!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 1534);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$sensorial.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subsensorial) && $subsensorial!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subsensorial.")";
	$resgc = pg_query($SQLgc);
}

if(isset($tecidos) && $tecidos!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, 1273);";
	$SQLgc .= "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$tecidos.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subtecidos) && $subtecidos!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subtecidos.")";
	$resgc = pg_query($SQLgc);
}
if(isset($subtecidos1) && $subtecidos1!=""){
	$SQLgc = "INSERT INTO goal_content (goal_id, activitytype_id, activitycontent_id) VALUES (".(isset($goal_id)?$goal_id:$linhasg['id']).",  2, ".$subtecidos1.")";
	$resgc = pg_query($SQLgc);
}

$SQL = "SELECT id 
		FROM goal_content 
		WHERE goal_id = ".(isset($goal_id)?$goal_id:$linhasg['id'])."";
$res = pg_query($SQL);
if(pg_num_rows($res)>0){
	if($acao=="3"){
		$msg = "<h3 align='center'><font color='red'><strong>Objetivo Inserido com Sucesso</strong></font></h3>";
	}elseif($acao=="2"){
		$msg = "<h3 align='center'><font color='red'><strong>Objetivo Atualizado com Sucesso</strong></font></h3>";
	}
}else{
	$ERROgoal_ins = "<h3 align='center'><font color='red'>ERRO:</font> ".$SQLgc." <br> ".$SQL."</h3>";
	$ERROgoal_ins .= "<p align='center'><strong>Favor comunicar esse erro a <a href='mailto:fabio@enscer.com.br?subject=ERROgoal_ins&body=".$SQLi."'>fabio@enscer.com.br</a></strong></p>";
}
?>