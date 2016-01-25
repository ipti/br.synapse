<div id="mainPage" class="main">
    <?php
    $this->breadcrumbs = array(
        'Cobject Cobjectblocks' => array('index'),
        'Manage',
    );

    $this->menu = array(
        array('label' => 'List CobjectCobjectblock', 'url' => array('index')),
        array('label' => 'Create CobjectCobjectblock', 'url' => array('create')),
    );
    $this->menu = array(
        array('label' => Yii::t('default', 'Create a new CobjectCobjectblock'), 'url' => array('create'), 'description' => Yii::t('default', 'This action create a new CobjectCobjectblock')),
    );
    $contextDesc = Yii::t('default', 'Available actions that may be taken on CobjectCobjectblock.');

    Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('cobject-cobjectblock-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
    ?>


    <div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">

            <?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
            <div class="search-form" style="display:none">
                <?php $this->renderPartial('_search', array(
                    'model' => $model,
                )); ?>
            </div>
            <!-- search-form -->

            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'cobject-cobjectblock-grid',
                'dataProvider' => $model->search(),
                'filter' => $model,
                'columns' => array(
                    'id',
                    'cobject_id',
                    'cobject_block_id',
                    array(
                        'class' => 'CButtonColumn',
                    ),
                ),
            )); ?>
        </div>
        <div class="columntwo">
            <?php echo $this->renderPartial('////common/defaultcontext', array('contextDesc' => $contextDesc)); ?>
        </div>
    </div>

</div>
