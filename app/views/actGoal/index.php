<div id="mainPage" class="main">
    <?php
    $this->breadcrumbs = array(
        'Act Goals',
    );
    $contextDesc = Yii::t('default', 'Available actions that may be taken on ActGoal.');
    $this->menu = array(
        array('label' => Yii::t('default', 'Create a new ActGoal'), 'url' => array('create'), 'description' => Yii::t('default', 'This action create a new ActGoal')),
    );
    ?>
    <div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">
            <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div class="alert alert-success">
                    <?php echo Yii::app()->user->getFlash('success') ?>
                </div>
                <br/>
            <?php endif ?>
            <div class="panelGroup form">
                <div class="panelGroupHeader"><div class=""><?php echo Yii::t('default', 'Act Goals') ?></div></div>
                <div class="panelGroupBody">
                    <?php
                    $this->widget('zii.widgets.grid.CGridView', array(
                        'dataProvider' => $dataProvider,
                        'enablePagination' => true,
                        'baseScriptUrl' => Yii::app()->theme->baseUrl . '/plugins/gridview/',
                        'columns' => array(
                            'name',
                            array(
                                'name' => Yii::t('default', 'Degree'),
                                'value' => '$data->degree->name',
                            ),
                            array(
                                'name' => Yii::t('default', 'Discipline'),
                                'value' => '$data->discipline->name',
                            ),
                            array('class' => 'CButtonColumn',),),
                    ));
                    ?>
                </div>   
            </div>
        </div>
        <div class="columntwo">
<?php echo $this->renderPartial('////common/defaultcontext', array('contextDesc' => $contextDesc)); ?>        </div>
    </div>

</div>
