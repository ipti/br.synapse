<?php
$this->breadcrumbs = array(
    'Act Matrixes' => array('index'),
    $model->name,
);
$contextDesc = Yii::t('default', 'Available actions that may be taken on ActMatrix.');
$this->menu = array(
    array('label' => Yii::t('default', 'Create a new ActMatrix'), 'url' => array('create'), 'description' => Yii::t('default', 'This action create a new ActMatrix')),
    array('label' => Yii::t('default', 'List ActMatrix'), 'url' => array('index'), 'description' => Yii::t('default', 'This action list all Act Matrixes, you can search, delete and update')),
);
?>
<div id="mainPage" class="main">
    <div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">
            <div class="panelGroup form">
                <div class="panelGroupHeader"><div class=""><?php echo Yii::t('default', 'View ActMatrix # ' . $model->ID . ' :') ?></div></div>
                <div class="panelGroupBody">
                    <?php
                    $this->widget('zii.widgets.CDetailView', array(
                        'data' => $model,
                        'attributes' => array(
                            'ID',
                            'name',
                            array(
                                'name' => 'disciplineID',
                                'value' => $model->discipline->name,
                            ),
                            array(
                                'name' => 'degreeID',
                                'value' => (isset($model->degree) ? $model->degree->name: "N/A"),
                            ),
                            array(
                                'name' => 'Goals',
                                'value' => $listItens,
                            )
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