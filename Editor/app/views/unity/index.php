<div id="mainPage" class="main">
<?php
$this->breadcrumbs=array(
	'Unities',
);
$contextDesc = Yii::t('default', 'Available actions that may be taken on Unity.');
$this->menu=array(
array('label'=> Yii::t('default', 'Create a new Unity'), 'url'=>array('create'),'description' => Yii::t('default', 'This action create a new Unity')),
); 

?>
<div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">
            <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div class="alert alert-success">
                    <?php echo Yii::app()->user->getFlash('success') ?>
                </div>
                <br/>
            <?php endif ?>
            <div class="panelGroup form">
                <div class="panelGroupHeader"><div class=""><?php echo Yii::t('default', 'Unities')?></div></div>
                <div class="panelGroupBody">
                    <?php $this->widget('zii.widgets.grid.CGridView', array(
                        'dataProvider' => $dataProvider,
                        'enablePagination' => true,
                        'baseScriptUrl' => Yii::app()->theme->baseUrl . '/plugins/gridview/',
                        'columns' => array(
                            'name',
                            array(
                                'name'=>'organization_id',
                                'value'=>'$data->organization->name',
                            ),
                     array('class' => 'CButtonColumn',),),
                    )); ?>
                </div>   
            </div>
        </div>
        <div class="columntwo">
           <?php echo $this->renderPartial('////common/defaultcontext', array('contextDesc'=>$contextDesc)); ?>        </div>
    </div>

</div>
