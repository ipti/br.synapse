<?php
$this->breadcrumbs=array(
	'Organizations'=>array('index'),
	$model->name,
);
$contextDesc = Yii::t('default', 'Available actions that may be taken on Organization.');
$this->menu=array(
array('label'=> Yii::t('default', 'Create a new Organization'), 'url'=>array('create'),'description' => Yii::t('default', 'This action create a new Organization')),
array('label'=> Yii::t('default', 'List Organization'), 'url'=>array('index'),'description' => Yii::t('default', 'This action list all Organizations, you can search, delete and update')),
); 
?>
<div id="mainPage" class="main">
    <div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">
            <div class="panelGroup form">
                <div class="panelGroupHeader"><div class=""><?php echo Yii::t('default', 'View Organization # '.$model->id.' :')?></div></div>
                <div class="panelGroupBody">
                    <?php $this->widget('zii.widgets.CDetailView', array(
                    'data'=>$model,
                    'attributes'=>array(
                    		'id',
		'acronym',
		'name',
		'father_id',
		'orglevel',
		'degree_id',
		'autochild',
                    ),
                    )); ?>
                </div>   
            </div>
        </div>
        <div class="columntwo">
            <?php echo $this->renderPartial('////common/defaultcontext', array('contextDesc'=>$contextDesc)); ?>        </div>
    </div>
</div>