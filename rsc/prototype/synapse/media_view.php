<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?php 
if($radio_name=="image"){?>
	<img src="<?php echo $url; ?>"><?php
}elseif($radio_name=="movie"){
	echo '<embed src="'.$url.'" quality="high" type="application/x-shockwave-flash" width="100%" height="100%"></embed>';
} ?>
</body>
</html>