<?php
$load = 'false';
if (isset($_POST['commonType']) && isset($_POST['cobjectTemplate']) && isset($_POST['cobjectTheme']) && isset($_POST['actGoal'])) {
    $commonType = $_POST['commonType'];
    $cobjectTemplate = $_POST['cobjectTemplate'];
    $cobjectTheme = $_POST['cobjectTheme'];
    $actGoal = $_POST['actGoal'];
    $name_commonType = CommonType::model()->findByPk($commonType);
    $name_commonType = $name_commonType->name;
    $name_cobjectTemplate = CobjectTemplate::model()->findByPk($cobjectTemplate);
    $name_cobjectTemplate = $name_cobjectTemplate->name;
    $name_cobjectTheme = CobjectTheme::model()->findByPk($cobjectTheme);
    $name_cobjectTheme = isset($name_cobjectTheme) ? $name_cobjectTheme->name : "SEM TEMA";
    $name_actGoal = ActGoal::model()->findByPk($actGoal);
    $name_actGoal = $name_actGoal->name;

    if (isset($_POST['actDiscipline'])) {
        $name_Discipline = ActDiscipline::model()->findByPk($_POST['actDiscipline']);
        $name_Discipline = $name_Discipline->name;
    } else {
        $name_Discipline = "SEM DISCIPLINA";
    }

    if (isset($_POST['actDegree'])) {
        $name_Degree = ActDegree::model()->findByPk($_POST['actDegree']);
        $name_Degree = $name_Degree->name;
    } else {
        $name_Degree = "SEM SÉRIE";
    }
} elseif (isset($_GET['cID'])) {
    $cobjectID = $_GET['cID'];
    $load = 'true';
} elseif (isset($_POST['cobjectID'])) {
    $cobjectID = $_POST['cobjectID'];
    $load = 'true';
} else {
    throw new Exception('ERROR: REQUEST Inválido');
}

if (isset($cobjectID)) {
    $viewRenderCobjet = Yii::app()->db->createCommand(""
                    . "SELECT DISTINCT(cobject_id), cobject_type, template_name,"
                    . " theme, goal, degree_name, discipline FROM render_cobjects "
                    . "WHERE cobject_id = $cobjectID ;")->queryAll();

    $name_commonType = $viewRenderCobjet[0]["cobject_type"];
    $name_cobjectTemplate = $viewRenderCobjet[0]["template_name"];
    $name_cobjectTheme = isset($viewRenderCobjet[0]["theme"]) && $viewRenderCobjet[0]["theme"] != "" ? $viewRenderCobjet[0]["theme"] : "SEM TEMA";
    $name_actGoal = $viewRenderCobjet[0]["goal"];
    $name_Discipline = $viewRenderCobjet[0]["discipline"];
    $name_Degree = $viewRenderCobjet[0]["degree_name"];
}

$this->breadcrumbs = array(
    'Editor',
);
?>
<script language ="javascript" type="text/javascript">
    $(document).ready(function () {
<?php
echo "newEditor.isload = $load; \n";
if ($load == 'false') {
    $cobjectTheme = ($cobjectTheme != '') ? $cobjectTheme : -1;
    echo "newEditor.COtypeID = $commonType ; \n";
    echo "newEditor.COthemeID = $cobjectTheme; \n";
    echo "newEditor.COtemplateType = $cobjectTemplate; \n";
    echo "newEditor.COgoalID = $actGoal; \n";
    echo "newEditor.addScreen(); \n ";
} else {
    echo "newEditor.CObjectID = $cobjectID; \n";
    //Sendo um load entao chama a funçao de Load
    echo "newEditor.load(); \n";
}
?>


    });

</script>

<header>
    <hgroup>
        <h1> Synapse Editor </h1>
        
        <span class="clear"></span>
    </hgroup>
</header>

<div class="canvas">
    
         <ul id="tools">
                <li id="addPieceSet" class="btn-tools"><?php echo Yii::t('default', 'Add PieceSet'); ?></li>
                <li id="addimage" class="btn-tools"><?php echo Yii::t('default', 'Add Imagem'); ?></li>
                <li id="addsound" class="btn-tools"><?php echo Yii::t('default', 'Add Sound'); ?></li>
                <li id="save" class="btn-tools"><?php echo Yii::t('default', 'Save'); ?></li>
                
                <li class="btn-addScreen btn-tools" id="btn-addScreen" >
                </li>
                <ul class="navscreen"></ul>   
                <li class="btn-delScreen btn-tools"  id="btn-delScreen">
                </li>
                
                <li class="loading">
                <div id="loading"></div>
                </li>

            </ul>        
    
    
    <li class="title"> Tipo: <?php echo $name_commonType; ?> 
        &nbsp;&nbsp;Template: <?php echo $name_cobjectTemplate; ?> 
        &nbsp;&nbsp;Tema: <?php echo $name_cobjectTheme; ?> 
        <br>Objetivo: <?php echo $name_actGoal; ?> 
        <br>Disciplina: <?php echo $name_Discipline; ?>
        &nbsp;&nbsp; Série: <?php echo $name_Degree; ?>
    </li>


    <div id="cobject_description">
        <input type="text" class="actName" id ="COdescription" value="" />
        <div class="clear"></div>  
    </div>

    <div class="content">
        
    </div>
    
</div>
