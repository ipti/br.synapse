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
		<?php echo $form->label($model,'disciplineID'); ?>
		<?php echo $form->textField($model,'disciplineID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'performanceIndice'); ?>
		<?php echo $form->textField($model,'performanceIndice'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contentParentID'); ?>
		<?php echo $form->textField($model,'contentParentID'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->