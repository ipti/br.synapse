<?php
$unityfather = Yii::app()->session['unityIdActor'];
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'person-form',
    'enableAjaxValidation' => false,
        ));
?>

    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/renderize.js"></script>
    <script>
        var unity;
        var newRenderize;
        $(function() {
            unity = <?php echo $unityfather ?>;
            newRenderize= new renderize();

            $.ajax({
                url:"/render/json",//this is the request page of ajax
                data:{op:'select', id:unity},//data for throwing the expected url
                type:"POST",
                dataType:"json",// you can also specify for the result for json or xml
                success:function(response){
                    newRenderize.startRenderize(response, 'class');
                },
                error:function(){
                }
            });

        });
    </script>

<div class="panelGroup form" style="clear:none">
    <?php echo $form->errorSummary($model); ?>
    <div class="panelGroupHeader"><div class=""> <?php echo $title; ?>
        </div></div>
    <div class="panelGroupBody">
        <div class="panelGroupAbout">
            <?php echo Yii::t('default', 'Fields with * are required.') ?></div>
        
        <duv id="filter">
            <input type="hidden" id="UnityFather" value="<?php  echo $unityfather; ?>"/>
            <div id="box_0" class="box formField"></div>
        </div>

        <div class="formField">
            <?php echo $form->labelEx($model, 'name'); ?>
            <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 60)); ?>
            <?php echo $form->error($model, 'name'); ?>
        </div>

        <div class="formField">
            <?php echo $form->labelEx($model, 'login'); ?>
            <?php echo $form->textField($model, 'login', array('rows' => 6, 'cols' => 50)); ?>
            <?php echo $form->error($model, 'login'); ?>
        </div>

        <div class="formField">
            <?php echo $form->labelEx($model, 'email'); ?>
            <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'email'); ?>
        </div>

        <div class="formField">
            <?php echo $form->labelEx($model, 'password'); ?>
            <?php echo $form->passwordField($model, 'password', array('size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>

        <div class="formField">
            <?php echo $form->labelEx($model, 'phone'); ?>
            <?php echo $form->textField($model, 'phone'); ?>
            <?php echo $form->error($model, 'phone'); ?>
        </div>

        <div class="formField buttonWizardBar">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('default', 'Create') : Yii::t('default', 'Save'), array('class' => 'buttonLink button')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
