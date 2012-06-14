<?php
$this->breadcrumbs=array(
	'Act Disciplines'=>array('index'),
	$model->name,
);
$contextDesc = Yii::t('default', 'Available actions that may be taken on ActDiscipline.');
$this->menu=array(
array('label'=> Yii::t('default', 'Create a new ActDiscipline'), 'url'=>array('create'),'description' => Yii::t('default', 'This action create a new ActDiscipline')),
array('label'=> Yii::t('default', 'List ActDiscipline'), 'url'=>array('index'),'description' => Yii::t('default', 'This action list all Act Disciplines, you can search, delete and update')),
); 
?>
<div id="mainPage" class="main">
    <div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">
            <div class="panelGroup form">
                <div class="panelGroupHeader"><div class=""><?php echo Yii::t('default', 'View ActDiscipline # '.$model->ID.' :')?></div></div>
                <div class="panelGroupBody">
                    <?php $this->widget('zii.widgets.CDetailView', array(
                    'data'=>$model,
                    'attributes'=>array(
                    		'ID',
		'name',
                    ),
                    )); ?>
                </div>   
            </div>
        </div>
        <div class="columntwo">
            <?php echo $this->renderPartial('////common/defaultcontext', array('contextDesc'=>$contextDesc)); ?>        </div>
    </div>
</div>