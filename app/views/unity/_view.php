<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID), array('view', 'id'=>$data->ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('organizationID')); ?>:</b>
	<?php echo CHtml::encode($data->organizationID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fatherID')); ?>:</b>
	<?php echo CHtml::encode($data->fatherID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('locationID')); ?>:</b>
	<?php echo CHtml::encode($data->locationID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fcode')); ?>:</b>
	<?php echo CHtml::encode($data->fcode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('autochild')); ?>:</b>
	<?php echo CHtml::encode($data->autochild); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('actDate')); ?>:</b>
	<?php echo CHtml::encode($data->actDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('desDate')); ?>:</b>
	<?php echo CHtml::encode($data->desDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('capacity')); ?>:</b>
	<?php echo CHtml::encode($data->capacity); ?>
	<br />

	*/ ?>

</div>