<div id="mainPage" class="main">
    <?php
    $this->breadcrumbs = array(
        'Users' => array('index'),
        $model->name => array('view', 'id' => $model->ID),
        'Update',
    );

    $title = Yii::t('default', 'Update User: ');
    $contextDesc = Yii::t('default', 'Available actions that may be taken on User.');
    $this->menu = array(
        array('label' => Yii::t('default', 'Create a new User'), 'url' => array('create'), 'description' => Yii::t('default', 'This action create a new User')),
        array('label' => Yii::t('default', 'List User'), 'url' => array('index'), 'description' => Yii::t('default', 'This action list all Users, you can search, delete and update')),
    );
    ?>

    <div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">
            <?php echo $this->renderPartial('_form', array('classes' => $classes, 'model' => $model, 'title' => $title)); ?>        </div>
        <div class="columntwo">
            <?php echo $this->renderPartial('////common/defaultcontext', array('contextDesc' => $contextDesc)); ?>        </div>
    </div>
</div>