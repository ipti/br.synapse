   function delItem(it){
        $(it).parent().remove();
    }
    function resetMultItens(){
        $(".multItens li").remove();
    }
    function addItem(type){
        var flagExist = 0;
        var message = '';
        var itensID = '';
        switch(type)
            {
            case 'UserClass':
                message = '<?php echo Yii::t('default', 'Class already exist') ?>';
                itensID = '.multItens';
                varname = 'UserUserclass[]';
                valueItem = $('#userClass option:selected').val();
                nameItem = $('#userClass option:selected').text();
                break;
            case 'UserclassMatrix':
                message = '<?php echo Yii::t('default', 'Matrix already exist') ?>';
                itensID = '.multItens';
                varname = 'UserclassMatrix[]';
                valueItem = $('#matrixID option:selected').val();
                nameItem = $('#disciplineID option:selected').text()+' | '+$('#matrixID option:selected').text();
                break;
            case 'ActGoalMatrix':
                itensID = '.multItens';
                message = '<?php echo Yii::t('default', 'Goal already exist') ?>';
                varname = 'ActGoalMatrix[]';
                valueItem = $('#goalID option:selected').val();
                nameItem = $('#goalID option:selected').text();
                break;
             case 'ActGoalModality':
                itensID = '#modalityItens'; 
                message = '<?php echo Yii::t('default', 'Modality already exist') ?>';
                varname = 'ActGoalModality[]';
                valueItem = $('#modalityID option:selected').val();
                nameItem = $('#modalityID option:selected').text();
                break;
             case 'ActGoalSkill':
                itensID = '#skillItens'; 
                message = '<?php echo Yii::t('default', 'Skill already exist') ?>';
                varname = 'ActGoalSkill[]';
                valueItem = $('#skillID option:selected').val();
                nameItem = $('#skillID option:selected').text();
                break;
            case 'ActGoalContent':
                itensID = '#contentItens'; 
                message = '<?php echo Yii::t('default', 'Content already exist') ?>';
                varname = 'ActGoalContent[]';
                valueItem = $('#contentID option:selected').val();
                nameItem = $('#contentID option:selected').text();
                break;
                
            default:
            }
            $(itensID+' input').each(function(){
                if(valueItem == $(this).val()){
                    flagExist = 1
                }
            })
            if (flagExist == 1){
                alert(message);
            }
            else{
                $(itensID).append('<li><input type="hidden" value="'+valueItem+'" name="'+varname+'">'+nameItem+' - <a id="'+valueItem+'" onclick="delItem($(this))" href="javascript:void(0)"><?php echo Yii::t('default', 'Remove') ?></a>');
            }
        }
