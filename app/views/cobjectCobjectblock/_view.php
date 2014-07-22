<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cobject_id')); ?>:</b>
	<?php echo CHtml::encode($data->cobject_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cobject_block_id')); ?>:</b>
	<?php echo CHtml::encode($data->cobject_block_id); ?>
	<br />


</div>