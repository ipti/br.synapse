<?php

echo (isset($filtrocontent) && $filtrocontent==true?"&filtrocontent=true":"");
echo (isset($discipline) && $discipline!=""?"&discipline=".$discipline:"");

echo (isset($degreegrade) && $degreegrade!=""?"&degreegrade=".$degreegrade:"");
echo (isset($degreeblock) && $degreeblock!=""?"&degreeblock=".$degreeblock:"");
echo (isset($degreestage) && $degreestage!=""?"&degreestage=".$degreestage:"");

echo (isset($hability_id) && $hability_id!=""?"&hability_id=".$hability_id:"");

echo (isset($dimension)&& $dimension!=""?"&dimension=".$dimension:"");
echo (isset($dimensao1)&& $dimension1!=""?"&dimensao1=".$dimensao1:"");
echo (isset($dimensao2)&& $dimension2!=""?"&dimensao2=".$dimensao2:"");
echo (isset($dimensao3)&& $dimension3!=""?"&dimensao3=".$dimensao3:"");
echo (isset($dimensao4)&& $dimension4!=""?"&dimensao4=".$dimensao4:"");
echo (isset($wordclass)&& $wordclass!=""?"&wordclass=".$wordclass:"");
echo (isset($subwordclass) && $subwordclass!=""?"&subwordclass=".$subwordclass:"");
echo (isset($oracaotipo) && $oracaotipo!=""?"&oracaotipo=".$oracaotipo:"");
echo (isset($oracaofuncao) && $oracaofuncao!=""?"&oracaofuncao=".$oracaofuncao:"");
echo (isset($quantoracao) && $quantoracao!=""?"&quantoracao=".$quantoracao:"");
echo (isset($sintaxfunction) && $sintaxfunction!=""?"&sintaxfunction=".$sintaxfunction:"");
echo (isset($subsintaxfunction) && $subsintaxfunction!=""?"&subsintaxfunction=".$subsintaxfunction:"");
echo (isset($semanticrelation) && $semanticrelation!=""?"&semanticrelation=".$semanticrelation:"");
echo (isset($subsemanticrelation) && $subsemanticrelation!=""?"&subsemanticrelation=".$subsemanticrelation:"");
echo (isset($sub1semanticrelation) && $sub1semanticrelation!=""?"&sub1semanticrelation=".$sub1semanticrelation:"");
echo (isset($figuraslinguagem) && $figuraslinguagem!=""?"&figuraslinguagem=".$figuraslinguagem:"");
echo (isset($textotipo) && $textotipo!=""?"&textotipo=".$textotipo:"");
echo (isset($subtextotipo) && $subtextotipo!=""?"&subtextotipo=".$subtextotipo:"");
echo (isset($textogenero) && $textogenero!=""?"&textogenero=".$textogenero:"");
echo (isset($conteudotexto) && $conteudotexto!=""?"&conteudotexto=".$conteudotexto:"");
echo (isset($organizatexto) && $organizatexto!=""?"&organizatexto=".$organizatexto:"");
echo (isset($textocoesao) && $textocoesao!=""?"&textocoesao=".$textocoesao:"");
echo (isset($elementos) && $elementos!=""?"&elementos=".$elementos:"");

