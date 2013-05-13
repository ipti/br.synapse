<html>
    <head>
        <title> Login-Render </title> 
    </head>
      <body>
                   
          <?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
    'enableAjaxValidation' => false,
        ));

$title = "Login"; 

?>      
          
<div> <!-- Alterar as Classes -->
    <?php echo $form->errorSummary($model); ?>
    <div ><div align ="center" > <?php echo $title; ?>
        </div></div>
    <br>
    <div align="center">
        <div >
            <?php echo Yii::t('default', 'Fields with * are required.') ?></div>
        <div >
            <?php echo $form->labelEx($model, 'username'); ?>
            <?php echo $form->textField($model, 'username', array('rows' => 6, 'cols' => 50)); ?>
            <?php echo $form->error($model, 'username'); ?>
        </div>
        <div >
            <?php echo $form->labelEx($model, 'password'); ?>
            <?php echo $form->passwordField($model, 'password', array('size' => 20, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>
        <div >
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>
        <div>
        <?php  echo CHtml::submitButton('Entrar'); ?>
        </div>
    </div>
</div>
<div>
        
<?php $this->endWidget(); ?>
    
</div>

      </body>
</html>


