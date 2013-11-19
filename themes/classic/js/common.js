function delItem(it){
    $(it).parent().remove();
}
function resetMultItens(){
    $(".multItens li").remove();
}
function updateLoad(type){
    switch(type)
    {
        case 'actGoal':
            url = '<?php echo $this->createUrl("/actGoal/loadcontent");?>';
            formID = '#act-goal-form';
            updateID = '#contentID';    
            break;
        case 'actMatrix':
            url = '<?php echo $this->createUrl("/actMatrix/loadgoal");?>';
            formID = '#act-matrix-form';
            updateID = '#goalID';    
            break;
        case 'actScript':
            url = '<?php echo $this->createUrl("/actScript/loadcontents");?>';
            formID = '#act-script-form';
            updateID = '.contents'; 
            break;
        case 'ActGoalSkill':

            break;
        case 'ActGoalContent':

            break;
                
        default:
    }
            
    jQuery.ajax({
        'type':'POST',
        'url':url,
        'cache':false,
        'data':$(formID).serialize(),
        'success':function(html){
            jQuery(updateID).html(html)
            }
        });
return false;
}
function addItem(type){
    var flagExist = 0;
    var message = '';
    var itensID = '';
    switch(type)
    {
        case 'UserClass':
            message = '<?php echo Yii::t("default", "Class already exist");?>';
            itensID = '.multItens';
            varname = 'UserUserclass[]';
            valueItem = $('#userClass option:selected').val();
            nameItem = $('#userClass option:selected').text();
            break;
        case 'UserclassMatrix':
            message = '<?php echo Yii::t("default", "Matrix already exist");?>';
            itensID = '.multItens';
            varname = 'UserclassMatrix[]';
            valueItem = $('#matrixID option:selected').val();
            nameItem = $('#disciplineID option:selected').text()+' | '+$('#matrixID option:selected').text();
            break;
        case 'ActGoalMatrix':
            itensID = '.multItens';
            message = '<?php echo Yii::t("default", "Goal already exist"); ?>';
            varname = 'ActGoalMatrix[]';
            valueItem = $('#goalID option:selected').val();
            nameItem = $('#goalID option:selected').text();
            break;
        case 'ActGoalModality':
            itensID = '#modalityItens'; 
            message = '<?php echo Yii::t("default", "Modality already exist"); ?>';
            varname = 'ActGoalModality[]';
            valueItem = $('#modalityID option:selected').val();
            nameItem = $('#modalityID option:selected').text();
            break;
        case 'ActGoalSkill':
            itensID = '#skillItens'; 
            message = '<?php echo Yii::t("default", "Skill already exist"); ?>';
            varname = 'ActGoalSkill[]';
            valueItem = $('#skillID option:selected').val();
            nameItem = $('#skillID option:selected').text();
            break;
        case 'ActGoalContent':
            itensID = '#contentItens'; 
            message = '<?php echo Yii::t("default", "Content already exist"); ?>';
            varname = 'ActGoalContent[]';
            valueItem = $('#contentID option:selected').val();
            nameItem = $('#contentID option:selected').text();
            break;
        case 'ActScriptContentOut':
            itensID = '#contentOutItens'; 
            message = '<?php echo Yii::t("default", "Contents out already exist"); ?>';
            varname = 'ActScriptContentOut[]';
            valueItem = $('#contentOutID option:selected').val();
            nameItem = $('#contentOutID option:selected').text();
            break;
        case 'ActScriptContentIn':
            itensID = '#contentInItens'; 
            message = '<?php echo Yii::t("default", "Contents in already exist");?>';
            varname = 'ActScriptContentIn[]';
            valueItem = $('#contentInID option:selected').val();
            nameItem = $('#contentInID option:selected').text();
            break;
                
        default:
    }
    $(itensID+' input').each(function(){
        if(valueItem == $(this).val()){
            flagExist = 1;
        }
    });
    if (flagExist == 1){
        alert(message);
    }
    else{
        $(itensID).append('<li><input type="hidden" value="'+valueItem+'" name="'+varname+'">'+nameItem+' - <a id="'+valueItem+'" onclick="delItem($(this))" href="javascript:void(0)"><?php echo Yii::t("default", "Remove");?></a>');
    }
}