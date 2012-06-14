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
            <?php echo $form->labelEx($model, 'contentParent'); ?>
            <?php echo $form->dropDownList($model, 'contentParent', CHtml::listData(ActContent::model()->findAll(), 'ID', 'description'),array('empty'=>Yii::t('default','NONE'))); ?>
            <?php echo $form->error($model, 'contentParent'); ?>
        </div>

        <div class="formField">
            <?php echo $form->labelEx($model, 'disciplineID'); ?>
              <?php echo $form->dropDownList($model, 'disciplineID', CHtml::listData(ActDiscipline::model()->findAll(), 'ID', 'name')); ?>
            <?php echo $form->error($model, 'disciplineID'); ?>
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
