<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'act-goal-form',
    'enableAjaxValidation' => false,
        ));
?>

<script type="text/javascript">
   var phpMsgRemove = "<?php echo Yii::t("default", "Remove"); ?>";
</script>

<?php
$baseUrl = Yii::app()->theme->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl . "/js/actGoal/actGoal.js");
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
            <?php echo $form->labelEx($model, 'degree_id'); ?>
            <?php echo $form->dropDownList($model, 'degree_id', CHtml::listData(ActDegree::model()->findAll('degree_parent IS NOT NULL'), 'id', 'name')); ?>                    
            <?php echo $form->error($model, 'degree_id'); ?>
        </div>

        <div class="formField">
            <?php echo $form->labelEx($model, 'discipline_id'); ?>
            <?php echo $form->dropDownList($model, 'discipline_id', CHtml::listData(ActDiscipline::model()->findAll(), 'id', 'name'), array('ajax' => array('type' => 'POST', 'url' => CController::createUrl('actGoal/loadcontent'), 'update' => '#contentID'))); ?>                    
            <?php echo $form->error($model, 'discipline_id'); ?>
        </div>
    </div>
</div>
<div class="panelGroup form">
    <div class="panelGroupHeader"><div><?php echo Yii::t('default', 'Add Modality') ?></div></div>
    <div class="panelGroupBody">
        <div class="formField">
            <?php echo CHtml::dropDownList('modalityID', '', CHtml::listData(ActModality::model()->findAll(), 'id', 'name')); ?>
            <?php echo CHtml::button(Yii::t('default', 'Add'), array('onclick' => 'addItem(\'ActGoalModality\')', 'id' => 'addGoalModality', 'class' => 'buttonLink button')); ?>
        </div>
        <ul id="modalityItens" class="multItens">
            <?php
            if (isset($modalities)) {
                foreach ($modalities as $modality) {
                    echo '<li><input type="hidden" value="' . $modality->modality_id . '" name="ActGoalModality[]">' . $modality->modality->name . ' - <a id="' . $modality->modality_id . '" onclick="delItem($(this))" href="javascript:void(0)">' . Yii::t('default', 'Remove') . '</a>';
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
            <?php echo CHtml::dropDownList('skillID', '', CHtml::listData(ActSkill::model()->findAll(), 'id', 'name')); ?>
            <?php echo CHtml::button(Yii::t('default', 'Add'), array('onclick' => 'addItem(\'ActGoalSkill\')', 'id' => 'addGoalSkill', 'class' => 'buttonLink button')); ?>
        </div>
        <ul id="skillItens" class="multItens">
            <?php
            if (isset($skills)) {
                foreach ($skills as $skill) {
                    echo '<li><input type="hidden" value="' . $skill->skill_id . '" name="ActGoalSkill[]">' . $skill->skill->name . ' - <a id="' . $skill->skill_id . '" onclick="delItem($(this))" href="javascript:void(0)">' . Yii::t('default', 'Remove') . '</a>';
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
                    echo '<li><input type="hidden" value="' . $content->content_id . '" name="ActGoalContent[]">' . $content->content->description . ' - <a id="' . $content->content_id . '" onclick="delItem($(this))" href="javascript:void(0)">' . Yii::t('default', 'Remove') . '</a>';
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
