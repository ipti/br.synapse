<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'act-content-form',
    'enableAjaxValidation' => false,
        ));
?>
<div class="panelGroup form">
    <?php echo $form->errorSummary($model); ?>
    <div class="panelGroupHeader"><div class=""> <?php echo $title; ?>
        </div></div>
    <div class="panelGroupBody">
        <div class="panelGroupAbout">
            <?php echo Yii::t('default', 'Fields with * are required.') ?></div>

        <div class="formField">
            <?php echo $form->labelEx($model, 'content_parent'); ?>
            <?php echo $form->dropDownList($model, 'content_parent', CHtml::listData(ActContent::model()->findAll(), 'id', 'description'),array('empty'=>Yii::t('default','NONE'))); ?>
            <?php echo $form->error($model, 'content_parent'); ?>
        </div>

        <div class="formField">
            <?php echo $form->labelEx($model, 'discipline_id'); ?>
              <?php echo $form->dropDownList($model, 'discipline_id', CHtml::listData(ActDiscipline::model()->findAll(), 'id', 'name')); ?>
            <?php echo $form->error($model, 'discipline_id'); ?>
        </div>

        <div class="formField">
            <?php echo $form->labelEx($model, 'description'); ?>
            <?php echo $form->textArea($model, 'description', array('rows' => 6, 'cols' => 50)); ?>
            <?php echo $form->error($model, 'description'); ?>
        </div>

        <div class="formField buttonWizardBar">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('default', 'Create') : Yii::t('default', 'Save'), array('class' => 'buttonLink button')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
