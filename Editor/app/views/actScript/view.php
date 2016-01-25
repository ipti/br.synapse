<?php
$this->breadcrumbs=array(
	'Act Scripts'=>array('index'),
	$model->ID,
);
$contextDesc = Yii::t('default', 'Available actions that may be taken on ActScript.');
$this->menu=array(
array('label'=> Yii::t('default', 'Create a new ActScript'), 'url'=>array('create'),'description' => Yii::t('default', 'This action create a new ActScript')),
array('label'=> Yii::t('default', 'List ActScript'), 'url'=>array('index'),'description' => Yii::t('default', 'This action list all Act Scripts, you can search, delete and update')),
); 
?>
<div id="mainPage" class="main">
    <div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">
            <div class="panelGroup form">
                <div class="panelGroupHeader"><div class=""><?php echo Yii::t('default', 'View ActScript # '.$model->ID.' :')?></div></div>
                <div class="panelGroupBody">
                    <?php $this->widget('zii.widgets.CDetailView', array(
                    'data'=>$model,
                    'attributes'=>array(
                         'ID' , 
		array(
                                'name' => 'disciplineID',
                                'value' => $model->discipline->name,
                            ),
		'performanceIndice',
                        array(
                                'name' => 'contentParentID',
                                'value' => (isset($model->contentParent) ? $model->contentParent->description: "N/A"),
                            ),
                    ),
                    )); ?>
                </div>   
            </div>
        </div>
        <div class="columntwo">
            <?php echo $this->renderPartial('////common/defaultcontext', array('contextDesc'=>$contextDesc)); ?>        </div>
    </div>
</div>