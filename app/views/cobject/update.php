<div id="mainPage" class="main">
    <?php
$this->breadcrumbs=array(
	'Cobjects'=>array('index'),
	$model->ID=>array('view','id'=>$model->ID),
	'Update',
);

    $title=Yii::t('default', 'Update Cobject: ');
    $contextDesc = Yii::t('default', 'Available actions that may be taken on Cobject.');
    $this->menu=array(
    array('label'=> Yii::t('default', 'Create a new Cobject'), 'url'=>array('create'),'description' => Yii::t('default', 'This action create a new Cobject')),
    array('label'=> Yii::t('default', 'List Cobject'), 'url'=>array('index'),'description' => Yii::t('default', 'This action list all Cobjects, you can search, delete and update')),
    );  
    ?>

    <div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">
            <?php echo $this->renderPartial('_form', array('model'=>$model,'title'=>$title,'metadata'=>$metadata)); ?>        </div>
        <div class="columntwo">
            <?php echo $this->renderPartial('////common/defaultcontext', array('contextDesc'=>$contextDesc)); ?>        </div>
    </div>
</div>