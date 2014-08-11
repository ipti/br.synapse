<?php
$this->breadcrumbs=array(
	'Cobject Elements'=>array('index'),
	$model->id,
);
$contextDesc = Yii::t('default', 'Available actions that may be taken on CobjectElement.');
$this->menu=array(
array('label'=> Yii::t('default', 'Create a new CobjectElement'), 'url'=>array('create'),'description' => Yii::t('default', 'This action create a new CobjectElement')),
array('label'=> Yii::t('default', 'List CobjectElement'), 'url'=>array('index'),'description' => Yii::t('default', 'This action list all Cobject Elements, you can search, delete and update')),
); 
?>
<div id="mainPage" class="main">
    <div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">
            <div class="panelGroup form">
                <div class="panelGroupHeader"><div class=""><?php echo Yii::t('default', 'View CobjectElement # '.$model->id.' :')?></div></div>
                <div class="panelGroupBody">
                    <?php $this->widget('zii.widgets.CDetailView', array(
                    'data'=>$model,
                    'attributes'=>array(
                    		'id',
		'cobject_id',
		'element_id',
		'position',
		'oldID',
                    ),
                    )); ?>
                </div>   
            </div>
        </div>
        <div class="columntwo">
            <?php echo $this->renderPartial('////common/defaultcontext', array('contextDesc'=>$contextDesc)); ?>        </div>
    </div>
</div>