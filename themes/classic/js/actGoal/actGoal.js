this.addItem = function (params) {
    //Verificar primeiro se esse Item já foi selecionado
    var strItem = "";
    switch (params) {
        case "ActGoalModality":
            console.log($('#modalityItens').find('input[value=1]'));
            
            if ($('#modalityItens').find('input[value=' + $('#modalityID').val() + ']').size() === 0) {
                //Add Novo
                strItem += '<li><input type="hidden" value="\n\
            ' + $('#modalityID').val() + '" name="ActGoalModality[]">' +
                        $('#modalityID').find('option[value="' + $('#modalityID').val() + '"]').text()
                        + '  - <a id="$modality->modality_id"\n\
            onclick="delItem($(this))" href="javascript:void(0)">' + phpMsgRemove + '</a>';
                $('#modalityItens').append(strItem);

            }
            break;
        case "ActGoalSkill":
            console.log("ActGoalSkill");
            ;
            break;
        case "ActGoalContent":
            console.log("ActGoalContent");
            ;
            break;
    }







};


