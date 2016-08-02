

<?php
$form=$this->beginWidget('CActiveForm', array(
    'id'=>'cobject-cobjectblock-form',
    'enableAjaxValidation'=>false,
));

?>

<?php
$baseUrl = Yii::app()->theme->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl . "/js/cobjectCobjectblock/cobjectCobjectblock.js");
?>

<div class="panelGroup form">
    <?php
    echo $form->errorSummary($model);

    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
    ?>
    <div class="panelGroupHeader">
        <div class="">
            <?php echo $title; ?>
        </div>
    </div>
    <div class="panelGroupBody">
        <div class="panelGroupAbout">
            <?php echo Yii::t('default', 'Fields with * are required.')?>
        </div>

        <div class="panelGroupAbout">
            <?php echo Yii::t('default' , 'You should separe the numbers using a ";" ') ?>
        </div>


        <div class="formField">
            <?php echo $form->labelEx($model,'cobject_id'); ?>
            <?php echo $form->textArea($model, 'cobject_id', array('maxlength' => 100000)); ?>
            <?php echo $form->error($model,'cobject_id'); ?>
        </div>

        <div class="formField">
            <?php echo $form->labelEx($model,'cobject_block_id'); ?>
            <?php echo $form->dropdownlist($model,'cobject_block_id', chtml::listData(Cobjectblock::model()->findAll(), 'id', 'name')); ?>
            <?php echo $form->error($model,'cobject_block_id'); ?>
        </div>

        <div class="formField buttonWizardBar">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('default', 'Create') : Yii::t('default', 'Save'),array('class' => 'buttonLink button')); ?>
        </div>

        <div id="modal-cobjects-messages" class="nextLevel-message modal_message overlay">
            <div class="message-container success">

                <?php


                ?>
                <!--                <img class="ok message-icon" src="img/icons/raio_telapassagem.png">-->
                <!--                <p class="message">Parabéns, Por Finalizar essa Etapa!</p>-->
                <!--                <button class="message-button">OK</button>-->
            </div>
        </div
        <?php $this->endWidget(); ?>
    </div>
</div>

