<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID), array('view', 'id'=>$data->ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('typeID')); ?>:</b>
	<?php echo CHtml::encode($data->typeID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('templateID')); ?>:</b>
	<?php echo CHtml::encode($data->templateID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('themeID')); ?>:</b>
	<?php echo CHtml::encode($data->themeID); ?>
	<br />


</div>