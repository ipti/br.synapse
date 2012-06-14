<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'act-goal-form',
    'enableAjaxValidation' => false,
        ));
?>
<div class="panelGroup form">
    <?php echo $form->errorSummary($model); ?>
    <div class="panelGroupHeader"><div class=""> <?php echo $title; ?>
        </div></div>
    <div class="panelGroupBody">
        <div class="formField">
            <?php echo $form->labelEx($model, 'name'); ?>
            <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 60)); ?>
            <?php echo $form->error($model, 'name'); ?>
        </div>

        <div class="formField">
            <?php echo $form->labelEx($model, 'degreeID'); ?>
            <?php echo $form->dropDownList($model, 'degreeID', CHtml::listData(ActDegree::model()->findAll('degreeParent IS NOT NULL'), 'ID', 'name')); ?>                    
            <?php echo $form->error($model, 'degreeID'); ?>
        </div>

        <div class="formField">
            <?php echo $form->labelEx($model, 'disciplineID'); ?>
            <?php echo $form->dropDownList($model, 'disciplineID', CHtml::listData(ActDiscipline::model()->findAll(), 'ID', 'name'),array('ajax' => array('type' => 'POST', 'url' => CController::createUrl('actgoal/loadcontent'), 'update' => '#contentID'))); ?>                    
            <?php echo $form->error($model, 'disciplineID'); ?>
        </div>
 </div>
</div>
<div class="panelGroup form">
    <div class="panelGroupHeader"><div><?php echo Yii::t('default', 'Add Modality') ?></div></div>
    <div class="panelGroupBody">
        <div class="formField">
            <?php echo CHtml::dropDownList('modalityID', '', CHtml::listData(ActModality::model()->findAll(), 'ID', 'name')); ?>
            <?php echo CHtml::button(Yii::t('default', 'Add'), array('onclick' => 'addItem(\'ActGoalModality\')', 'id' => 'addGoalModality', 'class' => 'buttonLink button')); ?>
        </div>
        <ul id="modalityItens" class="multItens">
            <?php
            if (isset($modalities)) {
                foreach ($modalities as $modality) {
                    echo '<li><input type="hidden" value="' . $modality->modalityID . '" name="ActGoalModality[]">' . $modality->modality->name . ' - <a id="' . $modality->modalityID . '" onclick="delItem($(this))" href="javascript:void(0)">' . Yii::t('default', 'Remove') . '</a>';
                }
            }
            ?>
        </ul>
    </div>
</div>
<div class="panelGroup form">
    <div class="panelGroupHeader"><div class=""> <?php echo Yii::t('default', 'Add Skill') ?></div></div>
    <div class="panelGroupBody">
        <div class="formField">
            <?php echo CHtml::dropDownList('skillID', '', CHtml::listData(ActSkill::model()->findAll(), 'ID', 'name')); ?>
            <?php echo CHtml::button(Yii::t('default', 'Add'), array('onclick' => 'addItem(\'ActGoalSkill\')', 'id' => 'addGoalSkill', 'class' => 'buttonLink button')); ?>
        </div>
        <ul id="skillItens" class="multItens">
            <?php
            if (isset($skills)) {
                foreach ($skills as $skill) {
                    echo '<li><input type="hidden" value="' . $skill->skillID . '" name="ActGoalSkill[]">' . $skill->skill->name . ' - <a id="' . $skill->skillID . '" onclick="delItem($(this))" href="javascript:void(0)">' . Yii::t('default', 'Remove') . '</a>';
                }
            }
            ?>
        </ul>
    </div>
</div>
<div class="panelGroup form">
    <div class="panelGroupHeader"><div class=""> <?php echo Yii::t('default', 'Add Content') ?></div></div>
    <div class="panelGroupBody">
        <div class="formField">
            <?php echo CHtml::dropDownList('contentID', '', array()); ?>
            <?php echo CHtml::button(Yii::t('default', 'Add'), array('onclick' => 'addItem(\'ActGoalContent\')', 'id' => 'addGoalContent', 'class' => 'buttonLink button')); ?>
        </div>
        <ul id="contentItens" class="multItens">
            <?php
            if (isset($contents)) {
                foreach ($contents as $content) {
                    echo '<li><input type="hidden" value="' . $content->contentID . '" name="ActGoalContent[]">' . $content->content->description . ' - <a id="' . $content->contentID . '" onclick="delItem($(this))" href="javascript:void(0)">' . Yii::t('default', 'Remove') . '</a>';
                }
            }
            ?>
        </ul>
    </div>
</div>
<div class="formField buttonWizardBar">
    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('default', 'Create') : Yii::t('default', 'Save'), array('class' => 'buttonLink button')); ?>
</div>
<?php $this->endWidget(); ?>
