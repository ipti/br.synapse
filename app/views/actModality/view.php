<?php
$this->breadcrumbs = array(
    'Act Modalities' => array('index'),
    $model->name,
);
$contextDesc = Yii::t('default', 'Available actions that may be taken on ActModality.');
$this->menu = array(
    array('label' => Yii::t('default', 'Create a new ActModality'), 'url' => array('create'), 'description' => Yii::t('default', 'This action create a new ActModality')),
    array('label' => Yii::t('default', 'List ActModality'), 'url' => array('index'), 'description' => Yii::t('default', 'This action list all Act Modalities, you can search, delete and update')),
);
?>
<div id="mainPage" class="main">
    <div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">
            <div class="panelGroup form">
                <div class="panelGroupHeader"><div class=""><?php echo Yii::t('default', 'View ActModality # ' . $model->ID . ' :') ?></div></div>
                <div class="panelGroupBody">
                    <?php
                    $this->widget('zii.widgets.CDetailView', array(
                        'data' => $model,
                        'attributes' => array(
                            'name',
                            array(
                                'name' => 'modalityParent',
                                'value' => (isset($model->modalityParent0) ? $model->modalityParent0->name: "N/A"),
                            ),
                            )));
                    ?>
                </div>   
            </div>
        </div>
        <div class="columntwo">
            <?php echo $this->renderPartial('////common/defaultcontext', array('contextDesc' => $contextDesc)); ?>        </div>
    </div>
</div>