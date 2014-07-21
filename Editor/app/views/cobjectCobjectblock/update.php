<div id="mainPage" class="main">
    <?php
$this->breadcrumbs=array(
	'Cobject Cobjectblocks'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

    $title=Yii::t('default', 'Update CobjectCobjectblock: ');
    $contextDesc = Yii::t('default', 'Available actions that may be taken on CobjectCobjectblock.');
    $this->menu=array(
    array('label'=> Yii::t('default', 'Create a new CobjectCobjectblock'), 'url'=>array('create'),'description' => Yii::t('default', 'This action create a new CobjectCobjectblock')),
    array('label'=> Yii::t('default', 'List CobjectCobjectblock'), 'url'=>array('index'),'description' => Yii::t('default', 'This action list all Cobject Cobjectblocks, you can search, delete and update')),
    );  
    ?>

    <div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">
            <?php echo $this->renderPartial('_form', array('model'=>$model,'title'=>$title)); ?>        </div>
        <div class="columntwo">
            <?php echo $this->renderPartial('////common/defaultcontext', array('contextDesc'=>$contextDesc)); ?>        </div>
    </div>
</div>