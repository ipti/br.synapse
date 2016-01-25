<?php
$this->breadcrumbs = array(
    'Users' => array('index'),
    $model->name,
);
$contextDesc = Yii::t('default', 'Available actions that may be taken on User.');
$this->menu = array(
    array('label' => Yii::t('default', 'Create a new User'), 'url' => array('create'), 'description' => Yii::t('default', 'This action create a new User')),
    array('label' => Yii::t('default', 'List User'), 'url' => array('index'), 'description' => Yii::t('default', 'This action list all Users, you can search, delete and update')),
);
?>
<div id="mainPage" class="main">
    <div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">
            <div class="panelGroup form">
                <div class="panelGroupHeader"><div class=""><?php echo Yii::t('default', 'View User # ' . $model->ID . ' :') ?></div></div>
                <div class="panelGroupBody">
                    <?php
                    $this->widget('zii.widgets.CDetailView', array(
                        'data' => $model,
                        'attributes' => array(
                            'ID',
                            'name',
                            'login',
                            array(
                                'name' => 'sysID',
                                'value' => $model->sys->name,
                            ),
                            'email',
                            'password',
                             array('name'=>'Classes', 'value'=> $listClass),
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