<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'userclass-form',
    'enableAjaxValidation' => false,
        ));
?>
<div class="panelGroup form">
    <?php echo $form->errorSummary($model); ?>
    <div class="panelGroupHeader"><div class=""> <?php echo $title; ?>
        </div></div>
    <div class="panelGroupBody">
        <div class="panelGroupAbout">
            <?php echo Yii::t('default', 'Fields with * are required.') ?></div>

        <div class="formField">
            <?php echo $form->labelEx($model, 'name'); ?>
            <?php echo $form->textField($model, 'name', array('size' => 45, 'maxlength' => 45)); ?>
            <?php echo $form->error($model, 'name'); ?>
        </div>

        <div class="formField">
            <?php echo $form->labelEx($model, 'sysID'); ?>
            <?php echo $form->dropDownList($model, 'sysID', CHtml::listData(UserSystem::model()->findAll(), 'ID', 'name')); ?>
            <?php echo $form->error($model, 'sysID'); ?>
        </div>

        <div class="formField">
            <?php echo $form->labelEx($model, 'degreeID'); ?>
            <?php echo $form->dropDownList($model, 'degreeID', CHtml::listData(ActDegree::model()->findAllByAttributes(array('degreeParent' => null)), 'ID', 'name'),array('onchange' => 'resetMultItens();','ajax' => array('type' => 'POST', 'url' => CController::createUrl('userclass/loadmatrix'), 'update' => '#matrixID'))); ?>
            <?php echo $form->error($model, 'degreeID'); ?>
        </div>

        <div class="formField">
            <?php echo $form->labelEx($model, 'code'); ?>
            <?php echo $form->textField($model, 'code', array('rows' => 6, 'cols' => 50)); ?>
            <?php echo $form->error($model, 'code'); ?>
        </div>
    </div>
</div>
<div class="panelGroup form">
    <div class="panelGroupHeader"><div class=""> <?php echo Yii::t('default', 'Add Matrix') ?></div></div>
    <div class="panelGroupBody">
        <div class="formField">
            <?php echo CHtml::dropDownList('disciplineID', '', CHtml::listData(ActDiscipline::model()->findAll(), 'ID', 'name'), array('empty' => Yii::t('default', 'NONE'), 'ajax' => array('type' => 'POST', 'url' => CController::createUrl('userclass/loadmatrix'), 'update' => '#matrixID'))); ?>
            <?php echo CHtml::dropDownList('matrixID', '', array()); ?>
            <?php echo CHtml::button(Yii::t('default', 'Add'), array('onclick' => 'addItem(\'UserclassMatrix\')', 'id' => 'addClass', 'class' => 'buttonLink button')); ?>
        </div>
        <ul class="multItens">
            <?php
            if (isset($matrixes)) {
                foreach ($matrixes as $matrix) {
                    echo '<li><input type="hidden" value="' . $matrix->matrixID . '" name="UserclassMatrix[]">'.$matrix->matrix->discipline->name.' | '.$matrix->matrix->name . ' - <a id="' . $matrix->matrixID . '" onclick="delItem($(this))" href="javascript:void(0)">' . Yii::t('default', 'Remove') . '</a>';
                }
            }
            ?>
        </ul>
        <div class="formField buttonWizardBar">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('default', 'Create') : Yii::t('default', 'Save'), array('class' => 'buttonLink button')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

