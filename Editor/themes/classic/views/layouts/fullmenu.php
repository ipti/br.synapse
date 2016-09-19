<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <!-- blueprint CSS framework -->
            <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/reset.css" media="screen, projection" />
            <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/print.css" media="print" />
            <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/global.css" />

            <!--[if lt IE 8]>
            <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/ie.css" media="screen, projection" />
            <![endif]-->
            <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery/jquery-2.0.2.min.js"></script>
            <link rel="stylesheet" type="text/css" href="/themes/classic/plugins/select2/css/select2.min.css" />
            <script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/select2/js/select2.min.js"></script>
            <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/jquery/jquery.ui.all.css" />
            <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/theme/yvj.full.css" />

            <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>
    <body>
        <div id="menu-top" class="barmenu">
            <span class="logoTag"><a href="<?php echo Yii::app()->baseUrl; ?>/"></a></span>
            <a href="<?php echo Yii::app()->baseUrl; ?>/site/logout" class="userInfo"></a>
            <?php
            $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                     array(
                        'label' => Yii::t('menu', 'Register'),
                        'url' => array('/person/index'),
                        'linkOptions' => array('id' => 'menuuser'),
                        'itemOptions' => array('id' => 'itemuser'),
                        'items' => array(
                            array('label' => Yii::t('menu', 'Unidade'), 'url' => array('/unity/index')),
                            array('label' => Yii::t('menu', 'Pessoa'), 'url' => array('/person/index')),
                        ),
                    ),
                    array(
                        'label' => Yii::t('menu', 'Usuário'),
                        'url' => array('/user/index'),
                        'linkOptions' => array('id' => 'menuuser'),
                        'itemOptions' => array('id' => 'itemuser'),
                        'items' => array(
                            array('label' => Yii::t('menu', 'Class'), 'url' => array('/userclass/index')),
                            array('label' => Yii::t('menu', 'Peformance'), 'url' => array('/peformance/index')),
                            array('label' => Yii::t('menu', 'Interation'), 'url' => array('/interation/index')),
                            array('label' => Yii::t('menu', 'System'), 'url' => array('/usersystem/index')),
                        ),
                    ),
                    array(
                        'label' => Yii::t('menu', 'Cobject'),
                        'url' => array('/cobject/index'),
                        'linkOptions' => array('id' => 'menuCobject'),
                        'itemOptions' => array('id' => 'itemCobject'),
                        'items' => array(
                            array('label' => Yii::t('menu', 'Template'), 'url' => array('/cobjectTemplate/index')),
                            array('label' =>  Yii::t('menu', 'Theme'), 'url' => array('/cobjectTheme/index')),
                            array('label' => Yii::t('menu', 'Block'), 'url' => array('/cobjectblock/index')),
                            array('label' => Yii::t('menu', 'Cobjects Block'), 'url' => array('/CobjectCobjectblock/admin')),
                            array('label' => Yii::t('menu', 'Editor'), 'url' => array('/editor/index')),
                            array('label' => Yii::t('menu', 'ExportarParaOffline'), 'url' => array('/render/exportToOffline')),
                            array('label' => Yii::t('menu', 'Renderizador'), 'url' => array('/render'))
                        ),
                    ),
                    array(
                        'label' => Yii::t('menu', 'Goal'),
                        'url' => array('/actGoal/index'),
                        'linkOptions' => array('id' => 'menuGoal'),
                        'itemOptions' => array('id' => 'itemGoal'),
                        'items' => array(
                            array('label' => Yii::t('menu', 'Modality'), 'url' => array('/actModality/index')),
                            array('label' => Yii::t('menu', 'Skill'), 'url' => array('/actSkill/index')),
                            array('label' => Yii::t('menu', 'Level'), 'url' => array('/actDegree/index')),
                            array('label' => Yii::t('menu', 'Matrix'), 'url' => array('/actMatrix/index')),
                        ),
                    ),
                    array(
                        'label' => Yii::t('menu', 'Content'),
                        'url' => array('/actContent/index'),
                        'linkOptions' => array('id' => 'menuContent'),
                        'items' => array(
                            array('label' => Yii::t('menu', 'Script'), 'url' => array('/actScript/index')),
                            array('label' => Yii::t('menu', 'Discipline'), 'url' => array('/actDiscipline/index')),
                        ),
                    ),
                     array(
                        'label' => Yii::t('menu', 'Library'),
                        'url' => array('/library/index'),
                        'linkOptions' => array('id' => 'menuLibrary')
                    ),
                    array(
                        'label' => Yii::t('menu', 'Advanced'),
                        'url' => array('/blog/post/index'),
                        'linkOptions' => array('id' => 'menuAdv'),
                        'items' => array(
                            array('label' => Yii::t('menu', 'Properties'), 'url' => array('/commonProperty/index')),
                            array('label' => Yii::t('menu', 'Types'), 'url' => array('/commonType/index')),
                            array('label' => Yii::t('menu', 'Alias'), 'url' => array('/matrix/index')),
                            array('label' => Yii::t('menu', 'Import/Export'), 'url' => array('/matrix/index')),
                        ),
                    )
                , array(
                        'label' => Yii::t('menu', 'Admin'),
                        'url' => array('/render/importFromEduCenso'),
                        'linkOptions' => array('id' => 'menuAdv'),

                    )
                ),
            ));
            ?>

        </div>
        <?php echo $content; ?>
        <!--<div class="footer">
            <div>
                Synapse - Version 0.1
            </div>
        </div>-->
    </body>
</html>
