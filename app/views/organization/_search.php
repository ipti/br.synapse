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
		<?php echo $form->label($model,'acronym'); ?>
		<?php echo $form->textField($model,'acronym',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'father_id'); ?>
		<?php echo $form->textField($model,'father_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'orglevel'); ?>
		<?php echo $form->textField($model,'orglevel'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'degree_id'); ?>
		<?php echo $form->textField($model,'degree_id'); ?>
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