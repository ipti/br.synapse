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
		<?php echo $form->label($model,'unityID'); ?>
		<?php echo $form->textField($model,'unityID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'personID'); ?>
		<?php echo $form->textField($model,'personID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'personageID'); ?>
		<?php echo $form->textField($model,'personageID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'activatedDate'); ?>
		<?php echo $form->textField($model,'activatedDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'desactivatedDate'); ?>
		<?php echo $form->textField($model,'desactivatedDate'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->