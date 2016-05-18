<?php
$this->breadcrumbs=array(
	'Actors'=>array('index'),
	$model->id,
);
$contextDesc = Yii::t('default', 'Available actions that may be taken on Actor.');
$this->menu=array(
array('label'=> Yii::t('default', 'Create a new Actor'), 'url'=>array('create'),'description' => Yii::t('default', 'This action create a new Actor')),
array('label'=> Yii::t('default', 'List Actor'), 'url'=>array('index'),'description' => Yii::t('default', 'This action list all Actors, you can search, delete and update')),
); 
?>
<div id="mainPage" class="main">
    <div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">
            <div class="panelGroup form">
                <div class="panelGroupHeader"><div class=""><?php echo Yii::t('default', 'View Actor # '.$model->id.' :')?></div></div>
                <div class="panelGroupBody">
                    <?php $this->widget('zii.widgets.CDetailView', array(
                    'data'=>$model,
                    'attributes'=>array(
                    		'id',
		'person_id',
		'personage_id',
		'fk_code',
		'active_date',
		'desactive_date',
		'classroom_fk',
		'inep_id',
                    ),
                    )); ?>
                </div>   
            </div>
        </div>
        <div class="columntwo">
            <?php echo $this->renderPartial('////common/defaultcontext', array('contextDesc'=>$contextDesc)); ?>        </div>
    </div>
</div>