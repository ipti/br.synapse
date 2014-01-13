<?php
session_start();
if(isset($piece_id) && $piece_id == $linhae['piece_id']){
	$bgcolor="#FFFFFF";
	$bordersytle = "dashed";
	$zindex = 100;
}else{
	$bgcolor="#FFFFFF";
	$bordersytle = "";
}
?>
<STYLE>
	.div<?php echo $i; ?>{ 
		position:absolute;
		width: <?php echo $divwidth; ?> ;
		height: <?php echo $divheight; ?>;
		top: <?php echo $divtop; ?>;
		left: <?php echo $divleft ?>;
		z-index: <?php echo $zindex ?>;
		border-style: <?php echo $bordersytle; ?>;
		border-width: 1px;
		background-color: <?php echo $bgcolor; ?>
	}
</STYLE>
<?php 

$divwidth1 = ($divwidth)-16;
$divleft1 = ($divwidth)-16;
$divtop1 = ($divheight)-16;
?>