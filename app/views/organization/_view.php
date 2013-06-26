<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID), array('view', 'id'=>$data->ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('acronym')); ?>:</b>
	<?php echo CHtml::encode($data->acronym); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fatherID')); ?>:</b>
	<?php echo CHtml::encode($data->fatherID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('orgLevel')); ?>:</b>
	<?php echo CHtml::encode($data->orgLevel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('degreeID')); ?>:</b>
	<?php echo CHtml::encode($data->degreeID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('autochild')); ?>:</b>
	<?php echo CHtml::encode($data->autochild); ?>
	<br />


</div>