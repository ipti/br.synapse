<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID), array('view', 'id'=>$data->ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contentParent')); ?>:</b>
	<?php echo CHtml::encode($data->contentParent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('disciplineID')); ?>:</b>
	<?php echo CHtml::encode($data->disciplineID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />


</div>