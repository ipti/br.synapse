<?php

function redireciona($url) {
    header('Location: ' . $url);
    exit();
}

function number_of($str, $delim){
	$i=0;
	$v=-1;
	$str = strtoupper($str);
	$delim = strtoupper($delim);
//	do{
//    	$v = strpos($str, $delim, $v+1);
//    	$i = $i + 1;
//	}while ($v != 0 || $v != "");
	return substr_count($str, $delim); //$i-1;
}

function after($str, $delim) {
	$strtmp = stristr($str,$delim);
	$strtmp = substr($strtmp,strlen($delim));
	return $strtmp;
}

function before($str, $delim) {
	$strtmp = strtolower($str);
	$delim = strtolower($delim);
	$pfim = strpos($strtmp,$delim);
	if($pfim > 0){
		return substr($str,0,strpos($strtmp,$delim));
	}else{
		return "";
	}
}

function item($str, $delim, $n){
	if($n=="" || $delim=="" || $str=="" || $n > number_of($str, $delim)+1){
		return "";
	}else{
		$i=0;
		$v=-1;
		$va=-1;
		$strtmp = strtolower($str);
		if(substr($strtmp,-1)!=$delim){
			$strtmp = $strtmp . $delim;
		}
		//echo "<br><br>".$str."<br><br>";
		//echo "N=".number_of($str, $delim);
		if($n == number_of($strtmp, $delim)){
			$fim = true;
		}
		$delim = strtolower($delim);
		do{
			$va = $v;
    		$v = strpos($strtmp, $delim, $v+1);
    		$i = $i + 1;
		}while ($i < $n && ($v != 0 || $v != ""));
	}
	//echo "<br>V=".$v." VA=".$va."<br>";
	if($fim){
		return substr($str,$va+1);
	}else{
		return substr($str,$va+1,$v-$va-1);
	}
}

function myerro($SQL){
	return "<h5><font color=red>Erro em: " . $SQL . " <br>Descrição: " . mysql_error() . "</font></h5>";
}

function formataData($data, $formato){
	return date($formato, strtotime($data));
}

function query($nome, $filtro){
	if($nome=="Temas"){
		$SQL = "SELECT te_temas.* FROM te_temas ORDER BY te_temas.tenome";
		if($filtro!=""){
			$SQL .= "WHERE " . $filtro . ";";
		}else{
			$SQL .= ";";
		}

	}
	return $SQL;
}

function cvdate($s) {
	$delimiter='';
	$s = str_replace(' de ','/',strtolower($s));
	if (strpos($s,'-')>0) $delimiter='-';
	elseif (strpos($s,'/')>0) $delimiter='/';
	elseif (strpos($s,' ')>0) $delimiter=' ';
	elseif (strpos($s,'.')>0) $delimiter='.';
	$s = str_replace(', ',$delimiter,$s);
	if (empty($delimiter)) return 0;
	$p1=strpos($s,$delimiter);
	$p2=strpos($s,$delimiter,$p1+1);
	$a=substr($s,$p2+1);
	$m=substr($s,$p1+1,$p2-($p1+1));
	$d=substr($s,0,$p1);
	if (intval($a)<100){
		$a=(intval($a)>69)? strval(1900+intval($a)) : strval(2000+intval($a));
	}
	if (intval($m)==0){ // contém mês em extenso
		return cvdate_portugues($d,$m,$a);
	}else{
	   return cvdate_numerico($d,$m,$a);
	}
}

/* função auxiliar do cvdate */

function cvdate_portugues($d,$m,$y) {
    $d2=0; $m2=0; $y2=0;
    $d2=intval($d);
    $m=strtolower($m);
    switch(substr($m,0,3)) {
        case 'jan': $m2=1; break;
        case 'fev': $m2=2; break;
        case 'mar': $m2=3; break;
        case 'abr': $m2=4; break;
        case 'mai': $m2=5; break;
        case 'jun': $m2=6; break;
        case 'jul': $m2=7; break;
        case 'ago': $m2=8; break;
        case 'set': $m2=9; break;
        case 'out': $m2=10; break;
        case 'nov': $m2=11; break;
        case 'dez': $m2=12; break;
    }
    $y2=intval($y);
    if (($d2==0)||($m2==0)||($y2==0)) return 0;
    return mktime(0,0,0,$m2,$d2,$y2);
}

/* função auxiliar do cvdate */
function cvdate_numerico($d,$m,$y) {
    $d2=0; $m2=0; $y2=0;
    $d2=intval($d);
    $m2=intval($m);
    $y2=intval($y);
    if (($d2==0)||($m2==0)||($y2==0)) return 0;
    return mktime(0,0,0,$m2,$d2,$y2);
}
?>