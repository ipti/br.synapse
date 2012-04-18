<?php

if(isset($blockname_varchar) && $blockname_varchar!=""){echo "&blockname_varchar=".$blockname_varchar;}
if(isset($block_content) && $block_content!=""){echo "&block_content=".$block_content;}

if(isset($discipline) && $discipline!=""){echo "&discipline=".$discipline;}

if(isset($semantic_id) && $semantic_id!=""){echo "&semantic_id=".$semantic_id;}
if(isset($semanticname) && $semanticname!=""){echo "&semanticname=".$semanticname;}

if(isset($screen) && $screen!=""){echo "&screen=".$screen;}
if(isset($totalscreen) && $totalscreen!=""){echo "&totalscreen=".$totalscreen;}

if(isset($goal_id) && $goal_id!=""){echo "&goal_id=".$goal_id;}
if(isset($activity_id) && $activity_id!=""){echo "&activity_id=".$activity_id;}
if(isset($activitytype_id) && $activitytype_id!=""){echo "&activitytype_id=".$activitytype_id;}

if(isset($noise) && $noise==true){echo "&noise=true";}
if(isset($music) && $music==true){echo "&music=true";}
if(isset($radio_name) && $radio_name!=""){echo "&radio_name=".$radio_name;}

if(isset($newscreen) && $newscreen==true){echo "&newscreen=true";}
if(isset($newpiece) && $newpiece==true){echo "&newpiece=true";}
if(isset($newpieceelement) && $newpieceelement==true){echo "&newpieceelement=true";}
if(isset($pieceelement_ins) && $pieceelement_ins==true){echo "&pieceelement_ins=true";}

if(isset($piece_id) && $piece_id!=""){echo "&piece_id=".$piece_id;}
if(isset($pieceseq) && $pieceseq!=""){echo "&pieceseq=".$pieceseq;}
if(isset($piece_element) && $piece_element!=""){echo "&piece_element=".$piece_element;}
if(isset($element_id) && $element_id!=""){echo "&element_id=".$element_id;}
if(isset($elementtype_id) && $elementtype_id!=""){echo "&elementtype_id=".$elementtype_id;}
if(isset($layertype_id) && $layertype_id!=""){echo "&layertype_id=".$layertype_id;}
if(isset($layer_property_id) && $layer_property_id!=""){echo "&layer_property_id=".$layer_property_id;}
?>