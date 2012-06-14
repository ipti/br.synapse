<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
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
            <?php echo $form->labelEx($model, 'login'); ?>
            <?php echo $form->textField($model, 'login', array('rows' => 6, 'cols' => 50)); ?>
            <?php echo $form->error($model, 'login'); ?>
        </div>

        <div class="formField">
            <?php echo $form->labelEx($model, 'sysID'); ?>
            <?php echo $form->dropDownList($model, 'sysID', CHtml::listData(UserSystem::model()->findAll(), 'ID', 'name'), array('onchange' => 'resetMultItens();', 'empty' => Yii::t('default', 'NONE'), 'ajax' => array('type' => 'POST', 'url' => CController::createUrl('user/loadclasses'), 'update' => '#userClass'))); ?>
            <?php echo $form->error($model, 'sysID'); ?>
        </div>

        <div class="formField">
            <?php echo $form->labelEx($model, 'email'); ?>
            <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'email'); ?>
        </div>

        <div class="formField">
            <?php echo $form->labelEx($model, 'password'); ?>
            <?php echo $form->passwordField($model, 'password', array('size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>
    </div>
</div>
<div class="panelGroup form">
    <div class="panelGroupHeader"><div class=""> <?php echo Yii::t('default', 'Add classes') ?></div></div>
    <div class="panelGroupBody">
        <div class="formField">
            <?php echo CHtml::dropDownList('userClass', '', (isset($model->sysID) ? CHtml::listData(Userclass::model()->findAllByAttributes(array('sysID' => $model->sysID)), 'ID', 'name') : array())); ?>
            <?php echo CHtml::button(Yii::t('default', 'Add'), array('onclick' => 'addItem(\'UserClass\')', 'id' => 'addClass', 'class' => 'buttonLink button')); ?>
        </div>

        <ul class="multItens">
            <?php
            if (isset($classes)) {
                foreach ($classes as $class) {
                    echo '<li><input type="hidden" value="'.$class->class->ID.'" name="UserUserclass[]">'.$class->class->name.' - <a id="'.$class->class->ID.'" onclick="delItem($(this))" href="javascript:void(0)">'.Yii::t('default', 'Remove').'</a>';
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

