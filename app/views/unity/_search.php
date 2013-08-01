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
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'organization_id'); ?>
		<?php echo $form->textField($model,'organization_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'father_id'); ?>
		<?php echo $form->textField($model,'father_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'location_id'); ?>
		<?php echo $form->textField($model,'location_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fcode'); ?>
		<?php echo $form->textField($model,'fcode',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'autochild'); ?>
		<?php echo $form->textField($model,'autochild'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'act_date'); ?>
		<?php echo $form->textField($model,'act_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'des_date'); ?>
		<?php echo $form->textField($model,'des_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'capacity'); ?>
		<?php echo $form->textField($model,'capacity'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->