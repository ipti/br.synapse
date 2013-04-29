<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-system-form',
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
                        <?php echo $form->labelEx($model,'logo'); ?>
                        <?php echo $form->textField($model,'logo',array('size'=>60,'maxlength'=>255)); ?>
                        <?php echo $form->error($model,'logo'); ?>
                    </div>

                                        <div class="formField">
                        <?php echo $form->labelEx($model,'url'); ?>
                        <?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>255)); ?>
                        <?php echo $form->error($model,'url'); ?>
                    </div>

                                        <div class="formField">
                        <?php echo $form->labelEx($model,'webservice'); ?>
                        <?php echo $form->textField($model,'webservice',array('size'=>60,'maxlength'=>255)); ?>
                        <?php echo $form->error($model,'webservice'); ?>
                    </div>

                                    <div class="formField buttonWizardBar">
                    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('default', 'Create') : Yii::t('default', 'Save'),array('class' => 'buttonLink button')); ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>