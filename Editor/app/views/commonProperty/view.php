<?php
$this->breadcrumbs=array(
	'Common Properties'=>array('index'),
	$model->name,
);
$contextDesc = Yii::t('default', 'Available actions that may be taken on CommonProperty.');
$this->menu=array(
array('label'=> Yii::t('default', 'Create a new CommonProperty'), 'url'=>array('create'),'description' => Yii::t('default', 'This action create a new CommonProperty')),
array('label'=> Yii::t('default', 'List CommonProperty'), 'url'=>array('index'),'description' => Yii::t('default', 'This action list all Common Properties, you can search, delete and update')),
); 
?>
<div id="mainPage" class="main">
    <div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">
            <div class="panelGroup form">
                <div class="panelGroupHeader"><div class=""><?php echo Yii::t('default', 'View CommonProperty # '.$model->ID.' :')?></div></div>
                <div class="panelGroupBody">
                    <?php $this->widget('zii.widgets.CDetailView', array(
                    'data'=>$model,
                    'attributes'=>array(
                    		'ID',
		'name',
		'context',
                    ),
                    )); ?>
                </div>   
            </div>
        </div>
        <div class="columntwo">
            <?php echo $this->renderPartial('////common/defaultcontext', array('contextDesc'=>$contextDesc)); ?>        </div>
    </div>
</div>