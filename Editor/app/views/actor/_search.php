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
		<?php echo $form->label($model,'person_id'); ?>
		<?php echo $form->textField($model,'person_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'personage_id'); ?>
		<?php echo $form->textField($model,'personage_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fk_code'); ?>
		<?php echo $form->textArea($model,'fk_code',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'active_date'); ?>
		<?php echo $form->textField($model,'active_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'desactive_date'); ?>
		<?php echo $form->textField($model,'desactive_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'classroom_fk'); ?>
		<?php echo $form->textField($model,'classroom_fk'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'inep_id'); ?>
		<?php echo $form->textField($model,'inep_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->