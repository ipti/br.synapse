<?php
$this->breadcrumbs=array(
	'Common Types'=>array('index'),
	$model->name,
);
$contextDesc = Yii::t('default', 'Available actions that may be taken on CommonType.');
$this->menu=array(
array('label'=> Yii::t('default', 'Create a new CommonType'), 'url'=>array('create'),'description' => Yii::t('default', 'This action create a new CommonType')),
array('label'=> Yii::t('default', 'List CommonType'), 'url'=>array('index'),'description' => Yii::t('default', 'This action list all Common Types, you can search, delete and update')),
); 
?>
<div id="mainPage" class="main">
    <div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">
            <div class="panelGroup form">
                <div class="panelGroupHeader"><div class=""><?php echo Yii::t('default', 'View CommonType # '.$model->ID.' :')?></div></div>
                <div class="panelGroupBody">
                    <?php $this->widget('zii.widgets.CDetailView', array(
                    'data'=>$model,
                    'attributes'=>array(
                    		'ID',
		'context',
		'name',
		array(
                                'name' => 'typeParent',
                                'value' => (isset($model->typeParent0) ? $model->typeParent0->name: "N/A"),
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