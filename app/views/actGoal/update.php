<div id="mainPage" class="main">
    <?php
    $this->breadcrumbs = array(
        'Act Goals' => array('index'),
        $model->name => array('view', 'id' => $model->id),
        'Update',
    );

    $title = Yii::t('default', 'Update ActGoal: ');
    $contextDesc = Yii::t('default', 'Available actions that may be taken on ActGoal.');
    $this->menu = array(
        array('label' => Yii::t('default', 'Create a new ActGoal'), 'url' => array('create'), 'description' => Yii::t('default', 'This action create a new ActGoal')),
        array('label' => Yii::t('default', 'List ActGoal'), 'url' => array('index'), 'description' => Yii::t('default', 'This action list all Act Goals, you can search, delete and update')),
    );
    ?>

    <div class="twoColumn">
        <div class="columnone" style="padding-right: 1em">
            <?php
            echo $this->renderPartial('_form', array('model' => $model, 'modalities' => $modalities,
                'skills' => $skills,
                'contents' => $contents, 'title' => $title));
            ?>        </div>
        <div class="columntwo">
            <?php echo $this->renderPartial('////common/defaultcontext', array('contextDesc' => $contextDesc)); ?>        </div>
    </div>
</div>