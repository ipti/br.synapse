<input type="hidden" name="blockname_varchar" value="<?php echo $blockname_varchar; ?>"> 
<input type="hidden" name="block_content" value="<?php echo $block_content; ?>"> 

<input type="hidden" name="semanticname" value="<?php echo $semanticname; ?>"> 
<input type="hidden" name="discipline" value="<?php echo $discipline; ?>"> 
<input type="hidden" name="goal_id" value="<?php echo $goal_id; ?>"> 

<input type="hidden" name="screen" value="<?php echo $screen; ?>">
<input type="hidden" name="totalscreen" value="<?php echo $totalscreen; ?>">

<input type='hidden' name='activity_id' value='<?php echo $activity_id; ?>'> 
<input type='hidden' name='activitytype_id' value='<?php echo $activitytype_id; ?>'> 
<input type="hidden" name="activityname" value="<?php echo $activityname; ?>"> 
<input type="hidden" name="activitydescription" value="<?php echo $activitydescription; ?>"> 

<?php if(isset($piece_id) && $piece_id!=""){ ?>
<input type="hidden" name="piece_id" value="<?php echo $piece_id; ?>">
<input type="hidden" name="piecename" value="<?php echo $piecename; ?>">
<?php } ?>

<?php if(isset($piece_element) && $piece_element!=""){ ?>
<input type='hidden' name='piece_element' value='<?php echo $piece_element; ?>'> 
<input type='hidden' name='element_id' value='<?php echo $element_id; ?>'> 
<input type='hidden' name='elementtype_id' value='<?php echo $elementtype_id; ?>'> 
<input type="hidden" name="layer_property_id" value="<?php echo $layer_property_id; ?>"> 
<input type="hidden" name="layertype_id" value="<?php echo $layertype_id; ?>"> 
<input type="hidden" name="typename" value="<?php echo $typename; ?>"> 
<input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
<input type="hidden" name="grouping" value="<?php echo $grouping; ?>">
<input type="hidden" name="lpseq" value="<?php echo $lpseq; ?>">
<input type="hidden" name="peseq" value="<?php echo $peseq; ?>">
<?php } ?>

<?php if(isset($newscreen) && $newscreen!=""){ ?>
<input type="hidden" name="newscreen" value="<?php echo $newscreen; ?>">
<?php } ?>
<?php if(isset($newpiece) && $newpiece==true){ ?>
<input type="hidden" name="newpiece" value="true">
<?php } ?>
<?php if(isset($newpieceelement) && $newpieceelement==true){ ?>
<input type="hidden" name="newpieceelement" value="true">
<?php } ?>