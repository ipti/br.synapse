<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cobject-element-form',
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
                        <?php echo $form->labelEx($model,'cobject_id'); ?>
                        <?php echo $form->textField($model,'cobject_id'); ?>
                        <?php echo $form->error($model,'cobject_id'); ?>
                    </div>

                                        <div class="formField">
                        <?php echo $form->labelEx($model,'element_id'); ?>
                        <?php echo $form->textField($model,'element_id'); ?>
                        <?php echo $form->error($model,'element_id'); ?>
                    </div>

                                        <div class="formField">
                        <?php echo $form->labelEx($model,'position'); ?>
                        <?php echo $form->textField($model,'position'); ?>
                        <?php echo $form->error($model,'position'); ?>
                    </div>

                                        <div class="formField">
                        <?php echo $form->labelEx($model,'oldID'); ?>
                        <?php echo $form->textField($model,'oldID'); ?>
                        <?php echo $form->error($model,'oldID'); ?>
                    </div>

                                    <div class="formField buttonWizardBar">
                    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('default', 'Create') : Yii::t('default', 'Save'),array('class' => 'buttonLink button')); ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
