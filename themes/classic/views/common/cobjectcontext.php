<div class="ibox">
    <div class="iboxHeader ">
        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/theme_icon_cobject.png">
        <h4><?php echo Yii::t('default', 'Cobject Manager') ?></h4><blockquote><?php echo Yii::t('default', 'Cobject manager and other possibles configurations.') ?></blockquote>
    </div>
    <div class="iboxContent">
        <ul>
            <li>
                <a href="<?php echo Yii::app()->createUrl('actContent/create');?>">
                    <span><?php echo Yii::t('default', 'Create a new cobject') ?></span>
                    <blockquote>
                        <span><?php echo Yii::t('default', 'This function create a new cobject based on template') ?></span>
                    </blockquote>
                </a>
            </li>
            <li>
                <a href="<?php echo Yii::app()->createUrl('cobjectTemplate/index');?>">
                    <span><?php echo Yii::t('default', 'Templates') ?></span>
                    <blockquote>
                        <span><?php echo Yii::t('default', 'Create and manager availables templates for cobjects') ?>.</span>
                    </blockquote>
                </a>
            </li>
            <li>
                <a href="<?php echo Yii::app()->createUrl('cobjectTheme/index');?>">
                    <span><?php echo Yii::t('default', 'Themes') ?></span>
                    <blockquote>
                        <span><?php echo Yii::t('default', 'Create and manager availables themes for cobjects') ?>.</span>
                    </blockquote>
                </a>
            </li>
            <li>
                <a href="<?php echo Yii::app()->createUrl('cobjectBlock/index');?>">
                    <span><?php echo Yii::t('default', 'Blocks') ?></span>
                    <blockquote>
                        <span><?php echo Yii::t('default', 'Create and manager availables blocks for cobjects') ?>.</span>
                    </blockquote>
                </a>
            </li>
        </ul>
    </div>
</div>