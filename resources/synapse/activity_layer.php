<?php
session_start();
if((isset($element_id) && $element_id!="")){ //(isset($newscreen) && $newscreen==true) || (isset($newpiece) && $newpiece==true) || (isset($newpieceelement) && $newpieceelement==true) ||

	if((isset($layer_id) && $layer_id!="") && (isset($event_id) && event_id!="")){
		$SQLl = "SELECT pe.seq, et.name
				FROM layer_property lp
						LEFT JOIN piece_element pe ON pe.id = lp.piece_element_id
						LEFT JOIN elementtype et ON et.id = pe.elementtype_id
				WHERE pe.element_id = ".$element_id." AND
					  lp.event_id = ".$event_id." AND
					  pe.id = ".$piece_element."
				ORDER BY pe.seq";
		$resl = pg_query($SQLl);
		$ll = pg_fetch_array($resl);
		$layer = $ll['seq']." - ".$ll['name'];
//		echo $SQLl;
//		echo $layer;
//		exit;
	}
	
	if(isset($piece_element) && $piece_element!=""){
		$SQL = "SELECT lp.*, e.id, e.name as eventname, lt.id, lt.name as layername, et.name as layer, pe.seq as peseq
				FROM layer_property lp
						LEFT JOIN event e ON e.id = lp.event_id
						LEFT JOIN layertype lt ON lt.id = lp.layertype_id
						LEFT JOIN piece_element pe ON pe.id = lp.piece_element_id
						LEFT JOIN elementtype et ON et.id = pe.elementtype_id
				WHERE lp.piece_element_id = ".$piece_element."";
		if(isset($event_id) && $event_id!=""){
			$SQL .= " AND lp.event_id=".$event_id."";
		}
		$res = pg_query($SQL);
		if(pg_num_rows($res)>0){
			$l = pg_fetch_array($res);
			$event_id = $l['event_id'];
			$eventname = $l['eventname'];
			$layertype_id = $l['layertype_id'];
			$layername = $l['layername'];
			$layer_id = $l['layer_id'];
			$layer = $l['peseq']." - ".$l['layer'];
			$screen = $l['screen'];
			$lpseq = $l['seq'];
			$peseq = $l['peseq'];
			$grouping = $l['grouping'];
			$divleft = $l['pos_x'];
			$divtop = $l['pos_y'];
			$divwidth = $l['dim_x'];
			$divheight = $l['dim_y'];
			//echo $layertype_id." - ";
			//echo $layername;
			//exit;
		}else{
			$newevent=true;
		} 
	} //echo "eventid: ".$eventid." | event_id: ".$event_id."| layer: ".$layer; ?>
	<hr>
	<form name="form5" action="activity.php" method="post" onSubmit="return check_form(elementupd);">
    <table cellspacing="0" cellpadding="0" border="0" width="100%">
      <tr><td><p>Ev:</p></td><td colspan="3"> <select name="eventid" onChange="document.form5.submit()">
            <option value="<?php echo (isset($event_id) && $event_id!=""?$event_id:""); ?>"><?php echo (isset($event_id) && $event_id!=""?$eventname:""); ?></option>
            <?php $SQL = "SELECT * FROM event";
				$res = pg_query($SQL);
				while($l=pg_fetch_array($res)){
					echo "<option value='".$l['id']."'>".$l['name']."</option>";
				} ?>
          </select> </td></tr>
      <tr><td><p>Lt:</p></td><td colspan="3"> <?php echo "<select name='layertype_id'>";
				echo "<option value='".(isset($layertype_id) && $layertype_id!=""?$layertype_id:"")."'>".(isset($layertype_id) && $layertype_id!=""?$layername:"")."</option>";
				$SQL = "SELECT * FROM layertype ORDER BY name";
				$res = pg_query($SQL);
				while($linha = pg_fetch_array($res)){
					echo "<option value=".$linha['id'].">".$linha['name']."</option>";
				} echo "</select>"; ?> </td></tr>
      <tr><td align="left"><p>Ly:</p></td><td colspan="3"> 
	  <?php echo "<select name='layer_id'>";
				echo "<option value='".(isset($layer_id) && $layer_id!=""?$layer_id:"")."'>".(isset($layer_id) && $layer_id!=""?($layer):"")."</option>";
				$SQL = "SELECT pe.*, et.name
						FROM piece_element pe
								LEFT JOIN elementtype et ON et.id = pe.elementtype_id
						WHERE pe.piece_id = ".$piece_id." 
						ORDER BY pe.seq";
				$res = pg_query($SQL);
				while($linha = pg_fetch_array($res)){
					echo "<option value=".$linha['id'].">".$linha['seq']." - ".$linha['name']."</option>";
				} echo "</select>"; ?> </td></tr>
      <tr><td><p>Pg:</p></td>
        <td><input type="text" size="1" name="screen" value="<?php echo (isset($screen)?$screen:""); ?>"></td>
        <td><p>Gr:</p></td><td><input type="text" size="1" name="grouping" value="<?php echo (isset($grouping)?$grouping:""); ?>"></td></tr>
      <tr><td><p>Es:</p></td><td><input type="text" size="1" name="peseq" value="<?php echo (isset($peseq)?$peseq:""); ?>"></td>
          <td><p>Ls:</p></td><td><input type="text" size="1" name="lpseq" value="<?php echo (isset($lpseq)?$lpseq:""); ?>"></td></tr>
      <tr><td><p>Px:</p></td><td><input type='text' size='1' name='PosX' value="<?php echo (isset($divleft)?$divleft:""); ?>"></td>
          <td><p>Py:</p></td><td><input type='text' size='1' name='PosY' value="<?php echo (isset($divtop)?$divtop:""); ?>"></td></tr>
      <tr><td><p>Dx:</p></td><td><input type='text' size='1' name='DimX' value="<?php echo (isset($divwidth)?$divwidth:""); ?>"></td>
          <td><p>Dy:</p></td><td><input type='text' size='1' name='DimY' value="<?php echo (isset($divheight)?$divheight:""); ?>"></td></tr>
	  <tr>
        <td colspan="4"> <input type='hidden' name='activity_id' value='<?php echo $activity_id; ?>'> 
          <input type='hidden' name='activitytype_id' value='<?php echo $activitytype_id; ?>'> 
          <input type='hidden' name='piece_id' value='<?php echo $piece_id; ?>'> 
          <input type='hidden' name='piece_element' value='<?php echo $piece_element; ?>'> 
          <input type='hidden' name='element_id' value='<?php echo $element_id; ?>'> 
          <input type='hidden' name='elementtype_id' value='<?php echo $elementtype_id; ?>'> 
          <input type="hidden" name="totalscreen" value="<?php echo $totalscreen; ?>"> 
          <input type="hidden" name="radio_name" value="<?php echo $radio_name; ?>"> 
		  <input type="hidden" name="discname" value="<?php echo $discname; ?>"> 
		  <input type="hidden" name="goaldescription" value="<?php echo $goaldescription; ?>"> 
		  <input type="hidden" name="semanticname" value="<?php echo $semanticname; ?>"> 
		  <input type="hidden" name="blockname_varchar" value="<?php echo $blockname_varchar; ?>"> 
		  <input type="hidden" name="block_content" value="<?php echo $block_content; ?>"> 
		  <input type="hidden" name="activityname" value="<?php echo $activityname; ?>"> 
		  <input type="hidden" name="activitydescription" value="<?php echo $activitydescription; ?>"> 
		  <?php if(isset($newevent)) { ?>
			  <input type="hidden" name="newevent" value="true"> 
		  <?php } ?>
		  <input type="hidden" name="filtragem" value="0"> 
		  <input type="submit" name="upd" value="Upd" align="left" width="14" height="18" onClick="filtra5(5)"> 
        </td></tr>
    </table>
	</form>
<?php } ?>