<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID), array('view', 'id'=>$data->ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unityID')); ?>:</b>
	<?php echo CHtml::encode($data->unityID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('personID')); ?>:</b>
	<?php echo CHtml::encode($data->personID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('personageID')); ?>:</b>
	<?php echo CHtml::encode($data->personageID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('activatedDate')); ?>:</b>
	<?php echo CHtml::encode($data->activatedDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('desactivatedDate')); ?>:</b>
	<?php echo CHtml::encode($data->desactivatedDate); ?>
	<br />


</div>