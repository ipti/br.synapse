<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ID'); ?>
		<?php echo $form->textField($model,'ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'organizationID'); ?>
		<?php echo $form->textField($model,'organizationID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fatherID'); ?>
		<?php echo $form->textField($model,'fatherID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'locationID'); ?>
		<?php echo $form->textField($model,'locationID'); ?>
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
		<?php echo $form->label($model,'actDate'); ?>
		<?php echo $form->textField($model,'actDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'desDate'); ?>
		<?php echo $form->textField($model,'desDate'); ?>
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