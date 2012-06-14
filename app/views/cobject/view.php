<?php
$this->breadcrumbs = array(
    'Cobjects' => array('index'),
    $model->ID,
);
$contextDesc = Yii::t('default', 'Available actions that may be taken on Cobject.');
$this->menu = array(
    array('label' => Yii::t('default', 'Create a new Cobject'), 'url' => array('create'), 'description' => Yii::t('default', 'This action create a new Cobject')),
    array('label' => Yii::t('default', 'List Cobject'), 'url' => array('index'), 'description' => Yii::t('default', 'This action list all Cobjects, you can search, delete and update')),
);
?>
<div id="mainPage" class="main">
    <div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">
            <div class="panelGroup form">
                <div class="panelGroupHeader"><div class=""><?php echo Yii::t('default', 'View Cobject # ' . $model->ID . ' :') ?></div></div>
                <div class="panelGroupBody">
                    <?php
                    $this->widget('zii.widgets.CDetailView', array(
                        'data' => $model,
                        'attributes' => array(
                            'ID',
                            array(
                                'name' => 'typeID',
                                'value' => $model->type->name,
                            ),
                            array(
                                'name' => 'templateID',
                                'value' => $model->template->name,
                            ),
                            array(
                                'name' => 'themeID',
                                'value' => $model->theme->name,
                            ),
                        ),
                    ));
                    ?>
                </div>   
            </div>
        </div>
        <div class="columntwo">
<?php echo $this->renderPartial('////common/defaultcontext', array('contextDesc' => $contextDesc)); ?>        </div>
    </div>
</div>