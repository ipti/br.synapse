<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('acronym')); ?>:</b>
	<?php echo CHtml::encode($data->acronym); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('father_id')); ?>:</b>
	<?php echo CHtml::encode($data->father_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('orglevel')); ?>:</b>
	<?php echo CHtml::encode($data->orglevel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('degree_id')); ?>:</b>
	<?php echo CHtml::encode($data->degree_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('autochild')); ?>:</b>
	<?php echo CHtml::encode($data->autochild); ?>
	<br />


</div>