echo (isset($grandeza) && $grandeza!=""?"&grandeza=".$grandeza:"");
echo (isset($grandeza1) && $grandeza1!=""?"&grandeza1=".$grandeza1:"");
echo (isset($dimensao) && $dimensao!=""?"&dimensao=".$dimensao:"");
echo (isset($medida) && $medida!=""?"&medida=".$medida:"");
echo (isset($numero) && $numero!=""?"&numero=".$numero:"");
echo (isset($tamanho) && $tamanho!=""?"&tamanho=".$tamanho:"");
echo (isset($operacoes) && $operacoes!=""?"&operacoes=".$operacoes:"");
echo (isset($operacoes1) && $operacoes1!=""?"&operacoes1=".$operacoes1:"");
echo (isset($multiplicacao) && $multiplicacao!=""?"&multiplicacao=".$multiplicacao:"");
echo (isset($problemas) && $problemas!=""?"&problemas=".$problemas:"");
echo (isset($quantoperacoes) && $quantoperacoes!=""?"&quantoperacoes=".$quantoperacoes:"");
echo (isset($situacao) && $situacao!=""?"&situacao=".$situacao:"");
echo (isset($subsituacao) && $subsituacao!=""?"&subsituacao=".$subsituacao:"");
echo (isset($geometria) && $geometria!=""?"&geometria=".$geometria:"");
echo (isset($partes) && $partes!=""?"&partes=".$partes:"");
echo (isset($tipos) && $tipos!=""?"&tipos=".$tipos:"");
echo (isset($subtipos) && $subtipos!=""?"&subtipos=".$subtipos:"");
echo (isset($cartesiano) && $cartesiano!=""?"&cartesiano=".$cartesiano:"");
echo (isset($algebra) && $algebra!=""?"&algebra=".$algebra:"");
echo (isset($subalgebra) && $subalgebra!=""?"&subalgebra=".$subalgebra:"");
echo (isset($planilha) && $planilha!=""?"&planilha=".$planilha:"");
echo (isset($calculo) && $calculo!=""?"&calculo=".$calculo:"");

echo (isset($ambiente1) && $ambiente1!=""?"&ambiente1=".$ambiente1:"");
echo (isset($subambiente) && $subambiente!=""?"&subambiente=".$subambiente:"");
echo (isset($subambiente1) && $subambiente1!=""?"&subambiente1=".$subambiente1:"");
echo (isset($tipoambiente) && $tipoambiente!=""?"&tipoambiente=".$tipoambiente:"");
echo (isset($ecologia) && $ecologia!=""?"&ecologia=".$ecologia:"");
echo (isset($subecologia) && $subecologia!=""?"&subecologia=".$subecologia:"");
echo (isset($subecologia1a) && $subecologia1a!=""?"&subecologia1a=".$subecologia1a:"");
echo (isset($subecologia1) && $subecologia1!=""?"&subecologia1=".$subecologia1:"");
echo (isset($subecologia2) && $subecologia2!=""?"&subecologia2=".$subecologia2:"");
echo (isset($subecologia3) && $subecologia3!=""?"&subecologia3=".$subecologia3:"");
echo (isset($seres) && $seres!=""?"&seres=".$seres:"");
echo (isset($seres1) && $seres1!=""?"&seres1=".$seres1:"");
echo (isset($abioticos) && $abioticos!=""?"&abioticos=".$abioticos:"");
echo (isset($subabioticos) && $subabioticos!=""?"&subabioticos=".$subabioticos:"");
echo (isset($subabioticos1) && $subabioticos1!=""?"&subabioticos1=".$subabioticos1:"");
echo (isset($subabioticos1a) && $subabioticos1a!=""?"&subabioticos1a=".$subabioticos1a:"");
echo (isset($bioticos) && $bioticos!=""?"&bioticos=".$bioticos:"");
echo (isset($taxonomia) && $taxonomia!=""?"&taxonomia=".$taxonomia:"");
echo (isset($subtaxonomia) && $subtaxonomia!=""?"&subtaxonomia=".$subtaxonomia:"");
echo (isset($sintomas) && $sintomas!=""?"&sintomas=".$sintomas:"");
echo (isset($prevencao) && $prevencao!=""?"&prevencao=".$prevencao:"");
echo (isset($transmissao) && $transmissao!=""?"&transmissao=".$transmissao:"");
echo (isset($subtaxonomia1) && $subtaxonomia1!=""?"&subtaxonomia1=".$subtaxonomia1:"");
echo (isset($subtaxonomia2) && $subtaxonomia2!=""?"&subtaxonomia2=".$subtaxonomia2:"");
echo (isset($subtaxonomia3) && $subtaxonomia3!=""?"&subtaxonomia3=".$subtaxonomia3:"");
echo (isset($taxonomia1) && $taxonomia1!=""?"&taxonomia1=".$taxonomia1:"");
echo (isset($sub1taxonomia) && $sub1taxonomia!=""?"&sub1taxonomia=".$sub1taxonomia:"");
echo (isset($sub1taxonomia1) && $sub1taxonomia1!=""?"&sub1taxonomia1=".$sub1taxonomia1:"");
echo (isset($sub1taxonomia2) && $sub1taxonomia2!=""?"&sub1taxonomia2=".$sub1taxonomia2:"");
echo (isset($sub1taxonomia3) && $sub1taxonomia3!=""?"&sub1taxonomia3=".$sub1taxonomia3:"");
echo (isset($alimentacao) && $alimentacao!=""?"&alimentacao=".$alimentacao:"");
echo (isset($alimentacao1) && $alimentacao1!=""?"&alimentacao1=".$alimentacao1:"");
echo (isset($locomocao) && $locomocao!=""?"&locomocao=".$locomocao:"");
echo (isset($reproducao) && $reproducao!=""?"&reproducao=".$reproducao:"");
echo (isset($subreproducao) && $subreproducao!=""?"&subreproducao=".$subreproducao:"");
echo (isset($desenvolvimento) && $desenvolvimento!=""?"&desenvolvimento=".$desenvolvimento:"");
echo (isset($temperatura) && $temperatura!=""?"&temperatura=".$temperatura:"");
echo (isset($esqueleto) && $esqueleto!=""?"&esqueleto=".$esqueleto:"");
echo (isset($respiracao) && $respiracao!=""?"&respiracao=".$respiracao:"");

