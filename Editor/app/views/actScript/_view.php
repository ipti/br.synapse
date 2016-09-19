<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discipline_id')); ?>:</b>
	<?php echo CHtml::encode($data->discipline_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('performance_index')); ?>:</b>
	<?php echo CHtml::encode($data->performance_index); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('father_content')); ?>:</b>
	<?php echo CHtml::encode($data->father_content); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />


</div>