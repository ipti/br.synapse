<html>
    <head>
        <title> Login--Render </title> 
    </head>
      <body>
           
          
          <?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
    'enableAjaxValidation' => false,
        ));
$model = 'actor';
?>
<div class="panelGroup form">
    <?php echo $form->errorSummary($model); ?>
    <div class="panelGroupHeader"><div class=""> <?php echo $title; ?>
        </div></div>
    <div class="panelGroupBody">
        <div class="panelGroupAbout">
            <?php echo Yii::t('default', 'Fields with * are required.') ?></div>
        <div class="formField">
            <?php echo $form->labelEx($model, 'login'); ?>
            <?php echo $form->textField($model, 'login', array('rows' => 6, 'cols' => 50)); ?>
            <?php echo $form->error($model, 'login'); ?>
        </div>
        <div class="formField">
            <?php echo $form->labelEx($model, 'password'); ?>
            <?php echo $form->passwordField($model, 'password', array('size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>
    </div>
</div>
<div class="panelGroup form">
    <div class="panelGroupHeader"><div class=""> <?php echo Yii::t('default', 'Add classes') ?></div></div>
        <div class="formField buttonWizardBar">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('default', 'Create') : Yii::t('default', 'Save'), array('class' => 'buttonLink button')); ?>
        </div>
<?php $this->endWidget(); ?>
    
</div>

      </body>
</html>


