<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'act-script-form',
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
            <?php echo $form->labelEx($model, 'disciplineID'); ?>
            <?php echo $form->dropDownList($model, 'disciplineID', CHtml::listData(ActDiscipline::model()->findAll(), 'ID', 'name'),array('ajax' => array('type' => 'POST', 'url' => CController::createUrl('actscript/loadcontentparent'), 'update' => '#ActScript_contentParentID'))); ?>
            <?php echo $form->error($model, 'disciplineID'); ?>
        </div>

        <div class="formField">
            <?php echo $form->labelEx($model, 'contentParentID'); ?>
            <?php echo $form->dropDownList($model, 'contentParentID', CHtml::listData(ActContent::model()->findAll(), 'ID', 'description'),array('empty'=>'NONE','ajax' => array('type' => 'POST', 'url' => CController::createUrl('actscript/loadcontents'), 'update' => '.contents'))); ?>
            <?php echo $form->error($model, 'contentParentID'); ?>
        </div>
        
        <div class="formField">
            <?php echo $form->labelEx($model, 'performanceIndice'); ?>
            <?php echo $form->textField($model, 'performanceIndice'); ?>
            <?php echo $form->error($model, 'performanceIndice'); ?>
        </div>
    </div>
</div>
<div class="panelGroup form">
    <div class="panelGroupHeader"><div><?php echo Yii::t('default', 'Contents Include') ?></div></div>
    <div class="panelGroupBody">
        <div class="formField">
            <?php echo CHtml::dropDownList('contentInID', '', array(),array('class'=>'contents')); ?>
            <?php echo CHtml::button(Yii::t('default', 'Add'), array('onclick' => 'addItem(\'ActScriptContentIn\')', 'id' => 'addGoalModality', 'class' => 'buttonLink button')); ?>
        </div>
        <ul id="contentInItens" class="multItens">
            <?php
            if (isset($contentsin)) {
                foreach ($contentsin as $cin) {
                    echo '<li><input type="hidden" value="' . $cin->contentID . '" name="ActScriptContentIn[]">' . $cin->content->description . ' - <a id="' . $cin->contentID . '" onclick="delItem($(this))" href="javascript:void(0)">' . Yii::t('default', 'Remove') . '</a>';
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
                    echo '<li><input type="hidden" value="' . $out->contentID . '" name="ActScriptContentOut[]">' . $out->content->description . ' - <a id="' .  $out->contentID . '" onclick="delItem($(this))" href="javascript:void(0)">' . Yii::t('default', 'Remove') . '</a>';
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
