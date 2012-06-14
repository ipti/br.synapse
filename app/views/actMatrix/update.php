<div id="mainPage" class="main">
    <?php
$this->breadcrumbs=array(
	'Act Matrixes'=>array('index'),
	$model->name=>array('view','id'=>$model->ID),
	'Update',
);

    $title=Yii::t('default', 'Update ActMatrix: ');
    $contextDesc = Yii::t('default', 'Available actions that may be taken on ActMatrix.');
    $this->menu=array(
    array('label'=> Yii::t('default', 'Create a new ActMatrix'), 'url'=>array('create'),'description' => Yii::t('default', 'This action create a new ActMatrix')),
    array('label'=> Yii::t('default', 'List ActMatrix'), 'url'=>array('index'),'description' => Yii::t('default', 'This action list all Act Matrixes, you can search, delete and update')),
    );  
    ?>

    <div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">
            <?php echo $this->renderPartial('_form', array('model'=>$model,'goals'=>$goals,'title'=>$title)); ?>        </div>
        <div class="columntwo">
            <?php echo $this->renderPartial('////common/defaultcontext', array('contextDesc'=>$contextDesc)); ?>        </div>
    </div>
</div>