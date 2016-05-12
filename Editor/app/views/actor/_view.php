<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('person_id')); ?>:</b>
	<?php echo CHtml::encode($data->person_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('personage_id')); ?>:</b>
	<?php echo CHtml::encode($data->personage_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fk_code')); ?>:</b>
	<?php echo CHtml::encode($data->fk_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('active_date')); ?>:</b>
	<?php echo CHtml::encode($data->active_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('desactive_date')); ?>:</b>
	<?php echo CHtml::encode($data->desactive_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('classroom_fk')); ?>:</b>
	<?php echo CHtml::encode($data->classroom_fk); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('inep_id')); ?>:</b>
	<?php echo CHtml::encode($data->inep_id); ?>
	<br />

	*/ ?>

</div>