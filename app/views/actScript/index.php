<div id="mainPage" class="main">
<?php
$this->breadcrumbs=array(
	'Act Scripts',
);
$contextDesc = Yii::t('default', 'Available actions that may be taken on ActScript.');
$this->menu=array(
array('label'=> Yii::t('default', 'Create a new ActScript'), 'url'=>array('create'),'description' => Yii::t('default', 'This action create a new ActScript')),
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
                <div class="panelGroupHeader"><div class=""><?php echo Yii::t('default', 'Act Scripts')?></div></div>
                <div class="panelGroupBody">
                    <?php $this->widget('zii.widgets.grid.CGridView', array(
                        'dataProvider' => $dataProvider,
                        'enablePagination' => true,
                        'baseScriptUrl' => Yii::app()->theme->baseUrl . '/plugins/gridview/',
                        'columns' => array(
		array(
                                'name' => 'discipline',
                                'value' => '$data->discipline->name',
                            ),
		'performance_index',
		array(
                                'name' => 'father_content',
                                'value' => '(isset($data->father_content) ? $data->fatherContent->description: "N/A")',
                            ),
                     array('class' => 'CButtonColumn',),),
                    )); ?>
                </div>   
            </div>
        </div>
        <div class="columntwo">
           <?php echo $this->renderPartial('////common/defaultcontext', array('contextDesc'=>$contextDesc)); ?>        </div>
    </div>

</div>