echo (isset($sistemas) && $sistemas!=""?"&sistemas=".$sistemas:"");
echo (isset($subsistemas) && $subsistemas!=""?"&subsistemas=".$subsistemas:"");
echo (isset($subsistemas1) && $subsistemas1!=""?"&subsistemas1=".$subsistemas1:"");
echo (isset($subsistemas2) && $subsistemas2!=""?"&subsistemas2=".$subsistemas2:"");
echo (isset($subsistemas3) && $subsistemas3!=""?"&subsistemas3=".$subsistemas3:"");
echo (isset($citologia) && $citologia!=""?"&citologia=".$citologia:"");
echo (isset($subcitologia) && $subcitologia!=""?"&subcitologia=".$subcitologia:"");
echo (isset($subcitologia1) && $subcitologia1!=""?"&subcitologia1=".$subcitologia1:"");
echo (isset($subcitologia2) && $subcitologia2!=""?"&subcitologia2=".$subcitologia2:"");
echo (isset($subcitologia3) && $subcitologia3!=""?"&subcitologia3=".$subcitologia3:"");
echo (isset($tecidos) && $tecidos!=""?"&tecidos=".$tecidos:"");
echo (isset($subtecidos) && $subtecidos!=""?"&subtecidos=".$subtecidos:"");
echo (isset($subtecidos1) && $subtecidos1!=""?"&subtecidos1=".$subtecidos1:"");

/*
anatomia
subanatomia
cognicao
subcognicao
comportamento
subcomportamento
degeneracao
subdegeneracao
desenvolvimentoneuro
subdesenvolvimento
evolucao
subevolucao
emocao
subemocao
fisiologia
subfisiologia
histologia
subhistologia
motor
submotor
sensorial
subsensorial
anatomia
subanatomia
cognicao
subcognicao
comportamento
subcomportamento
degeneracao
subdegeneracao
desenvolvimentoneuro
subdesenvolvimento
evolucao
subevolucao
emocao
subemocao
fisiologia
subfisiologia
histologia
subhistologia
motor
submotor
sensorial
subsensorial
*/
?>