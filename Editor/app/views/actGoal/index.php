<div id="mainPage" class="main">
    <?php
    $this->breadcrumbs = array(
        'Act Goals',
    );
    $contextDesc = Yii::t('default', 'Available actions that may be taken on ActGoal.');
    $this->menu = array(
        array('label' => Yii::t('default', 'Create a new ActGoal'), 'url' => array('create'), 'description' => Yii::t('default', 'This action create a new ActGoal')),
    );

    $baseUrl = Yii::app()->theme->baseUrl;
    $cs = Yii::app()->getClientScript();
    $cs->registerScriptFile($baseUrl . "/js/actGoal/actGoal.js");
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
                        'dataProvider' => $filter->search(),
                        'enablePagination' => true,
                        'filter' => $filter,
                        'baseScriptUrl' => Yii::app()->theme->baseUrl . '/plugins/gridview/',
                        'columns' => array(
                            array(
                                'name' => 'name',
                                'value' => '$data->name',
                            ),
                            array(
                                'name' => 'degree_id',
                                'value' => '$data->degree->name',
                            ),
                            array(
                                'name' => 'discipline_id',
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
