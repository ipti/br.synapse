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
		<?php echo $form->label($model,'unity_id'); ?>
		<?php echo $form->textField($model,'unity_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'person_id'); ?>
		<?php echo $form->textField($model,'person_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'personage_id'); ?>
		<?php echo $form->textField($model,'personage_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'activated_date'); ?>
		<?php echo $form->textField($model,'activated_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'desactivated_date'); ?>
		<?php echo $form->textField($model,'desactivated_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->