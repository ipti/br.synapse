<?php
session_start();
echo "<table width='100%' cellpadding='0' cellspacing='0'><tr><td>";
echo "<h3>".$discname." - ".$goaldescription." - ".$semanticname."<br>";
echo "Block: ".$blockname_varchar." ".$block_content."<br>";
echo "Activity: ".$activityname." - ".$activitydescription."</h3></td>";
echo "<td><p>Type: ".$typename."<br>";
echo "Event: ".$eventname."<br>";
echo "Layer: ".$layername."<br>";
echo "Element: ".$radio_name."</p></td></tr></table>";
if(isset($erro210)){ 
	echo $erro210; 
}
?>