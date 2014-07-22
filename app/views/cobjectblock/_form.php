<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cobjectblock-form',
	'enableAjaxValidation'=>false,
)); ?>
        <div class="panelGroup form">
            <?php echo $form->errorSummary($model); ?>
            <div class="panelGroupHeader"><div class=""> <?php echo $title; ?>
</div></div>
            <div class="panelGroupBody">
                <div class="panelGroupAbout">
                     <?php echo Yii::t('default', 'Fields with * are required.')?></div>

                                    <div class="formField">
                        <?php echo $form->labelEx($model,'name'); ?>
                        <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>60)); ?>
                        <?php echo $form->error($model,'name'); ?>
                    </div>

                                        <div class="formField">
                        <?php echo $form->labelEx($model,'discipline_id'); ?>
                        <?php echo $form->textField($model,'discipline_id'); ?>
                        <?php echo $form->error($model,'discipline_id'); ?>
                    </div>

                                    <div class="formField buttonWizardBar">
                    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('default', 'Create') : Yii::t('default', 'Save'),array('class' => 'buttonLink button')); ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
