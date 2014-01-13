<?php
session_start();

ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
	include("includes/conecta.php");
	include("includes/idiom.php");
	include("includes/validation.php");
	include("includes/post.php");
	include("includes/funcoes.php");
ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);

if(isset($filtrocontentremove) && $filtrocontentremove==true){
	session_unregister($filtrocontent);
	$filtrocontent=false;
	session_register($filtrocontent);
	$degreestage="";
	unset($degreestage);
	$degreeblock="";
	unset($degreeblock);
	$degreegrade="";
	unset($degreegrade);
}

if(isset($filtrocontentadd) && $filtrocontentadd==true){
	session_unregister($filtrocontent);
	$filtrocontent=true;
	session_register($filtrocontent);
}

if(isset($acao) && $acao==4){
	$SQL = "UPDATE goal SET degreegrade_id = ".$degreegrade." WHERE id = ".$goal_id."";
	$res = pg_query($SQL);
	$SQLs = "SELECT dg.id as degreegrade, dg.name as degreegradename, 
					db.id as degreeblock, db.name as degreeblockname,
					ds.id as degreestage, ds.name as degreestagename
			FROM degreegrade dg
					LEFT JOIN degreeblock db ON db.id = dg.degreeblock_id
					LEFT JOIN degreestage ds ON ds.id = db.degreestage_id
			WHERE dg.id = ".$degreegrade."";
	$ress = pg_query($SQLs);
	$ls = pg_fetch_array($ress);
	$degreegradename = $ls['degreegradename'];
	$degreestage = $ls['degreestage'];
	$degreestagename = $ls['degreestagename'];
	$degreeblock = $ls['degreeblock'];
	$degreeblockname = $ls['degreeblockname'];
}

if(isset($acao) && ($acao=="2" || $acao=="3")){
	ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
	include("goal_ins.php");
	ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);	
}
	
if(isset($upddescriptiongoal) && $upddescriptiongoal==true){
	$SQLud = "UPDATE goal SET description = '".$txtdescriptiongoal."' WHERE id = ".$goal_id.";";
	$resud = pg_query($SQLud);
	echo "<script>";
		echo "window.location=";
		echo "'goal.php?ia=".$ia."&goal_id=".$goal_id;
		ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
			include("goal/content_link.php");
		ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
		echo "';";
	echo "</script>";
}

if(isset($updactivity) && $updactivity==true){
	$SQL = "UPDATE activity 
			SET name_varchar='".$activityname."', 
				description='".$activitydescription."',
				activitytype_id=".$activitytype_id."
			WHERE id = ".$activity_id.";";
	$res = pg_query($SQL);
	echo "<script>";
		echo "window.location=";
		echo "'goal.php?goal_id=".$goal_id;
		ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
			include("goal/content_link.php");
		ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
		echo "';";
		echo "</script>";
}

if(isset($discipline) && $discipline!=""){
	$SQL = "SELECT name FROM discipline WHERE id = ".$discipline."";
	$res = pg_query($SQL);
	$l = pg_fetch_array($res);
	$discname = $l['name'];
}

if(isset($goal_id) && $goal_id!=""){

	$SQL = "SELECT description FROM goal WHERE id = ".$goal_id."";
	$res = pg_query($SQL);
	$l = pg_fetch_array($res);
	$description=$l['description'];

	$SQLg = "SELECT gc.activitycontent_id, ac.name_varchar
			FROM goal_content gc
						LEFT JOIN activitycontent ac ON ac.id = gc.activitycontent_id 
			WHERE gc.goal_id = ".$goal_id;
	$resg = pg_query($SQLg);
	$activitycontent = "";
	while($lg = pg_fetch_array($resg)){
		$activitycontent .= $lg['activitycontent_id'].$lg['name_varchar']." - ";
	}
//echo $SQLg;
//echo "-".$activitycontent;
}//if(isset($goal_id) && $goal_id!=""){

?>
<head>
<title><?php echo $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="synapse.css" rel="stylesheet" type="text/css">
<script language="javascript">
<!--
function reloadPage(){  
   javascript:location.reload();
}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
//-->
</script>
</head>
<body>
<div id="topo1"><img src="<?php echo 'http://' . $_SERVER['SERVER_NAME']; ?>/synapse/images/<?php echo $logo; ?>" width="201" height="87" alt="ENSCER"><img src="<?php echo 'http://' . $_SERVER['SERVER_NAME']; ?>/synapse/images/top_degrade.gif" width="85" height="87"></div>

<div id="foldertop1"><?php
	echo "<h1>Objetivos: ";
	echo $discname.(isset($stagename)?" - ".$stagename." Estágio":"").(isset($blockname)?" - ".$blockname." Bloco":"")."</h1>"; ?>
</div>

<div id="menutop1">
	<ul>
	<li class="inicio"></li>
	<li class="meio"><a href='#' onMouseOver="MM_showHideLayers('menu_top','','show')" onMouseOut="MM_showHideLayers('menu_top','','hide')">IR</a></li>
	<li class="larga"><a href='#' onMouseOver="MM_showHideLayers('disciplinas','','show')" onMouseOut="MM_showHideLayers('disciplinas','','hide')">DISCIPLINAS</a></li>
	</ul>
</div><?php

echo "<div id='col12345'>";
	echo "<div id='menu_top' onMouseOver=\"MM_showHideLayers('menu_top','','show')\" onMouseOut=\"MM_showHideLayers('menu_top','','hide')\">";
		ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
		include("menu_top.php");
		ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
	echo "</div>";
	echo "<div id='disciplinas' onMouseOver=\"MM_showHideLayers('disciplinas','','show')\" onMouseOut=\"MM_showHideLayers('disciplinas','','hide')\">";
		ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
		include("goal_menu.php");
		ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
	echo "</div>";

echo "<hr>";

if(isset($discipline) && $discipline!=""){

	ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
	include("goal/goal_name.php");
	ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
	
	ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
	include("goal_form.php");
	ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
	$i = 0;	
	if(isset($goal_id) && $goal_id!=""){
		ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
		include("activity_view.php");
		ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
	}else{
		ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
		include("goal_select.php");
		ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
	}
}//if(isset($disc)
?>
</div>
<div id="base1"><?php echo $base.date('Y');?> ::</div>
</body>
</html>
