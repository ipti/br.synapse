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
		<?php echo $form->label($model,'acronym'); ?>
		<?php echo $form->textField($model,'acronym',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fatherID'); ?>
		<?php echo $form->textField($model,'fatherID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'orgLevel'); ?>
		<?php echo $form->textField($model,'orgLevel'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'degreeID'); ?>
		<?php echo $form->textField($model,'degreeID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'autochild'); ?>
		<?php echo $form->textField($model,'autochild'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->