<div class="ibox">
    <div class="iboxHeader ">
        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/theme_icon_goal.png">
        <h4><?php echo Yii::t('default', 'Goal Manager') ?></h4><blockquote><?php echo Yii::t('default', 'Goal manager and other possibles configurations.') ?></blockquote>
    </div>
    <div class="iboxContent">
        <ul>
            <li>
                <a href="<?php echo Yii::app()->createUrl('actGoal/create');?>">
                    <span><?php echo Yii::t('default', 'Create a new goal') ?></span>
                    <blockquote>
                        <span><?php echo Yii::t('default', 'This function create a new cobject based on template') ?></span>
                    </blockquote>
                </a>
            </li>
            <li>
                <a href="<?php echo Yii::app()->createUrl('actModality/index');?>">
                    <span><?php echo Yii::t('default', 'Modality') ?></span>
                    <blockquote>
                        <span><?php echo Yii::t('default', 'Create and manager availables templates for cobjects') ?>.</span>
                    </blockquote>
                </a>
            </li>
            <li>
                <a href="<?php echo Yii::app()->createUrl('actModality/index');?>">
                    <span><?php echo Yii::t('default', 'Skill') ?></span>
                    <blockquote>
                        <span><?php echo Yii::t('default', 'Create and manager availables themes for cobjects') ?>.</span>
                    </blockquote>
                </a>
            </li>
            <li>
                <a href="/create">
                    <span><?php echo Yii::t('default', 'Matrix') ?></span>
                    <blockquote>
                        <span><?php echo Yii::t('default', 'Create and manager availables blocks for cobjects') ?>.</span>
                    </blockquote>
                </a>
            </li>
        </ul>
    </div>
</div>