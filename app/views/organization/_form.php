<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'organization-form',
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
                        <?php echo $form->labelEx($model,'acronym'); ?>
                        <?php echo $form->textField($model,'acronym',array('size'=>30,'maxlength'=>30)); ?>
                        <?php echo $form->error($model,'acronym'); ?>
                    </div>

                                        <div class="formField">
                        <?php echo $form->labelEx($model,'name'); ?>
                        <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>60)); ?>
                        <?php echo $form->error($model,'name'); ?>
                    </div>

                                        <div class="formField">
                        <?php echo $form->labelEx($model,'father_id'); ?>
                        <?php echo $form->textField($model,'father_id'); ?>
                        <?php echo $form->error($model,'father_id'); ?>
                    </div>

                                        <div class="formField">
                        <?php echo $form->labelEx($model,'orglevel'); ?>
                        <?php echo $form->textField($model,'orglevel'); ?>
                        <?php echo $form->error($model,'orglevel'); ?>
                    </div>

                                        <div class="formField">
                        <?php echo $form->labelEx($model,'degree_id'); ?>
                        <?php echo $form->textField($model,'degree_id'); ?>
                        <?php echo $form->error($model,'degree_id'); ?>
                    </div>

                                        <div class="formField">
                        <?php echo $form->labelEx($model,'autochild'); ?>
                        <?php echo $form->textField($model,'autochild'); ?>
                        <?php echo $form->error($model,'autochild'); ?>
                    </div>

                                    <div class="formField buttonWizardBar">
                    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('default', 'Create') : Yii::t('default', 'Save'),array('class' => 'buttonLink button')); ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
