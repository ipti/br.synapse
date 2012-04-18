<?php
//if($_SERVER['REQUEST_METHOD'] == 'POST') {
if($anexar=="1") {
	global $_POST, $_FILES;
	if(move_uploaded_file($_FILES['anexado']['tmp_name'], $path.$_FILES['anexado']['name'])){
		$msg='<h3>O arquivo <b>'.$_FILES['anexado']['name'].'</b> foi anexado com sucesso!</h3>';
	}
//	echo "path: ".$path."<br>";
//	echo $msg;
//	exit;
	echo "<script>window.location=";
	echo "'goal.php?goal_id=".$goal_id;
	ini_set("allow_url_fopen",1); ini_set("allow_url_include",1);
		include("goal/content_link.php");
	ini_set("allow_url_fopen",0); ini_set("allow_url_include",0);
	echo "';";//#goal_anchor
	echo "</script>";
}
?>