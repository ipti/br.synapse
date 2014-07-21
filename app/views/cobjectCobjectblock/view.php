<?php
$this->breadcrumbs=array(
	'Cobject Cobjectblocks'=>array('index'),
	$model->id,
);
$contextDesc = Yii::t('default', 'Available actions that may be taken on CobjectCobjectblock.');
$this->menu=array(
array('label'=> Yii::t('default', 'Create a new CobjectCobjectblock'), 'url'=>array('create'),'description' => Yii::t('default', 'This action create a new CobjectCobjectblock')),
array('label'=> Yii::t('default', 'List CobjectCobjectblock'), 'url'=>array('index'),'description' => Yii::t('default', 'This action list all Cobject Cobjectblocks, you can search, delete and update')),
); 
?>
<div id="mainPage" class="main">
    <div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">
            <div class="panelGroup form">
                <div class="panelGroupHeader"><div class=""><?php echo Yii::t('default', 'View CobjectCobjectblock # '.$model->id.' :')?></div></div>
                <div class="panelGroupBody">
                    <?php $this->widget('zii.widgets.CDetailView', array(
                    'data'=>$model,
                    'attributes'=>array(
                    		'id',
		'cobject_id',
		'cobject_block_id',
                    ),
                    )); ?>
                </div>   
            </div>
        </div>
        <div class="columntwo">
            <?php echo $this->renderPartial('////common/defaultcontext', array('contextDesc'=>$contextDesc)); ?>        </div>
    </div>
</div>