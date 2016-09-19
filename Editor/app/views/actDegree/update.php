<div id="mainPage" class="main">
    <?php
$this->breadcrumbs=array(
	'Act Degrees'=>array('index'),
	$model->name=>array('view','id'=>$model->ID),
	'Update',
);

    $title=Yii::t('default', 'Update ActDegree: ');
    $contextDesc = Yii::t('default', 'Available actions that may be taken on ActDegree.');
    $this->menu=array(
    array('label'=> Yii::t('default', 'Create a new ActDegree'), 'url'=>array('create'),'description' => Yii::t('default', 'This action create a new ActDegree')),
    array('label'=> Yii::t('default', 'List ActDegree'), 'url'=>array('index'),'description' => Yii::t('default', 'This action list all Act Degrees, you can search, delete and update')),
    );  
    ?>

    <div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">
            <?php echo $this->renderPartial('_form', array('model'=>$model,'title'=>$title)); ?>        </div>
        <div class="columntwo">
            <?php echo $this->renderPartial('////common/defaultcontext', array('contextDesc'=>$contextDesc)); ?>        </div>
    </div>
</div>