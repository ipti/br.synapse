<?php
$this->breadcrumbs = array(
    'Userclasses' => array('index'),
    $model->name,
);
$contextDesc = Yii::t('default', 'Available actions that may be taken on Userclass.');
$this->menu = array(
    array('label' => Yii::t('default', 'Create a new Userclass'), 'url' => array('create'), 'description' => Yii::t('default', 'This action create a new Userclass')),
    array('label' => Yii::t('default', 'List Userclass'), 'url' => array('index'), 'description' => Yii::t('default', 'This action list all Userclasses, you can search, delete and update')),
);
?>
<div id="mainPage" class="main">
    <div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">
            <div class="panelGroup form">
                <div class="panelGroupHeader"><div class=""><?php echo Yii::t('default', 'View Userclass # ' . $model->ID . ' :') ?></div></div>
                <div class="panelGroupBody">
                    <?php
                    $this->widget('zii.widgets.CDetailView', array(
                        'data' => $model,
                        'attributes' => array(
                            'ID',
                            'name',
                            array(
                                'name' => 'sysID',
                                'value' => $model->sys->name,
                            ),
                            array(
                                'name' => 'Matrixes',
                                'value' => $listItens,
                            ),
                            array(
                                'name' => 'degreeID',
                                'value' => (isset($model->degree) ? $model->degree->name: "N/A"),
                            ),
                            'code', 
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