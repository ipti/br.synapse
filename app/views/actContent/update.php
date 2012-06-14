<div id="mainPage" class="main">
    <?php
$this->breadcrumbs=array(
	'Act Contents'=>array('index'),
	$model->ID=>array('view','id'=>$model->ID),
	'Update',
);

    $title=Yii::t('default', 'Update ActContent: ');
    $contextDesc = Yii::t('default', 'Available actions that may be taken on ActContent.');
    $this->menu=array(
    array('label'=> Yii::t('default', 'Create a new ActContent'), 'url'=>array('create'),'description' => Yii::t('default', 'This action create a new ActContent')),
    array('label'=> Yii::t('default', 'List ActContent'), 'url'=>array('index'),'description' => Yii::t('default', 'This action list all Act Contents, you can search, delete and update')),
    );  
    ?>

    <div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">
            <?php echo $this->renderPartial('_form', array('model'=>$model,'title'=>$title)); ?>        </div>
        <div class="columntwo">
            <?php echo $this->renderPartial('////common/defaultcontext', array('contextDesc'=>$contextDesc)); ?>        </div>
    </div>
</div>