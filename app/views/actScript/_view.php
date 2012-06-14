<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID), array('view', 'id'=>$data->ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('disciplineID')); ?>:</b>
	<?php echo CHtml::encode($data->disciplineID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('performanceIndice')); ?>:</b>
	<?php echo CHtml::encode($data->performanceIndice); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contentParentID')); ?>:</b>
	<?php echo CHtml::encode($data->contentParentID); ?>
	<br />


</div>