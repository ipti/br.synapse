<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'act-matrix-form',
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
            <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 60)); ?>
            <?php echo $form->error($model, 'name'); ?>
        </div>

        <div class="formField">
            <?php echo $form->labelEx($model, 'disciplineID'); ?>
            <?php echo $form->dropDownList($model, 'disciplineID', CHtml::listData(ActDiscipline::model()->findAll(), 'ID', 'name'), array('onchange' => 'resetMultItens();','empty' => Yii::t('default', 'NONE'), 'ajax' => array('type' => 'POST', 'url' => CController::createUrl('actmatrix/loadgoal'), 'update' => '#goalID'))); ?>
            <?php echo $form->error($model, 'disciplineID'); ?>
        </div>
        
        <div class="formField">
            <?php echo $form->labelEx($model, 'degreeID'); ?>
            <?php echo $form->dropDownList($model, 'degreeID', CHtml::listData(ActDegree::model()->findAllByAttributes(array('degreeParent'=>null)), 'ID', 'name'),array('onchange' => 'resetMultItens();','ajax' => array('type' => 'POST', 'url' => CController::createUrl('actmatrix/loadgoal'), 'update' => '#goalID'))); ?>
            <?php echo $form->error($model, 'degreeID'); ?>
        </div>
    </div>
</div>
<div class="panelGroup form">
    <div class="panelGroupHeader"><div class=""> <?php echo Yii::t('default', 'Add Goal') ?></div></div>
    <div class="panelGroupBody">
        <div class="formField">
            <?php echo CHtml::dropDownList('goalID', '', array()); ?>
            <?php echo CHtml::button(Yii::t('default', 'Add'), array('onclick' => 'addItem(\'ActGoalMatrix\')', 'id' => 'addGoalMatrix', 'class' => 'buttonLink button')); ?>
        </div>
        <ul class="multItens">
            <?php
            if (isset($goals)) {
                foreach ($goals as $goal) {
                    echo '<li><input type="hidden" value="' . $goal->goalID . '" name="ActGoalMatrix[]">'.$goal->goal->name. ' - <a id="' . $goal->goalID . '" onclick="delItem($(this))" href="javascript:void(0)">' . Yii::t('default', 'Remove') . '</a>';
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