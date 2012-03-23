<?php
	session_start();
    session_destroy();
    session_start();

echo "<script> window.location='index.php'; </script>";
/*
	if(isset($proj) && $proj==3){
	    echo "<script> window.location='../capes/index.php?destroy=true'; </script>";
	}else{
	   echo "<script> window.location='index.php?destroy=true'; </script>";
	}
*/
?>
