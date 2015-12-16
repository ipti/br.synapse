<div id="mainPage" class="main">
    <?php
    $this->breadcrumbs = array(
        'Act Degrees',
    );
    $contextDesc = Yii::t('default', 'Available actions that may be taken on ActDegree.');
    $this->menu = array(
        array('label' => Yii::t('default', 'Create a new ActDegree'), 'url' => array('create'), 'description' => Yii::t('default', 'This action create a new ActDegree')),
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
                <div class="panelGroupHeader"><div class=""><?php echo Yii::t('default', 'Act Degrees') ?></div></div>
                <div class="panelGroupBody">
                    <?php
                    $this->widget('zii.widgets.grid.CGridView', array(
                        'dataProvider' => $dataProvider,
                        'enablePagination' => true,
                        'baseScriptUrl' => Yii::app()->theme->baseUrl . '/plugins/gridview/',
                        'columns' => array(
                            'name',
                            'stage',
                            'year',
                            'grade',
                            array(
                                'name' => 'degreeParent',
                                'value' => '(isset($data->degreeParent0) ? $data->degreeParent0->name: "N/A")',
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
