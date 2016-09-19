<div id="mainPage" class="main">
<?php
$this->breadcrumbs=array(
	'Users',
);
$contextDesc = Yii::t('default', 'Available actions that may be taken on User.');
$this->menu=array(
array('label'=> Yii::t('default', 'Create a new User'), 'url'=>array('create'),'description' => Yii::t('default', 'This action create a new User')),
); 

?>
<div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">
            <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div class="alert alert-success">
                    <?php echo Yii::app()->user->getFlash('success') ?>
                </div>
            <?php endif ?>
            <div class="panelGroup form">
                <div class="panelGroupHeader"><div class=""><?php echo Yii::t('default', 'Users')?></div></div>
                <div class="panelGroupBody">
                    <?php $this->widget('zii.widgets.grid.CGridView', array(
                        'dataProvider' => $dataProvider,
                        'enablePagination' => true,
                        'baseScriptUrl' => Yii::app()->theme->baseUrl . '/plugins/gridview/',
                        'columns' => array(
		'name',
		'login',
		array(
                                'name' => 'sysID',
                                'value' => '$data->sys->name',
                            ),
		'email',
                     array('class' => 'CButtonColumn',),),
                    )); ?>
                </div>   
            </div>
        </div>
        <div class="columntwo">
           <?php echo $this->renderPartial('////common/defaultcontext', array('contextDesc'=>$contextDesc)); ?>        </div>
    </div>

</div>
