<div class="ibox">
    <div class="iboxHeader ">
        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/theme_icon_advanced.png">
        <h4><?php echo Yii::t('default', 'Advanced Configurations') ?></h4>
        <blockquote><?php echo Yii::t('default', 'User and other possibles configurations.') ?></blockquote>
    </div>
    <div class="iboxContent">
        <ul>
            <li>
                <a href="/user/create">
                    <span><?php echo Yii::t('default', 'Create a new user') ?></span>
                    <blockquote>
                        <span><?php echo Yii::t('default', 'Create a new user') ?></span>
                    </blockquote>
                </a>
            </li>
            <li>
                <a href="/user/list">
                    <span><?php echo Yii::t('default', 'List Users') ?></span>
                    <blockquote>
                        <span><?php echo Yii::t('default', 'List users by systems') ?>.</span>
                    </blockquote>
                </a>
            </li>
            <li>
                <a href="/create">
                    <span><?php echo Yii::t('default', 'Assign a class') ?></span>
                    <blockquote>
                        <span><?php echo Yii::t('default', 'Assign a user to class') ?>.</span>
                    </blockquote>
                </a>
            </li>
            <li>
                <a href="/create">
                    <span><?php echo Yii::t('default', 'Perfomance') ?></span>
                    <blockquote>
                        <span><?php echo Yii::t('default', 'List user perfomance by date') ?>.</span>
                    </blockquote>
                </a>
            </li>
            <li>
                <a href="/create">
                    <span><?php echo Yii::t('default', 'Interation') ?></span>
                    <blockquote>
                        <span><?php echo Yii::t('default', 'List user interation by date') ?>.</span>
                    </blockquote>
                </a>
            </li>
            

        </ul>
    </div>
</div>