<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'cobject-form',
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
            <?php echo $form->labelEx($model, 'typeID'); ?>
            <?php echo $form->dropDownList($model, 'typeID', CHtml::listData(CommonType::model()->findAllByAttributes(array('context' => 'Cobject')), 'ID', 'name')); ?>
            <?php echo $form->error($model, 'typeID'); ?>
        </div>

        <div class="formField">
            <?php echo $form->labelEx($model, 'templateID'); ?>
            <?php echo $form->dropDownList($model, 'templateID', CHtml::listData(CobjectTemplate::model()->findAll(), 'ID', 'name')); ?>
            <?php echo $form->error($model, 'templateID'); ?>
        </div>

        <div class="formField">
            <?php echo $form->labelEx($model, 'themeID'); ?>
            <?php echo $form->dropDownList($model, 'themeID', CHtml::listData(CobjectTheme::model()->findAll(), 'ID', 'name')); ?>
            <?php echo $form->error($model, 'themeID'); ?>
        </div>
    </div>
</div>
<div class="panelGroup form">
    <div class="panelGroupHeader"><div><?php echo Yii::t('default', 'Cobject Metadata') ?></div></div>
    <div class="panelGroupBody">
        <?php
        $types = CommonType::model()->findAllByAttributes(array('context' => 'CobjectData'));
        foreach ($types as $type) {
            $comp = "";
            $comp .= '<div class="formField">';
            $comp .= $form->labelEx($metadata, $type->name);
            switch ($type->htmlType) {
                case 'textfield':
                    $comp .= $form->textField($metadata, $type->name);
                    break;
                case 'dropdown':
                    eval("\$comp .= \$form->dropDownList(\$metadata, \$type->name, $type->htmlSource);");
                    //$comp .= $form->dropDownList($metadata, $type->name, eval($type->htmlSource));
                    break;
                case 'textarea':
                    $comp .= $form->textArea($metadata, $type->name);
                    break;
                case 'radio':
                    $comp .= $form->radioButtonList($metadata, $type->name, eval($type->htmlSource));
                    break;
                case 'checkbox':
                    $comp .= $form->checkBoxList($metadata, $type->name, eval($type->htmlSource));
                    break;
                default:
                    break;
            }
            $comp .= $form->error($metadata, $type->name);
            $comp .= '</div>';
        }
        echo $comp;
        ?>

    </div>
</div>
<div class="formField buttonWizardBar">
    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('default', 'Create') : Yii::t('default', 'Save'), array('class' => 'buttonLink button')); ?>
</div>
<?php $this->endWidget(); ?>