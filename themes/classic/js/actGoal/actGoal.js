this.addItem = function (params) {
    //Verificar primeiro se esse Item já foi selecionado
    var strItem = "";
    switch (params) {
        case "ActGoalModality":
            if ($('#modalityItens').find('input[value=' + $('#modalityID').val() + ']').size() === 0
                    && $('#modalityID').val() !== null) {
                //Add Novo
                strItem += '<li><input type="hidden" value="' + $('#modalityID').val() + '" name="ActGoalModality[]">' +
                        $('#modalityID').find('option[value="' + $('#modalityID').val() + '"]').text()
                        + '  - <a id="' + $('#modalityID').val() + '"\n\
            onclick="delItem($(this))" href="javascript:void(0)">' + phpMsgRemove + '</a>';
                $('#modalityItens').append(strItem);
            }
            break;
        case "ActGoalSkill":
            if ($('#skillItens').find('input[value=' + $('#skillID').val() + ']').size() === 0
                    && $('#skillID').val() !== null) {
                //Add Novo
                strItem += '<li><input type="hidden" value="' + $('#skillID').val() + '" name="ActGoalSkill[]">' +
                        $('#skillID').find('option[value="' + $('#skillID').val() + '"]').text()
                        + '  - <a id="' + $('#skillID').val() + '"\n\
            onclick="delItem($(this))" href="javascript:void(0)">' + phpMsgRemove + '</a>';
                $('#skillItens').append(strItem);
            }
            ;
            break;
        case "ActGoalContent":
             if ($('#contentItens').find('input[value=' + $('#contentID').val() + ']').size() === 0
                     && $('#contentID').val() !== null) {
                //Add Novo
                strItem += '<li><input type="hidden" value="' + $('#contentID').val() + '" name="ActGoalContent[]">' +
                        $('#contentID').find('option[value="' + $('#contentID').val() + '"]').text()
                        + '  - <a id="' + $('#contentID').val() + '"\n\
            onclick="delItem($(this))" href="javascript:void(0)">' + phpMsgRemove + '</a>';
                $('#contentItens').append(strItem);
            }
            ;
            break;
    }
};

this.delItem = function (item) {
    item.closest('li').remove();
}


