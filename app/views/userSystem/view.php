<?php
$this->breadcrumbs=array(
	'User Systems'=>array('index'),
	$model->name,
);
$contextDesc = Yii::t('default', 'Available actions that may be taken on UserSystem.');
$this->menu=array(
array('label'=> Yii::t('default', 'Create a new UserSystem'), 'url'=>array('create'),'description' => Yii::t('default', 'This action create a new UserSystem')),
array('label'=> Yii::t('default', 'List UserSystem'), 'url'=>array('index'),'description' => Yii::t('default', 'This action list all User Systems, you can search, delete and update')),
); 
?>
<div id="mainPage" class="main">
    <div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">
            <div class="panelGroup form">
                <div class="panelGroupHeader"><div class=""><?php echo Yii::t('default', 'View UserSystem # '.$model->ID.' :')?></div></div>
                <div class="panelGroupBody">
                    <?php $this->widget('zii.widgets.CDetailView', array(
                    'data'=>$model,
                    'attributes'=>array(
                    		'ID',
		'name',
		'logo',
		'url',
		'webservice',
                    ),
                    )); ?>
                </div>   
            </div>
        </div>
        <div class="columntwo">
            <?php echo $this->renderPartial('////common/defaultcontext', array('contextDesc'=>$contextDesc)); ?>        </div>
    </div>
</div>