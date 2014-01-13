<div id="mainPage" class="main">
    <?php
$this->breadcrumbs=array(
	'Cobject Themes'=>array('index'),
	'Create',
);
    $title=Yii::t('default', 'Create a new CobjectTheme');
    $contextDesc = Yii::t('default', 'Available actions that may be taken on CobjectTheme.');
    $this->menu=array(
        array('label'=> Yii::t('default', 'List CobjectTheme'), 'url'=>array('index'),'description' => Yii::t('default', 'This action list all Cobject Themes, you can search, delete and update')),
    );
    ?>
    <div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">
            <?php echo $this->renderPartial('_form', array('model'=>$model,'title'=>$title)); ?>        </div>
        <div class="columntwo">
            <?php echo $this->renderPartial('////common/defaultcontext', array('contextDesc'=>$contextDesc)); ?>        </div>
    </div>
</div>