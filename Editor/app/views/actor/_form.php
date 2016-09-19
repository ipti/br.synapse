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
                        <?php echo $form->labelEx($model,'person_id'); ?>
                        <?php echo $form->textField($model,'person_id'); ?>
                        <?php echo $form->error($model,'person_id'); ?>
                    </div>

                                        <div class="formField">
                        <?php echo $form->labelEx($model,'personage_id'); ?>
                        <?php echo $form->textField($model,'personage_id'); ?>
                        <?php echo $form->error($model,'personage_id'); ?>
                    </div>

                                        <div class="formField">
                        <?php echo $form->labelEx($model,'fk_code'); ?>
                        <?php echo $form->textArea($model,'fk_code',array('rows'=>6, 'cols'=>50)); ?>
                        <?php echo $form->error($model,'fk_code'); ?>
                    </div>

                                        <div class="formField">
                        <?php echo $form->labelEx($model,'active_date'); ?>
                        <?php echo $form->textField($model,'active_date'); ?>
                        <?php echo $form->error($model,'active_date'); ?>
                    </div>

                                        <div class="formField">
                        <?php echo $form->labelEx($model,'desactive_date'); ?>
                        <?php echo $form->textField($model,'desactive_date'); ?>
                        <?php echo $form->error($model,'desactive_date'); ?>
                    </div>

                                        <div class="formField">
                        <?php echo $form->labelEx($model,'classroom_fk'); ?>
                        <?php echo $form->textField($model,'classroom_fk'); ?>
                        <?php echo $form->error($model,'classroom_fk'); ?>
                    </div>

                                        <div class="formField">
                        <?php echo $form->labelEx($model,'inep_id'); ?>
                        <?php echo $form->textField($model,'inep_id'); ?>
                        <?php echo $form->error($model,'inep_id'); ?>
                    </div>

                                    <div class="formField buttonWizardBar">
                    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('default', 'Create') : Yii::t('default', 'Save'),array('class' => 'buttonLink button')); ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
