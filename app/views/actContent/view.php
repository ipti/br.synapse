<?php
$this->breadcrumbs=array(
	'Act Contents'=>array('index'),
	$model->ID,
);
$contextDesc = Yii::t('default', 'Available actions that may be taken on ActContent.');
$this->menu=array(
array('label'=> Yii::t('default', 'Create a new ActContent'), 'url'=>array('create'),'description' => Yii::t('default', 'This action create a new ActContent')),
array('label'=> Yii::t('default', 'List ActContent'), 'url'=>array('index'),'description' => Yii::t('default', 'This action list all Act Contents, you can search, delete and update')),
); 
?>
<div id="mainPage" class="main">
    <div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">
            <div class="panelGroup form">
                <div class="panelGroupHeader"><div class=""><?php echo Yii::t('default', 'View ActContent # '.$model->ID.' :')?></div></div>
                <div class="panelGroupBody">
                    <?php $this->widget('zii.widgets.CDetailView', array(
                    'data'=>$model,
                    'attributes'=>array(
                    		'ID',
		 array(
                                'name' => 'contentParentID',
                                'value' => (isset($model->contentParent0) ? $model->contentParent0->description: "N/A"),
                            ),
		array(
                                'name' => 'disciplineID',
                                'value' => $model->discipline->name,
                            ),
		'description',
                    ),
                    )); ?>
                </div>   
            </div>
        </div>
        <div class="columntwo">
            <?php echo $this->renderPartial('////common/defaultcontext', array('contextDesc'=>$contextDesc)); ?>        </div>
    </div>
</div>