<?php
$this->breadcrumbs=array(
	'Cobjectblocks'=>array('index'),
	$model->name,
);
$contextDesc = Yii::t('default', 'Available actions that may be taken on Cobjectblock.');
$this->menu=array(
array('label'=> Yii::t('default', 'Create a new Cobjectblock'), 'url'=>array('create'),'description' => Yii::t('default', 'This action create a new Cobjectblock')),
array('label'=> Yii::t('default', 'List Cobjectblock'), 'url'=>array('index'),'description' => Yii::t('default', 'This action list all Cobjectblocks, you can search, delete and update')),
); 
?>
<div id="mainPage" class="main">
    <div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">
            <div class="panelGroup form">
                <div class="panelGroupHeader"><div class=""><?php echo Yii::t('default', 'View Cobjectblock # '.$model->id.' :')?></div></div>
                <div class="panelGroupBody">
                    <?php $this->widget('zii.widgets.CDetailView', array(
                    'data'=>$model,
                    'attributes'=>array(
                    		'id',
		'name',
		'discipline_id',
                    ),
                    )); ?>
                </div>   
            </div>
        </div>
        <div class="columntwo">
            <?php echo $this->renderPartial('////common/defaultcontext', array('contextDesc'=>$contextDesc)); ?>        </div>
    </div>
</div>