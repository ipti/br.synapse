<?php
$this->pageTitle = Yii::app()->name . ' - Login';
$this->breadcrumbs = array(
    'Login',
);
?>

<div id="loginForm" class="form" style="margin-bottom:20px">
    <h1>Login Synapse</h1>
    <div class="innerContent">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'login-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
                ));
        ?>
        <div class="formField">
            <?php echo $form->labelEx($model, 'username'); ?>
            <?php echo $form->textField($model, 'username'); ?>
            <?php echo $form->error($model, 'username'); ?>
        </div>

        <div class="formField">
            <?php echo $form->labelEx($model, 'password'); ?>
            <?php echo $form->passwordField($model, 'password'); ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>
        <div class="formField buttonWizardBar">
            <?php echo CHtml::submitButton('Login', array('class' => 'buttonLink button')); ?>
        </div>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->
<div id="loginAlert" class="alert alert-block">
        <h4><?php echo Yii::t('default', 'Forgotten Password?')?></h4>
        <p><a  href="#"><?php echo Yii::t('default', 'Reset your password')?></a> <?php echo Yii::t('default', 'using email address.')?></p>
</div>