<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'act-script-form',
    'enableAjaxValidation' => false,
        ));

$baseUrl = Yii::app()->theme->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl . "/js/actScript/actScript.js");

?>
<script type="text/javascript">
   var phpMsgRemove = "<?php echo Yii::t("default", "Remove"); ?>";
</script>
<div class="panelGroup form">
    <?php echo $form->errorSummary($model); ?>
    <div class="panelGroupHeader"><div class=""> <?php echo $title; ?>
        </div></div>
    <div class="panelGroupBody">
        <div class="panelGroupAbout">
            <?php echo Yii::t('default', 'Fields with * are required.') ?></div>

        <div class="formField">
            <?php echo $form->labelEx($model, 'discipline_id'); ?>
            <?php echo $form->dropDownList($model, 'discipline_id', CHtml::listData(ActDiscipline::model()->findAll(), 'id', 'name') , array('ajax' => array('type' => 'POST', 'url' => CController::createUrl('actScript/loadcontentparent'), 'update' => '#ActScript_father_content'), 'prompt'=> 'Selecione ...')); ?>
            <?php echo $form->error($model, 'discipline_id'); ?>
        </div>

        <div class="formField">
            <?php echo $form->labelEx($model, 'father_content'); ?>
            <?php echo $form->dropDownList($model, 'father_content', CHtml::listData(ActContent::model()->findAll(), 'id', 'description'),array('empty'=>'NONE','ajax' => array('type' => 'POST', 'url' => CController::createUrl('actScript/loadcontents'), 'update' => '.contents'))); ?>
            <?php echo $form->error($model, 'father_content'); ?>
        </div>
        
        <div class="formField">
            <?php echo $form->labelEx($model, 'performance_index'); ?>
            <?php echo $form->textField($model, 'performance_index'); ?>
            <?php echo $form->error($model, 'performance_index'); ?>
        </div>
    </div>
</div>
<div class="panelGroup form">
    <div class="panelGroupHeader"><div><?php echo Yii::t('default', 'Contents Include') ?></div></div>
    <div class="panelGroupBody">
        <div class="formField">
            <?php  echo CHtml::dropDownList('contentInID', '', array(),array('class'=>'contents')); ?>
            <?php echo CHtml::button(Yii::t('default', 'Add'), array('onclick' => 'addItem(\'ActScriptContentIn\')', 'id' => 'addGoalModality', 'class' => 'buttonLink button')); ?>
            
        </div>
        <ul id="contentInItens" class="multItens">
            <?php
            if (isset($contentsin)) {
                foreach ($contentsin as $cin) {
                    echo '<li><input type="hidden" value="' . $cin->content_id . '" name="ActScriptContentIn[]">' . $cin->content->description . ' - <a id="' . $cin->content_id . '" onclick="delItem($(this))" href="javascript:void(0)">' . Yii::t('default', 'Remove') . '</a>';
                }
            }
            ?>
        </ul>
    </div>
</div>
<div class="panelGroup form">
    <div class="panelGroupHeader"><div><?php echo Yii::t('default', 'Contents Exclude') ?></div></div>
    <div class="panelGroupBody">
        <div class="formField">
            <?php echo CHtml::dropDownList('contentOutID', '',array(),array('class'=>'contents')); ?>
            <?php echo CHtml::button(Yii::t('default', 'Add'), array('onclick' => 'addItem(\'ActScriptContentOut\')', 'id' => 'addGoalModality', 'class' => 'buttonLink button')); ?>
        </div>
        <ul id="contentOutItens" class="multItens">
            <?php
            if (isset($contentsout)) {
                foreach ($contentsout as $out) {
                    echo '<li><input type="hidden" value="' . $out->content_id . '" name="ActScriptContentOut[]">' . $out->content->description . ' - <a id="' .  $out->content_id   . '" onclick="delItem($(this))" href="javascript:void(0)">' . Yii::t('default', 'Remove') . '</a>';
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
