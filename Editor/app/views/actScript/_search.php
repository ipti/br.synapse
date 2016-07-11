<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'discipline_id'); ?>
		<?php echo $form->textField($model,'discipline_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'performance_index'); ?>
		<?php echo $form->textField($model,'performance_index'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'father_content'); ?>
		<?php echo $form->textField($model,'father_content'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->