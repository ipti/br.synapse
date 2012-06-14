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
		<?php echo $form->label($model,'typeID'); ?>
		<?php echo $form->textField($model,'typeID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'templateID'); ?>
		<?php echo $form->textField($model,'templateID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'themeID'); ?>
		<?php echo $form->textField($model,'themeID'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->