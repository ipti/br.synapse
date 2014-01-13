<div id="mainPage" class="main">
    <?php
$this->breadcrumbs=array(
	'Act Matrixes'=>array('index'),
	'Create',
);
    $title=Yii::t('default', 'Create a new ActMatrix');
    $contextDesc = Yii::t('default', 'Available actions that may be taken on ActMatrix.');
    $this->menu=array(
        array('label'=> Yii::t('default', 'List ActMatrix'), 'url'=>array('index'),'description' => Yii::t('default', 'This action list all Act Matrixes, you can search, delete and update')),
    );
    ?>
    <div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">
            <?php echo $this->renderPartial('_form', array('model'=>$model,'title'=>$title)); ?>        </div>
        <div class="columntwo">
            <?php echo $this->renderPartial('////common/defaultcontext', array('contextDesc'=>$contextDesc)); ?>        </div>
    </div>
</div>