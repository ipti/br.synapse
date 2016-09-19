<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('organization_id')); ?>:</b>
	<?php echo CHtml::encode($data->organization_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('father_id')); ?>:</b>
	<?php echo CHtml::encode($data->father_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fk_code')); ?>:</b>
	<?php echo CHtml::encode($data->fk_code); ?>
	<br />

        <!--  Retirado do MODEL
        <b><?php //echo CHtml::encode($data->getAttributeLabel('autochild')); ?>:</b>
	<?php //echo CHtml::encode($data->autochild); ?>
	<br />-->

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