<?php
$load = 'false';
if (isset($_POST['commonType']) && isset($_POST['cobjectTemplate'])
        && isset($_POST['cobjectTheme']) && isset($_POST['actGoal'])) {
    $commonType = $_POST['commonType'];
    $cobjectTemplate = $_POST['cobjectTemplate'];
    $cobjectTheme = $_POST['cobjectTheme'];
    $actGoal = $_POST['actGoal'];
    $name_commonType = CommonType::model()->findByPk($commonType);
    $name_commonType = $name_commonType->name;
    $name_cobjectTemplate = CobjectTemplate::model()->findByPk($cobjectTemplate);
    $name_cobjectTemplate = $name_cobjectTemplate->name;
    $name_cobjectTheme = CobjectTheme::model()->findByPk($cobjectTheme);
    $name_cobjectTheme = isset($name_cobjectTheme)? $name_cobjectTheme->name : "SEM TEMA";
    $name_actGoal = ActGoal::model()->findByPk($actGoal);
    $name_actGoal = $name_actGoal->name;
} elseif (isset($_GET['cID'])) {
    $cobjectID = $_GET['cID'];
    $load = 'true';
} elseif (isset($_POST['cobjectID'])) {
    $cobjectID = $_POST['cobjectID'];
    $load = 'true';
} else {
    throw new Exception('ERROR: RQEUEST Inválido');
}
$this->breadcrumbs = array(
    'Editor',
);
?>
<script language ="javascript" type="text/javascript">
<?php
if ($load == 'false') {
    $cobjectTheme = ($cobjectTheme!='') ? $cobjectTheme : -1 ;
    echo "newEditor.COtypeID = $commonType ; \n";
    echo "newEditor.COthemeID = $cobjectTheme; \n";
    echo "newEditor.COtemplateType = $cobjectTemplate; \n";
    echo "newEditor.COgoalID = $actGoal; \n";
} else {
    echo "newEditor.CObjectID = $cobjectID; \n";
}
echo "newEditor.isload = $load; \n";
?>
</script>

<header>
    <hgroup>
        <h1> Synapse Editor </h1>
        <ul>
            <li class="new"><?php echo Yii::t('default', 'New'); ?></li>
            <li class="save"><?php echo Yii::t('default', 'Save'); ?></li>
       
        </ul>
        <span class="clear"></span>
    </hgroup>
</header>
<div id="toolbar" class="toolbar">
    <h2><?php echo Yii::t('default', 'Add'); ?></h2>
    <ul class="tools">
        <li id="addPieceSet"><?php echo Yii::t('default', 'Add PieceSet'); ?></li>
        <li id="addimage"><?php echo Yii::t('default', 'Add Imagem'); ?></li>
    </ul>
</div>
<div class="canvas">
   <?php if (isset($_POST['commonType']) && isset($_POST['cobjectTemplate'])
        && isset($_POST['cobjectTheme']) && isset($_POST['actGoal'])) {  ?>
         <li class="title"> Tipo: <?php echo $name_commonType; ?> 
                &nbsp;&nbsp;Template: <?php echo $name_cobjectTemplate;  ?> 
               &nbsp;&nbsp;Tema: <?php echo $name_cobjectTheme;  ?> 
               <br>Objetivo: <?php echo $name_actGoal;  ?> 
         </li>
         <?php } ?>
         
    <button class="themebutton" id="addScreen"><?php echo Yii::t('default', 'Add Screen'); ?></button>
    <ul class="navscreen"></ul>
    <button class="themebutton" id="delScreen"><?php echo Yii::t('default', 'Remove Screen'); ?></button>
    <div id="loading"></div>
    <div id="cobject_description">
         <input type="text" class="actName" value="" />
    </div>
    <span class="clear"></span>
    <div class="content">
        <div class="screen" id="sc0">
        </div>
    </div>
</div>
