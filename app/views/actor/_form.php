<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'actor-form',
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
                        <?php echo $form->labelEx($model,'unityID'); ?>
                        <?php echo $form->textField($model,'unityID'); ?>
                        <?php echo $form->error($model,'unityID'); ?>
                    </div>

                                        <div class="formField">
                        <?php echo $form->labelEx($model,'personID'); ?>
                        <?php echo $form->textField($model,'personID'); ?>
                        <?php echo $form->error($model,'personID'); ?>
                    </div>

                                        <div class="formField">
                        <?php echo $form->labelEx($model,'personageID'); ?>
                        <?php echo $form->textField($model,'personageID'); ?>
                        <?php echo $form->error($model,'personageID'); ?>
                    </div>

                                        <div class="formField">
                        <?php echo $form->labelEx($model,'activatedDate'); ?>
                        <?php echo $form->textField($model,'activatedDate'); ?>
                        <?php echo $form->error($model,'activatedDate'); ?>
                    </div>

                                        <div class="formField">
                        <?php echo $form->labelEx($model,'desactivatedDate'); ?>
                        <?php echo $form->textField($model,'desactivatedDate'); ?>
                        <?php echo $form->error($model,'desactivatedDate'); ?>
                    </div>

                                    <div class="formField buttonWizardBar">
                    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('default', 'Create') : Yii::t('default', 'Save'),array('class' => 'buttonLink button')); ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
